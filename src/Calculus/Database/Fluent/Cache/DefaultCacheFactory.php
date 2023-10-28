<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache;

use Doctrine\Common\Cache\Cache as LegacyCache;
use Doctrine\Common\Cache\Psr6\CacheAdapter;
use Doctrine\Deprecations\Deprecation;
use Calculus\Database\Fluent\Cache;
use Calculus\Database\Fluent\Cache\Persister\Collection\NonStrictReadWriteCachedCollectionPersister;
use Calculus\Database\Fluent\Cache\Persister\Collection\ReadOnlyCachedCollectionPersister;
use Calculus\Database\Fluent\Cache\Persister\Collection\ReadWriteCachedCollectionPersister;
use Calculus\Database\Fluent\Cache\Persister\Entity\NonStrictReadWriteCachedEntityPersister;
use Calculus\Database\Fluent\Cache\Persister\Entity\ReadOnlyCachedEntityPersister;
use Calculus\Database\Fluent\Cache\Persister\Entity\ReadWriteCachedEntityPersister;
use Calculus\Database\Fluent\Cache\Region\DefaultRegion;
use Calculus\Database\Fluent\Cache\Region\FileLockRegion;
use Calculus\Database\Fluent\Cache\Region\UpdateTimestampCache;
use Calculus\Database\Fluent\EntityManagerInterface;
use Calculus\Database\Fluent\Mapping\ClassMetadata;
use Calculus\Database\Fluent\Persisters\Collection\CollectionPersister;
use Calculus\Database\Fluent\Persisters\Entity\EntityPersister;
use InvalidArgumentException;
use LogicException;
use Psr\Cache\CacheItemPoolInterface;
use TypeError;

use function assert;
use function get_debug_type;
use function sprintf;

use const DIRECTORY_SEPARATOR;

class DefaultCacheFactory implements CacheFactory
{
    /** @var CacheItemPoolInterface */
    private $cacheItemPool;

    /** @var RegionsConfiguration */
    private $regionsConfig;

    /** @var TimestampRegion|null */
    private $timestampRegion;

    /** @var Region[] */
    private $regions = [];

    /** @var string|null */
    private $fileLockRegionDirectory;

    /** @param CacheItemPoolInterface $cacheItemPool */
    public function __construct(RegionsConfiguration $cacheConfig, $cacheItemPool)
    {
        if ($cacheItemPool instanceof LegacyCache) {
            Deprecation::trigger(
                'doctrine/orm',
                'https://github.com/doctrine/orm/pull/9322',
                'Passing an instance of %s to %s is deprecated, pass a %s instead.',
                get_debug_type($cacheItemPool),
                __METHOD__,
                CacheItemPoolInterface::class
            );

            $this->cacheItemPool = CacheAdapter::wrap($cacheItemPool);
        } elseif (! $cacheItemPool instanceof CacheItemPoolInterface) {
            throw new TypeError(sprintf(
                '%s: Parameter #2 is expected to be an instance of %s, got %s.',
                __METHOD__,
                CacheItemPoolInterface::class,
                get_debug_type($cacheItemPool)
            ));
        } else {
            $this->cacheItemPool = $cacheItemPool;
        }

        $this->regionsConfig = $cacheConfig;
    }

    /**
     * @param string $fileLockRegionDirectory
     *
     * @return void
     */
    public function setFileLockRegionDirectory($fileLockRegionDirectory)
    {
        $this->fileLockRegionDirectory = (string) $fileLockRegionDirectory;
    }

    /** @return string */
    public function getFileLockRegionDirectory()
    {
        return $this->fileLockRegionDirectory;
    }

    /** @return void */
    public function setRegion(Region $region)
    {
        $this->regions[$region->getName()] = $region;
    }

    /** @return void */
    public function setTimestampRegion(TimestampRegion $region)
    {
        $this->timestampRegion = $region;
    }

