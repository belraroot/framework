<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * Is used to specify an array of native SQL named queries.
 * The NamedNativeQueries annotation can be applied to an entity or mapped superclass.
 *
 * @Annotation
 * @Target("CLASS")
 */
final class NamedNativeQueries implements MappingAttribute
{
    /**
     * One or more NamedNativeQuery annotations.
     *
     * @var array<\Calculus\Database\Fluent\Mapping\NamedNativeQuery>
     */
    public $value = [];
}
