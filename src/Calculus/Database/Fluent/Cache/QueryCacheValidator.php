<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache;

/**
 * Cache query validator interface.
 */
interface QueryCacheValidator
{
    /**
     * Checks if the query entry is valid
     *
     * @return bool
     */
    public function isValid(QueryCacheKey $key, QueryCacheEntry $entry);
}