    /**
     * {@inheritDoc}
     */
    public function buildCachedEntityPersister(EntityManagerInterface $em, EntityPersister $persister, ClassMetadata $metadata)
    {
        assert($metadata->cache !== null);
        $region = $this->getRegion($metadata->cache);
        $usage  = $metadata->cache['usage'];

        if ($usage === ClassMetadata::CACHE_USAGE_READ_ONLY) {
            return new ReadOnlyCachedEntityPersister($persister, $region, $em, $metadata);
        }

        if ($usage === ClassMetadata::CACHE_USAGE_NONSTRICT_READ_WRITE) {
            return new NonStrictReadWriteCachedEntityPersister($persister, $region, $em, $metadata);
        }

        if ($usage === ClassMetadata::CACHE_USAGE_READ_WRITE) {
            if (! $region instanceof ConcurrentRegion) {
                throw new InvalidArgumentException(sprintf('Unable to use access strategy type of [%s] without a ConcurrentRegion', $usage));
            }

            return new ReadWriteCachedEntityPersister($persister, $region, $em, $metadata);
        }

        throw new InvalidArgumentException(sprintf('Unrecognized access strategy type [%s]', $usage));
    }

    /**
     * {@inheritDoc}
     */
    public function buildCachedCollectionPersister(EntityManagerInterface $em, CollectionPersister $persister, array $mapping)
    {
        assert(isset($mapping['cache']));
        $usage  = $mapping['cache']['usage'];
        $region = $this->getRegion($mapping['cache']);

        if ($usage === ClassMetadata::CACHE_USAGE_READ_ONLY) {
            return new ReadOnlyCachedCollectionPersister($persister, $region, $em, $mapping);
        }

        if ($usage === ClassMetadata::CACHE_USAGE_NONSTRICT_READ_WRITE) {
            return new NonStrictReadWriteCachedCollectionPersister($persister, $region, $em, $mapping);
        }

        if ($usage === ClassMetadata::CACHE_USAGE_READ_WRITE) {
            if (! $region instanceof ConcurrentRegion) {
                throw new InvalidArgumentException(sprintf('Unable to use access strategy type of [%s] without a ConcurrentRegion', $usage));
            }

            return new ReadWriteCachedCollectionPersister($persister, $region, $em, $mapping);
        }

        throw new InvalidArgumentException(sprintf('Unrecognized access strategy type [%s]', $usage));
    }

    /**
     * {@inheritDoc}
     */
    public function buildQueryCache(EntityManagerInterface $em, $regionName = null)
    {
        return new DefaultQueryCache(
            $em,
            $this->getRegion(
                [
                    'region' => $regionName ?: Cache::DEFAULT_QUERY_REGION_NAME,
                    'usage'  => ClassMetadata::CACHE_USAGE_NONSTRICT_READ_WRITE,
                ]
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function buildCollectionHydrator(EntityManagerInterface $em, array $mapping)
    {
        return new DefaultCollectionHydrator($em);
    }

    /**
     * {@inheritDoc}
     */
    public function buildEntityHydrator(EntityManagerInterface $em, ClassMetadata $metadata)
    {
        return new DefaultEntityHydrator($em);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegion(array $cache)
    {
        if (isset($this->regions[$cache['region']])) {
            return $this->regions[$cache['region']];
        }

        $name     = $cache['region'];
        $lifetime = $this->regionsConfig->getLifetime($cache['region']);
        $region   = new DefaultRegion($name, $this->cacheItemPool, $lifetime);

        if ($cache['usage'] === ClassMetadata::CACHE_USAGE_READ_WRITE) {
            if (
                $this->fileLockRegionDirectory === '' ||
                $this->fileLockRegionDirectory === null
            ) {
                throw new LogicException(
                    'If you want to use a "READ_WRITE" cache an implementation of "Doctrine\ORM\Cache\ConcurrentRegion" is required, ' .
                    'The default implementation provided by doctrine is "Doctrine\ORM\Cache\Region\FileLockRegion" if you want to use it please provide a valid directory, DefaultCacheFactory#setFileLockRegionDirectory(). '
                );
            }

            $directory = $this->fileLockRegionDirectory . DIRECTORY_SEPARATOR . $cache['region'];
            $region    = new FileLockRegion($region, $directory, (string) $this->regionsConfig->getLockLifetime($cache['region']));
        }

        return $this->regions[$cache['region']] = $region;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestampRegion()
    {
        if ($this->timestampRegion === null) {
            $name     = Cache::DEFAULT_TIMESTAMP_REGION_NAME;
            $lifetime = $this->regionsConfig->getLifetime($name);

            $this->timestampRegion = new UpdateTimestampCache($name, $this->cacheItemPool, $lifetime);
        }

        return $this->timestampRegion;
    }

    /**
     * {@inheritDoc}
     */
    public function createCache(EntityManagerInterface $entityManager)
    {
        return new DefaultCache($entityManager);
    }
}
