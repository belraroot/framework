<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\SimpleArithmeticExpression;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "MOD" "(" SimpleArithmeticExpression "," SimpleArithmeticExpression ")"
 *
 * @link    www.doctrine-project.org
 */
class ModFunction extends FunctionNode
{
    /** @var SimpleArithmeticExpression */
    public $firstSimpleArithmeticExpression;

    /** @var SimpleArithmeticExpression */
    public $secondSimpleArithmeticExpression;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getModExpression(
            $sqlWalker->walkSimpleArithmeticExpression($this->firstSimpleArithmeticExpression),
            $sqlWalker->walkSimpleArithmeticExpression($this->secondSimpleArithmeticExpression)
        );
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstSimpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_COMMA);

        $this->secondSimpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
