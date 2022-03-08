<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

final class ApiKey
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
