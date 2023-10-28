<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Persister\Collection;

use Doctrine\Common\Util\ClassUtils;
use Calculus\Database\Fluent\Cache\Exception\CannotUpdateReadOnlyCollection;
use Calculus\Database\Fluent\PersistentCollection;

class ReadOnlyCachedCollectionPersister extends NonStrictReadWriteCachedCollectionPersister
{
     /**
      * {@inheritDoc}
      */
    public function update(PersistentCollection $collection)
    {
        if ($collection->isDirty() && $collection->getSnapshot()) {
            throw CannotUpdateReadOnlyCollection::fromEntityAndField(
                ClassUtils::getClass($collection->getOwner()),
                $this->association['fieldName']
            );
        }

        parent::update($collection);
    }
}
