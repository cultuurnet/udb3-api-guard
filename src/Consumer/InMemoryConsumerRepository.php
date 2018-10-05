<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

class InMemoryConsumerRepository implements
    ConsumerReadRepositoryInterface,
    ConsumerWriteRepositoryInterface
{
    /**
     * @var ConsumerInterface[]
     */
    private $consumers = [];

    /**
     * @inheritdoc
     */
    public function getConsumer(ApiKey $apiKey)
    {
        $apiKey = $apiKey->toNative();

        if (isset($this->consumers[$apiKey])) {
            return $this->consumers[$apiKey];
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function setConsumer(ApiKey $apiKey, ConsumerInterface $consumer)
    {
        $apiKey = $apiKey->toNative();
        $this->consumers[$apiKey] = $consumer;
    }

    /**
     * @inheritdoc
     */
    public function clearConsumer(ApiKey $apiKey)
    {
        if (isset($this->consumers[$apiKey->toNative()])) {
            unset($this->consumers[$apiKey->toNative()]);
        }
    }
}
