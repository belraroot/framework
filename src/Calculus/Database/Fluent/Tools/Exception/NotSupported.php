<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Tools\Exception;

use Calculus\Database\Fluent\Exception\ORMException;
use Calculus\Database\Fluent\Exception\SchemaToolException;

final class NotSupported extends ORMException implements SchemaToolException
{
    public static function create(): self
    {
        return new self('This behaviour is (currently) not supported by Doctrine 2');
    }
}
