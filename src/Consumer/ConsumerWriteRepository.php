<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

interface ConsumerWriteRepository
{
    public function setConsumer(ApiKey $apiKey, Consumer $consumer): void;
}
