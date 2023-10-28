<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

use function sprintf;

/**
 * "LOWER" "(" StringPrimary ")"
 *
 * @link    www.doctrine-project.org
 */
class LowerFunction extends FunctionNode
{
    /** @var Node */
    public $stringPrimary;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf(
            'LOWER(%s)',
            $sqlWalker->walkSimpleArithmeticExpression($this->stringPrimary)
        );
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
