<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * References an entity in the SELECT clause of a SQL query.
 * If this annotation is used, the SQL statement should select all of the columns that are mapped to the entity object.
 * This should include foreign key columns to related entities.
 * The results obtained when insufficient data is available are undefined.
 *
 * @Annotation
 * @Target("ANNOTATION")
 */
final class EntityResult implements MappingAttribute
{
    /**
     * The class of the result.
     *
     * @var string
     */
    public $entityClass;

    /**
     * Maps the columns specified in the SELECT list of the query to the properties or fields of the entity class.
     *
     * @var array<\Calculus\Database\Fluent\Mapping\FieldResult>
     */
    public $fields = [];

    /**
     * Specifies the column name of the column in the SELECT list that is used to determine the type of the entity instance.
     *
     * @var string
     */
    public $discriminatorColumn;
}
