<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * ConditionalFactor ::= ["NOT"] ConditionalPrimary
 *
 * @link    www.doctrine-project.org
 */
class ConditionalFactor extends Node implements Phase2OptimizableConditional
{
    /** @var bool */
    public $not = false;

    /** @var ConditionalPrimary */
    public $conditionalPrimary;

    /** @param ConditionalPrimary $conditionalPrimary */
    public function __construct($conditionalPrimary, bool $not = false)
    {
        $this->conditionalPrimary = $conditionalPrimary;
        $this->not                = $not;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($sqlWalker)
    {
        return $sqlWalker->walkConditionalFactor($this);
    }
}
