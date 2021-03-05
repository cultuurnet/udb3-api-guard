<?php

namespace CultuurNet\UDB3\ApiGuard\ValueObjects;

use InvalidArgumentException;

class StringLiteral
{
    protected $value;

    /**
     * Returns a StringLiteral object given a PHP native string as parameter.
     *
     * @param  string $value
     * @return StringLiteral
     */
    public static function fromNative()
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a StringLiteral object given a PHP native string as parameter.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        if (false === \is_string($value)) {
            throw new InvalidArgumentException($value, array('string'));
        }

        $this->value = $value;
    }

    /**
     * Returns the value of the string
     *
     * @return string
     */
    public function toNative()
    {
        return $this->value;
    }

    public function sameValueAs(StringLiteral $stringLiteral): bool
    {
        return $this->toNative() === $stringLiteral->toNative();
    }

    /**
     * Tells whether the StringLiteral is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return \strlen($this->toNative()) == 0;
    }

    /**
     * Returns the string value itself
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toNative();
    }
}
