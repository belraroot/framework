<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Query\Exec;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Calculus\Database\Fluent\Query\AST\SelectStatement;
use Calculus\Database\Fluent\Query\SqlWalker;

/**
 * Executor that executes the SQL statement for simple DQL SELECT statements.
 *
 * @link        www.doctrine-project.org
 */
class SingleSelectExecutor extends AbstractSqlExecutor
{
    public function __construct(SelectStatement $AST, SqlWalker $sqlWalker)
    {
        $this->_sqlStatements = $sqlWalker->walkSelectStatement($AST);
    }

    /**
     * {@inheritDoc}
     *
     * @return Result
     */
    public function execute(Connection $conn, array $params, array $types)
    {
        return $conn->executeQuery($this->_sqlStatements, $params, $types, $this->queryCacheProfile);
    }
}
