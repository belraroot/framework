<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\AST\SimpleArithmeticExpression;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "LOCATE" "(" StringPrimary "," StringPrimary ["," SimpleArithmeticExpression]")"
 *
 * @link    www.doctrine-project.org
 */
class LocateFunction extends FunctionNode
{
    /** @var Node */
    public $firstStringPrimary;

    /** @var Node */
    public $secondStringPrimary;

    /** @var SimpleArithmeticExpression|bool */
    public $simpleArithmeticExpression = false;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();

        $firstString  = $sqlWalker->walkStringPrimary($this->firstStringPrimary);
        $secondString = $sqlWalker->walkStringPrimary($this->secondStringPrimary);

        if ($this->simpleArithmeticExpression) {
            return $platform->getLocateExpression(
                $secondString,
                $firstString,
                $sqlWalker->walkSimpleArithmeticExpression($this->simpleArithmeticExpression)
            );
        }

        return $platform->getLocateExpression($secondString, $firstString);
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstStringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->secondStringPrimary = $parser->StringPrimary();

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);

            $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
