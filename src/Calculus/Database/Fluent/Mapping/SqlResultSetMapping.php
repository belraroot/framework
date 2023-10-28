<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * The SqlResultSetMapping annotation is used to specify the mapping of the result of a native SQL query.
 * The SqlResultSetMapping annotation can be applied to an entity or mapped superclass.
 *
 * @Annotation
 * @Target("ANNOTATION")
 */
final class SqlResultSetMapping implements MappingAttribute
{
    /**
     * The name given to the result set mapping, and used to refer to it in the methods of the Query API.
     *
     * @var string
     */
    public $name;

    /**
     * Specifies the result set mapping to entities.
     *
     * @var array<\Calculus\Database\Fluent\Mapping\EntityResult>
     */
    public $entities = [];

    /**
     * Specifies the result set mapping to scalar values.
     *
     * @var array<\Calculus\Database\Fluent\Mapping\ColumnResult>
     */
    public $columns = [];
}
