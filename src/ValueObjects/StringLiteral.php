<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ValueObjects;

class StringLiteral
{
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toNative(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toNative();
    }
}
