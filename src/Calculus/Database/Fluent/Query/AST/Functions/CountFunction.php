<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Calculus\Database\Fluent\Query\AST\AggregateExpression;
use Calculus\Database\Fluent\Query\AST\TypedExpression;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "COUNT" "(" ["DISTINCT"] StringPrimary ")"
 */
final class CountFunction extends FunctionNode implements TypedExpression
{
    /** @var AggregateExpression */
    private $aggregateExpression;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return $this->aggregateExpression->dispatch($sqlWalker);
    }

    public function parse(Parser $parser): void
    {
        $this->aggregateExpression = $parser->AggregateExpression();
    }

    public function getReturnType(): Type
    {
        return Type::getType(Types::INTEGER);
    }
}
