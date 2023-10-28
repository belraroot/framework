<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache;

use Doctrine\Common\Collections\Collection;
use Calculus\Database\Fluent\Mapping\ClassMetadata;
use Calculus\Database\Fluent\PersistentCollection;

/**
 * Hydrator cache entry for collections
 */
interface CollectionHydrator
{
    /**
     * @param array|mixed[]|Collection $collection The collection.
     *
     * @return CollectionCacheEntry
     */
    public function buildCacheEntry(ClassMetadata $metadata, CollectionCacheKey $key, $collection);

    /** @return mixed[]|null */
    public function loadCacheEntry(ClassMetadata $metadata, CollectionCacheKey $key, CollectionCacheEntry $entry, PersistentCollection $collection);
}
