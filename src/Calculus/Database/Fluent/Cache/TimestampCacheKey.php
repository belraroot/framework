<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache;

/**
 * A key that identifies a timestamped space.
 */
class TimestampCacheKey extends CacheKey
{
    /** @param string $space Result cache id */
    public function __construct($space)
    {
        parent::__construct((string) $space);
    }
}
