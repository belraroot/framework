<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Persister\Entity;

use Calculus\Database\Fluent\Cache\EntityCacheKey;
use Calculus\Database\Fluent\Cache\EntityHydrator;
use Calculus\Database\Fluent\Cache\Persister\CachedPersister;
use Calculus\Database\Fluent\Persisters\Entity\EntityPersister;

/**
 * Interface for second level cache entity persisters.
 */
interface CachedEntityPersister extends CachedPersister, EntityPersister
{
    /** @return EntityHydrator */
    public function getEntityHydrator();

    /**
     * @param object $entity
     *
     * @return bool
     */
    public function storeEntityCache($entity, EntityCacheKey $key);
}
