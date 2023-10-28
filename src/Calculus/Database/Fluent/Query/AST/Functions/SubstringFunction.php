<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\AST\SimpleArithmeticExpression;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "SUBSTRING" "(" StringPrimary "," SimpleArithmeticExpression "," SimpleArithmeticExpression ")"
 *
 * @link    www.doctrine-project.org
 */
class SubstringFunction extends FunctionNode
{
    /** @var Node */
    public $stringPrimary;

    /** @var SimpleArithmeticExpression */
    public $firstSimpleArithmeticExpression;

    /** @var SimpleArithmeticExpression|null */
    public $secondSimpleArithmeticExpression = null;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        $optionalSecondSimpleArithmeticExpression = null;
        if ($this->secondSimpleArithmeticExpression !== null) {
            $optionalSecondSimpleArithmeticExpression = $sqlWalker->walkSimpleArithmeticExpression($this->secondSimpleArithmeticExpression);
        }

        return $sqlWalker->getConnection()->getDatabasePlatform()->getSubstringExpression(
            $sqlWalker->walkStringPrimary($this->stringPrimary),
            $sqlWalker->walkSimpleArithmeticExpression($this->firstSimpleArithmeticExpression),
            $optionalSecondSimpleArithmeticExpression
        );
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $this->firstSimpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);

            $this->secondSimpleArithmeticExpression = $parser->SimpleArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
