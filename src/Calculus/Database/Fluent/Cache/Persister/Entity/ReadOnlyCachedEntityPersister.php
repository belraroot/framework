<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Persister\Entity;

use Doctrine\Common\Util\ClassUtils;
use Calculus\Database\Fluent\Cache\Exception\CannotUpdateReadOnlyEntity;

/**
 * Specific read-only region entity persister
 */
class ReadOnlyCachedEntityPersister extends NonStrictReadWriteCachedEntityPersister
{
    /**
     * {@inheritDoc}
     */
    public function update($entity)
    {
        throw CannotUpdateReadOnlyEntity::fromEntity(ClassUtils::getClass($entity));
    }
}
