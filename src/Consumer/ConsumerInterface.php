<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ValueObjects\StringLiteral;

interface ConsumerInterface
{
    public function getApiKey(): ApiKey;

    public function getDefaultQuery(): ?StringLiteral;

    public function getPermissionGroupIds(): array;

    public function getName(): ?string;
}
