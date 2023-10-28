<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST;

class GroupByClause extends Node
{
    /** @var mixed[] */
    public $groupByItems = [];

    /** @param mixed[] $groupByItems */
    public function __construct(array $groupByItems)
    {
        $this->groupByItems = $groupByItems;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch($sqlWalker)
    {
        return $sqlWalker->walkGroupByClause($this);
    }
}
