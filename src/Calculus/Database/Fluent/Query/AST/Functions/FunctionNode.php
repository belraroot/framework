<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\AST\Functions;

use Calculus\Database\Fluent\Query\AST\Node;
use Calculus\Database\Fluent\Query\Parser;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * Abstract Function Node.
 *
 * @link    www.doctrine-project.org
 *
 * @psalm-consistent-constructor
 */
abstract class FunctionNode extends Node
{
    /** @var string */
    public $name;

    /** @param string $name */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /** @return string */
    abstract public function getSql(SqlWalker $sqlWalker);

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function dispatch($sqlWalker)
    {
        return $sqlWalker->walkFunction($this);
    }

    /** @return void */
    abstract public function parse(Parser $parser);
}
