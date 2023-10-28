<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * SimpleArithmeticExpression ::= ArithmeticTerm {("+" | "-") ArithmeticTerm}*
 *
 * @link    www.doctrine-project.org
 */
class SimpleArithmeticExpression extends Node
{
    /** @var mixed[] */
    public $arithmeticTerms = [];

    /** @param mixed[] $arithmeticTerms */
    public function __construct(array $arithmeticTerms)
    {
        $this->arithmeticTerms = $arithmeticTerms;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($sqlWalker)
    {
        return $sqlWalker->walkSimpleArithmeticExpression($this);
    }
}
