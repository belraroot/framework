<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Event;

use Doctrine\Deprecations\Deprecation;
use Calculus\Database\Fluent\EntityManagerInterface;
use Doctrine\Persistence\Event\ManagerEventArgs;

/**
 * Provides event arguments for the preFlush event.
 *
 * @link        www.doctrine-project.com
 *
 * @extends ManagerEventArgs<EntityManagerInterface>
 */
class PreFlushEventArgs extends ManagerEventArgs
{
    /**
     * @deprecated 2.13. Use {@see getObjectManager} instead.
     *
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        Deprecation::trigger(
            'doctrine/orm',
            'https://github.com/doctrine/orm/issues/9875',
            'Method %s() is deprecated and will be removed in Doctrine ORM 3.0. Use getObjectManager() instead.',
            __METHOD__
        );

        return $this->getObjectManager();
    }
}
