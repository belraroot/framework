<?php

declare(strict_types=1);


namespace Calculus\Database\Fluent\Mapping;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final class InverseJoinColumn implements MappingAttribute
{
    use JoinColumnProperties;
}
