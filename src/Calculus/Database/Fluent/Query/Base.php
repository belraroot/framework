<?php

namespace Calculus\Database\Fluent\Query;

use Symfony\Component\ErrorHandler\Exception\FlattenException;

abstract class Base
{
    /**
     * @var string
     */
    protected $preSeparator = '(';
    /**
     * @var string
     */
    protected $separator = ', ';
    /**
     * @var string
     */
    protected $postSeparator = ')';
    protected $allowClasses = [];
    protected $parts = [];

    public function __construct($args = [])
    {
        $this->addMultiple($args);
    }

    /**
     * @param $args
     * @return $this
     */
    public function addMultiple($args = [])
    {
        foreach ((array) $args as $arg) {
            $this->add($arg);
        }

        return $this;
    }

    public function add($arg)
    {
        if ($arg !== null && (! $arg instanceof self || $arg->count() > 0)) {
            if (! is_string($arg) && ! in_array(get_class($arg), $this->allowedClasses, true)) {
                throw new InvalidArgumentException(sprintf(
                    "Expression of type '%s' not allowed in this context.",
                    get_debug_type($arg)
                ));
            }

            $this->parts[] = $arg;
        }

        return $this;
    }

    public function count()
    {
        return count($this->parts);
    }

    public function __toString()
    {
        if ($this->count() === 1) {
            return (string) $this->parts[0];
        }

        return $this->preSeparator . implode($this->separator, $this->parts) . $this->postSeparator;
    }
}