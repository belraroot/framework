<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Tools\Pagination;

use Calculus\Database\Fluent\Query\AST\Functions\FunctionNode;
use Calculus\Database\Fluent\Query\AST\OrderByClause;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;
use Calculus\Database\Fluent\Tools\Pagination\Exception\RowNumberOverFunctionNotEnabled;

use function trim;

/**
 * RowNumberOverFunction
 *
 * Provides ROW_NUMBER() OVER(ORDER BY...) construct for use in LimitSubqueryOutputWalker
 */
class RowNumberOverFunction extends FunctionNode
{
    /** @var OrderByClause */
    public $orderByClause;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'ROW_NUMBER() OVER(' . trim($sqlWalker->walkOrderByClause(
            $this->orderByClause
        )) . ')';
    }

    /**
     * @throws RowNumberOverFunctionNotEnabled
     *
     * @inheritDoc
     */
    public function parse(Parser $parser)
    {
        throw RowNumberOverFunctionNotEnabled::create();
    }
}
