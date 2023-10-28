<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * Marks types that can be used in place of a ConditionalExpression as a phase
 * 2 optimization.
 *
 * @internal
 *
 * @psalm-inheritors ConditionalPrimary|ConditionalFactor|ConditionalTerm
 */
interface Phase2OptimizableConditional
{
}
