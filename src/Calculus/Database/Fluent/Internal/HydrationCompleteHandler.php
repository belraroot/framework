<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Internal;

use Calculus\Database\Fluent\EntityManagerInterface;
use Calculus\Database\Fluent\Event\ListenersInvoker;
use Calculus\Database\Fluent\Event\PostLoadEventArgs;
use Calculus\Database\Fluent\Events;
use Calculus\Database\Fluent\Mapping\ClassMetadata;

/**
 * Class, which can handle completion of hydration cycle and produce some of tasks.
 * In current implementation triggers deferred postLoad event.
 */
final class HydrationCompleteHandler
{
    /** @var ListenersInvoker */
    private $listenersInvoker;

    /** @var EntityManagerInterface */
    private $em;

    /** @var mixed[][] */
    private $deferredPostLoadInvocations = [];

    /**
     * Constructor for this object
     */
    public function __construct(ListenersInvoker $listenersInvoker, EntityManagerInterface $em)
    {
        $this->listenersInvoker = $listenersInvoker;
        $this->em               = $em;
    }

    /**
     * Method schedules invoking of postLoad entity to the very end of current hydration cycle.
     *
     * @param object $entity
     */
    public function deferPostLoadInvoking(ClassMetadata $class, $entity): void
    {
        $invoke = $this->listenersInvoker->getSubscribedSystems($class, Events::postLoad);

        if ($invoke === ListenersInvoker::INVOKE_NONE) {
            return;
        }

        $this->deferredPostLoadInvocations[] = [$class, $invoke, $entity];
    }

    /**
     * This method should be called after any hydration cycle completed.
     *
     * Method fires all deferred invocations of postLoad events
     */
    public function hydrationComplete(): void
    {
        $toInvoke                          = $this->deferredPostLoadInvocations;
        $this->deferredPostLoadInvocations = [];

        foreach ($toInvoke as $classAndEntity) {
            [$class, $invoke, $entity] = $classAndEntity;

            $this->listenersInvoker->invoke(
                $class,
                Events::postLoad,
                $entity,
                new PostLoadEventArgs($entity, $this->em),
                $invoke
            );
        }
    }
}
