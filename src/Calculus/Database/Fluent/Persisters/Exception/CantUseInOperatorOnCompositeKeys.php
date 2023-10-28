<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Persisters\Exception;

use Calculus\Database\Fluent\Exception\PersisterException;

class CantUseInOperatorOnCompositeKeys extends PersisterException
{
    public static function create(): self
    {
        return new self("Can't use IN operator on entities that have composite keys.");
    }
}
