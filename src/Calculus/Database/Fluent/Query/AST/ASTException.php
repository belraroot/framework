<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

use Calculus\Database\Fluent\Query\QueryException;

use function get_debug_type;

/**
 * Base exception class for AST exceptions.
 */
class ASTException extends QueryException
{
    /**
     * @param Node $node
     *
     * @return ASTException
     */
    public static function noDispatchForNode($node)
    {
        return new self('Double-dispatch for node ' . get_debug_type($node) . ' is not supported.');
    }
}
