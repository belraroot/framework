<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Persister\Collection;

use Doctrine\Common\Collections\Collection;
use Calculus\Database\Fluent\Cache\CollectionCacheKey;
use Calculus\Database\Fluent\Cache\Persister\CachedPersister;
use Calculus\Database\Fluent\Mapping\ClassMetadata;
use Calculus\Database\Fluent\PersistentCollection;
use Calculus\Database\Fluent\Persisters\Collection\CollectionPersister;

/**
 * Interface for second level cache collection persisters.
 */
interface CachedCollectionPersister extends CachedPersister, CollectionPersister
{
    /** @return ClassMetadata */
    public function getSourceEntityMetadata();

    /** @return ClassMetadata */
    public function getTargetEntityMetadata();

    /**
     * Loads a collection from cache
     *
     * @return mixed[]|null
     */
    public function loadCollectionCache(PersistentCollection $collection, CollectionCacheKey $key);

    /**
     * Stores a collection into cache
     *
     * @param mixed[]|Collection $elements
     *
     * @return void
     */
    public function storeCollectionCache(CollectionCacheKey $key, $elements);
}
