<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * GeneralCaseExpression ::= "CASE" WhenClause {WhenClause}* "ELSE" ScalarExpression "END"
 *
 * @link    www.doctrine-project.org
 */
class GeneralCaseExpression extends Node
{
    /** @var mixed[] */
    public $whenClauses = [];

    /** @var mixed */
    public $elseScalarExpression = null;

    /**
     * @param mixed[] $whenClauses
     * @param mixed   $elseScalarExpression
     */
    public function __construct(array $whenClauses, $elseScalarExpression)
    {
        $this->whenClauses          = $whenClauses;
        $this->elseScalarExpression = $elseScalarExpression;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($sqlWalker)
    {
        return $sqlWalker->walkGeneralCaseExpression($this);
    }
}
