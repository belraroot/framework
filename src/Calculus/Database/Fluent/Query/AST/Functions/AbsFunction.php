<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\SimpleArithmeticExpression;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "ABS" "(" SimpleArithmeticExpression ")"
 *
 * @link    www.doctrine-project.org
 */
class AbsFunction extends FunctionNode
{
    /** @var SimpleArithmeticExpression */
    public $simpleArithmeticExpression;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'ABS(' . $sqlWalker->walkSimpleArithmeticExpression(
            $this->simpleArithmeticExpression
        ) . ')';
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
