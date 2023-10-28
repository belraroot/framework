<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Exception;

final class QueryCacheNotConfigured extends CacheException
{
    public static function create(): self
    {
        return new self('Query Cache is not configured.');
    }
}
