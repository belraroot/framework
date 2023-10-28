<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Exception;

use Calculus\Database\Fluent\Cache\Exception\CacheException;

use function sprintf;

final class UnexpectedAssociationValue extends CacheException
{
    public static function create(
        string $class,
        string $association,
        string $given,
        string $expected
    ): self {
        return new self(sprintf(
            'Found entity of type %s on association %s#%s, but expecting %s',
            $given,
            $class,
            $association,
            $expected
        ));
    }
}
