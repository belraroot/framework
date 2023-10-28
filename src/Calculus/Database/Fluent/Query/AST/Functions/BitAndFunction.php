<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "BIT_AND" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 *
 * @link    www.doctrine-project.org
 */
class BitAndFunction extends FunctionNode
{
    /** @var Node */
    public $firstArithmetic;

    /** @var Node */
    public $secondArithmetic;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();

        return $platform->getBitAndComparisonExpression(
            $this->firstArithmetic->dispatch($sqlWalker),
            $this->secondArithmetic->dispatch($sqlWalker)
        );
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstArithmetic = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->secondArithmetic = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
