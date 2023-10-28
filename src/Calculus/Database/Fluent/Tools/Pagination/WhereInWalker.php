<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Tools\Pagination;

use Calculus\Database\Fluent\Query\AST\ArithmeticExpression;
use Calculus\Database\Fluent\Query\AST\ConditionalExpression;
use Calculus\Database\Fluent\Query\AST\ConditionalPrimary;
use Calculus\Database\Fluent\Query\AST\ConditionalTerm;
use Calculus\Database\Fluent\Query\AST\InListExpression;
use Calculus\Database\Fluent\Query\AST\InputParameter;
use Calculus\Database\Fluent\Query\AST\NullComparisonExpression;
use Calculus\Database\Fluent\Query\AST\PathExpression;
use Calculus\Database\Fluent\Query\AST\SelectStatement;
use Calculus\Database\Fluent\Query\AST\SimpleArithmeticExpression;
use Calculus\Database\Fluent\Query\AST\WhereClause;
use Calculus\Database\Fluent\Query\TreeWalkerAdapter;
use RuntimeException;

use function count;
use function reset;

/**
 * Appends a condition equivalent to "WHERE IN (:dpid_1, :dpid_2, ...)" to the whereClause of the AST.
 *
 * The parameter namespace (dpid) is defined by
 * the PAGINATOR_ID_ALIAS
 *
 * The HINT_PAGINATOR_HAS_IDS query hint indicates whether there are
 * any ids in the parameter at all.
 */
class WhereInWalker extends TreeWalkerAdapter
{
    /**
     * ID Count hint name.
     */
    public const HINT_PAGINATOR_HAS_IDS = 'doctrine.paginator_has_ids';

    /**
     * Primary key alias for query.
     */
    public const PAGINATOR_ID_ALIAS = 'dpid';

    public function walkSelectStatement(SelectStatement $AST)
    {
        // Get the root entity and alias from the AST fromClause
        $from = $AST->fromClause->identificationVariableDeclarations;

        if (count($from) > 1) {
            throw new RuntimeException('Cannot count query which selects two FROM components, cannot make distinction');
        }

        $fromRoot            = reset($from);
        $rootAlias           = $fromRoot->rangeVariableDeclaration->aliasIdentificationVariable;
        $rootClass           = $this->getMetadataForDqlAlias($rootAlias);
        $identifierFieldName = $rootClass->getSingleIdentifierFieldName();

        $pathType = PathExpression::TYPE_STATE_FIELD;
        if (isset($rootClass->associationMappings[$identifierFieldName])) {
            $pathType = PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION;
        }

        $pathExpression       = new PathExpression(PathExpression::TYPE_STATE_FIELD | PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION, $rootAlias, $identifierFieldName);
        $pathExpression->type = $pathType;

        $hasIds = $this->_getQuery()->getHint(self::HINT_PAGINATOR_HAS_IDS);

        if ($hasIds) {
            $arithmeticExpression                             = new ArithmeticExpression();
            $arithmeticExpression->simpleArithmeticExpression = new SimpleArithmeticExpression(
                [$pathExpression]
            );
            $expression                                       = new InListExpression(
                $arithmeticExpression,
                [new InputParameter(':' . self::PAGINATOR_ID_ALIAS)]
            );
        } else {
            $expression = new NullComparisonExpression($pathExpression);
        }

        $conditionalPrimary                              = new ConditionalPrimary();
        $conditionalPrimary->simpleConditionalExpression = $expression;
        if ($AST->whereClause) {
            if ($AST->whereClause->conditionalExpression instanceof ConditionalTerm) {
                $AST->whereClause->conditionalExpression->conditionalFactors[] = $conditionalPrimary;
            } elseif ($AST->whereClause->conditionalExpression instanceof ConditionalPrimary) {
                $AST->whereClause->conditionalExpression = new ConditionalExpression(
                    [
                        new ConditionalTerm(
                            [
                                $AST->whereClause->conditionalExpression,
                                $conditionalPrimary,
                            ]
                        ),
                    ]
                );
            } else {
                $tmpPrimary                              = new ConditionalPrimary();
                $tmpPrimary->conditionalExpression       = $AST->whereClause->conditionalExpression;
                $AST->whereClause->conditionalExpression = new ConditionalTerm(
                    [
                        $tmpPrimary,
                        $conditionalPrimary,
                    ]
                );
            }
        } else {
            $AST->whereClause = new WhereClause(
                new ConditionalExpression(
                    [new ConditionalTerm([$conditionalPrimary])]
                )
            );
        }
    }
}
