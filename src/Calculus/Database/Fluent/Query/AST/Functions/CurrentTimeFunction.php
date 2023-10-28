<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "CURRENT_TIME"
 *
 * @link    www.doctrine-project.org
 */
class CurrentTimeFunction extends FunctionNode
{
    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getCurrentTimeSQL();
    }

    /** @inheritDoc */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
