<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Cache\Persister;

use Calculus\Database\Fluent\Cache\Region;

/**
 * Interface for persister that support second level cache.
 */
interface CachedPersister
{
    /**
     * Perform whatever processing is encapsulated here after completion of the transaction.
     *
     * @return void
     */
    public function afterTransactionComplete();

    /**
     * Perform whatever processing is encapsulated here after completion of the rolled-back.
     *
     * @return void
     */
    public function afterTransactionRolledBack();

    /**
     * Gets the The region access.
     *
     * @return Region
     */
    public function getCacheRegion();
}
