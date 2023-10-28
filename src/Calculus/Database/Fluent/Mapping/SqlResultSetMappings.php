<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * Is used to specify an array of mappings.
 * The SqlResultSetMappings annotation can be applied to an entity or mapped superclass.
 *
 * @Annotation
 * @Target("CLASS")
 */
final class SqlResultSetMappings implements MappingAttribute
{
    /**
     * One or more SqlResultSetMapping annotations.
     *
     * @var array<\Calculus\Database\Fluent\Mapping\SqlResultSetMapping>
     */
    public $value = [];
}
