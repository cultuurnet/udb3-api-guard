<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

interface ConsumerInterface
{
    public function getApiKey(): ApiKey;

    public function getDefaultQuery(): ?string;

    public function getPermissionGroupIds(): array;

    public function getName(): ?string;
}
