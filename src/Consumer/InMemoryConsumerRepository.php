<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

final class InMemoryConsumerRepository implements
    ConsumerReadRepositoryInterface,
    ConsumerWriteRepositoryInterface
{
    /**
     * @var ConsumerInterface[]
     */
    private $consumers = [];

    public function getConsumer(ApiKey $apiKey): ?ConsumerInterface
    {
        $apiKey = $apiKey->toString();

        if (isset($this->consumers[$apiKey])) {
            return $this->consumers[$apiKey];
        } else {
            return null;
        }
    }

    public function setConsumer(ApiKey $apiKey, ConsumerInterface $consumer): void
    {
        $apiKey = $apiKey->toString();
        $this->consumers[$apiKey] = $consumer;
    }
}
