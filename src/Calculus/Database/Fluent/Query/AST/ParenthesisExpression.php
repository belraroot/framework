<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * ParenthesisExpression ::= "(" ArithmeticPrimary ")"
 */
class ParenthesisExpression extends Node
{
    /** @var Node */
    public $expression;

    public function __construct(Node $expression)
    {
        $this->expression = $expression;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($walker)
    {
        return $walker->walkParenthesisExpression($this);
    }
}
