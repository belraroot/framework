<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Internal\Hydration;

use Doctrine\DBAL\Driver\Exception;
use Calculus\Database\Fluent\Exception\MultipleSelectorsFoundException;

use function array_column;
use function count;

/**
 * Hydrator that produces one-dimensional array.
 */
final class ScalarColumnHydrator extends AbstractHydrator
{
    /**
     * {@inheritDoc}
     *
     * @throws MultipleSelectorsFoundException
     * @throws Exception
     */
    protected function hydrateAllData(): array
    {
        if (count($this->resultSetMapping()->fieldMappings) > 1) {
            throw MultipleSelectorsFoundException::create($this->resultSetMapping()->fieldMappings);
        }

        $result = $this->statement()->fetchAllNumeric();

        return array_column($result, 0);
    }
}
