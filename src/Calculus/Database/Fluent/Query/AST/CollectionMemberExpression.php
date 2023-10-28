<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

/**
 * CollectionMemberExpression ::= EntityExpression ["NOT"] "MEMBER" ["OF"] CollectionValuedPathExpression
 *
 * @link    www.doctrine-project.org
 */
class CollectionMemberExpression extends Node
{
    /** @var mixed */
    public $entityExpression;

    /** @var PathExpression */
    public $collectionValuedPathExpression;

    /** @var bool */
    public $not;

    /**
     * @param mixed          $entityExpr
     * @param PathExpression $collValuedPathExpr
     */
    public function __construct($entityExpr, $collValuedPathExpr, bool $not = false)
    {
        $this->entityExpression               = $entityExpr;
        $this->collectionValuedPathExpression = $collValuedPathExpr;
        $this->not                            = $not;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($walker)
    {
        return $walker->walkCollectionMemberExpression($this);
    }
}
