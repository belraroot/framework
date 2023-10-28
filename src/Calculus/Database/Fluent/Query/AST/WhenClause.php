<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * WhenClause ::= "WHEN" ConditionalExpression "THEN" ScalarExpression
 *
 * @link    www.doctrine-project.org
 */
class WhenClause extends Node
{
    /** @var ConditionalExpression|Phase2OptimizableConditional */
    public $caseConditionExpression;

    /** @var mixed */
    public $thenScalarExpression = null;

    /**
     * @param ConditionalExpression|Phase2OptimizableConditional $caseConditionExpression
     * @param mixed                                              $thenScalarExpression
     */
    public function __construct($caseConditionExpression, $thenScalarExpression)
    {
        $this->caseConditionExpression = $caseConditionExpression;
        $this->thenScalarExpression    = $thenScalarExpression;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($sqlWalker)
    {
        return $sqlWalker->walkWhenClauseExpression($this);
    }
}
