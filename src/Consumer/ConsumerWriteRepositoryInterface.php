<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

interface ConsumerWriteRepositoryInterface
{
    /**
     * @param ApiKey $apiKey
     * @param ConsumerInterface
     */
    public function setConsumer(ApiKey $apiKey, ConsumerInterface $consumer);

    /**
     * @param \CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey $apiKey
     * @return void
     */
    public function clearConsumer(ApiKey $apiKey);
}
