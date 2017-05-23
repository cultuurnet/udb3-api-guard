<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

interface ConsumerReadRepositoryInterface
{
    /**
     * @param ApiKey $apiKey
     * @return ConsumerInterface|null
     */
    public function getConsumer(ApiKey $apiKey);
}
