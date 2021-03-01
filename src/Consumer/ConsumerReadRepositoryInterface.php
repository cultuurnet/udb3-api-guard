<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

interface ConsumerReadRepositoryInterface
{
    public function getConsumer(ApiKey $apiKey): ?ConsumerInterface;
}
