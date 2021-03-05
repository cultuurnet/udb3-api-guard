<?php

namespace CultuurNet\UDB3\ApiGuard\ValueObjects;

class StringLiteral
{
    protected $value;

    public static function fromNative(string $value): self
    {
        return new static($value);
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toNative(): string
    {
        return $this->value;
    }

    public function sameValueAs(StringLiteral $stringLiteral): bool
    {
        return $this->toNative() === $stringLiteral->toNative();
    }

    public function __toString(): string
    {
        return $this->toNative();
    }
}
