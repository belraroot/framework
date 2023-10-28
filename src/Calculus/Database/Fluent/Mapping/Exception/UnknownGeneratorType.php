<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping\Exception;

use Calculus\Database\Fluent\Exception\ORMException;

final class UnknownGeneratorType extends ORMException
{
    public static function create(int $generatorType): self
    {
        return new self('Unknown generator type: ' . $generatorType);
    }
}
