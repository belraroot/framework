<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class JoinColumns implements MappingAttribute
{
    /** @var array<\Calculus\Database\Fluent\Mapping\JoinColumn> */
    public $value;
}
