<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Region;

use Calculus\Database\Fluent\Cache\CacheKey;
use Calculus\Database\Fluent\Cache\TimestampCacheEntry;
use Calculus\Database\Fluent\Cache\TimestampRegion;

/**
 * Tracks the timestamps of the most recent updates to particular keys.
 */
class UpdateTimestampCache extends DefaultRegion implements TimestampRegion
{
    /**
     * {@inheritDoc}
     */
    public function update(CacheKey $key)
    {
        $this->put($key, new TimestampCacheEntry());
    }
}
