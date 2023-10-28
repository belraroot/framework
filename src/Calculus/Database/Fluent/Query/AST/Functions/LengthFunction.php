<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\AST\TypedExpression;
use Calculus\Database\Fluent\Query\Lexer;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * "LENGTH" "(" StringPrimary ")"
 *
 * @link    www.doctrine-project.org
 */
class LengthFunction extends FunctionNode implements TypedExpression
{
    /** @var Node */
    public $stringPrimary;

    /** @inheritDoc */
    public function getSql(SqlWalker $sqlWalker)
    {
        return $sqlWalker->getConnection()->getDatabasePlatform()->getLengthExpression(
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

    public function getReturnType(): Type
    {
        return Type::getType(Types::INTEGER);
    }
}
