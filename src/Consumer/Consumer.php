<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

interface Consumer
{
    public function getApiKey(): ApiKey;

    public function getDefaultQuery(): ?string;

    public function getPermissionGroupIds(): array;

    public function getName(): ?string;

    public function isBlocked(): bool;
    public function isRemoved(): bool;
}
