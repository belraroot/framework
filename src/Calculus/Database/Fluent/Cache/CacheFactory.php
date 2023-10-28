<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache;

use Calculus\Database\Fluent\Cache;
use Calculus\Database\Fluent\Cache\Persister\Collection\CachedCollectionPersister;
use Calculus\Database\Fluent\Cache\Persister\Entity\CachedEntityPersister;
use Calculus\Database\Fluent\EntityManagerInterface;
use Calculus\Database\Fluent\Mapping\ClassMetadata;
use Calculus\Database\Fluent\Persisters\Collection\CollectionPersister;
use Calculus\Database\Fluent\Persisters\Entity\EntityPersister;

/**
 * Contract for building second level cache regions components.
 *
 * @psalm-import-type AssociationMapping from ClassMetadata
 */
interface CacheFactory
{
    /**
     * Build an entity persister for the given entity metadata.
     *
     * @param EntityManagerInterface $em        The entity manager.
     * @param EntityPersister        $persister The entity persister that will be cached.
     * @param ClassMetadata          $metadata  The entity metadata.
     *
     * @return CachedEntityPersister
     */
    public function buildCachedEntityPersister(EntityManagerInterface $em, EntityPersister $persister, ClassMetadata $metadata);

    /**
     * Build a collection persister for the given relation mapping.
     *
     * @param AssociationMapping $mapping The association mapping.
     *
     * @return CachedCollectionPersister
     */
    public function buildCachedCollectionPersister(EntityManagerInterface $em, CollectionPersister $persister, array $mapping);

    /**
     * Build a query cache based on the given region name
     *
     * @param string|null $regionName The region name.
     *
     * @return QueryCache The built query cache.
     */
    public function buildQueryCache(EntityManagerInterface $em, $regionName = null);

    /**
     * Build an entity hydrator
     *
     * @return EntityHydrator The built entity hydrator.
     */
    public function buildEntityHydrator(EntityManagerInterface $em, ClassMetadata $metadata);

    /**
     * Build a collection hydrator
     *
     * @param mixed[] $mapping The association mapping.
     *
     * @return CollectionHydrator The built collection hydrator.
     */
    public function buildCollectionHydrator(EntityManagerInterface $em, array $mapping);

    /**
     * Build a cache region
     *
     * @param array<string,mixed> $cache The cache configuration.
     *
     * @return Region The cache region.
     */
    public function getRegion(array $cache);

    /**
     * Build timestamp cache region
     *
     * @return TimestampRegion The timestamp region.
     */
    public function getTimestampRegion();

    /**
     * Build \Doctrine\ORM\Cache
     *
     * @return Cache
     */
    public function createCache(EntityManagerInterface $entityManager);
}
