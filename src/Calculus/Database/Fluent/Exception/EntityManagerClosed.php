<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Exception;

final class EntityManagerClosed extends ORMException implements ManagerException
{
    public static function create(): self
    {
        return new self('The EntityManager is closed.');
    }
}
