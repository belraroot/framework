<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Exception;

final class MismatchedEventManager extends ORMException implements ManagerException
{
    public static function create(): self
    {
        return new self(
            'Cannot use different EventManager instances for EntityManager and Connection.'
        );
    }
}
