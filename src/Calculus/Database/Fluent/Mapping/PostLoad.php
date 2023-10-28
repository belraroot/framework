<?php

declare(strict_types=1);

namespace Calculus\Database\Fluent\Mapping;

use Attribute;

/**
 * @Annotation
 * @Target("METHOD")
 */
#[Attribute(Attribute::TARGET_METHOD)]
final class PostLoad implements MappingAttribute
{
}
