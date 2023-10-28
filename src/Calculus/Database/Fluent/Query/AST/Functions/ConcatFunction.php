<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "CONCAT" "(" StringPrimary "," StringPrimary {"," StringPrimary }* ")"
 *
 * @link    www.doctrine-project.org
 */
class ConcatFunction extends FunctionNode
{
    /** @var Node */
    public $firstStringPrimary;

    /** @var Node */
    public $secondStringPrimary;

    /** @psalm-var list<Node> */
    public $concatExpressions = [];

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();

        $args = [];

        foreach ($this->concatExpressions as $expression) {
            $args[] = $sqlWalker->walkStringPrimary($expression);
        }

        return $platform->getConcatExpression(...$args);
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstStringPrimary  = $parser->StringPrimary();
        $this->concatExpressions[] = $this->firstStringPrimary;

        $parser->match(Lexer::T_COMMA);

        $this->secondStringPrimary = $parser->StringPrimary();
        $this->concatExpressions[] = $this->secondStringPrimary;

        while ($parser->getLexer()->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->concatExpressions[] = $parser->StringPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
