<?php

namespace Calculus\Support;

use Carbon\Carbon as BaseCarbon;
use Carbon\CarbonImmutable as BaseCarbonImmutable;
use Calculus\Support\Traits\Conditionable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Uid\Ulid;

class Carbon extends BaseCarbon
{
    use Conditionable;

    public static function setTestNow($testNow = null)
    {
        BaseCarbon::setTestNow($testNow);
        BaseCarbonImmutable::setTestNow($testNow);
    }

    public static function createFromId($id)
    {
        return Ulid::isValid($id)
            ? static::createFromInterface(Ulid::fromString($id)->getDateTime())
            : static::createFromInterface(Uuid::fromString($id)->getDateTime());
    }

    public function dd(...$args)
    {
        dd($this, ...$args);
    }

    public function dump()
    {
        dump($this);

        return $this;
    }
}