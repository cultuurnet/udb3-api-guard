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
    private array $consumers = [];

    private ?ConsumerReadRepositoryInterface $fallbackReadRepository;

    public function __construct(?ConsumerReadRepositoryInterface $fallbackReadRepository = null)
    {
        $this->fallbackReadRepository = $fallbackReadRepository;
    }

    public function getConsumer(ApiKey $apiKey): ?ConsumerInterface
    {
        if (isset($this->consumers[$apiKey->toString()])) {
            return $this->consumers[$apiKey->toString()];
        }

        if ($this->fallbackReadRepository === null) {
            return null;
        }

        $fallback = $this->fallbackReadRepository->getConsumer($apiKey);
        if ($fallback === null) {
            return null;
        }

        $this->setConsumer($apiKey, $fallback);
        return $fallback;
    }

    public function setConsumer(ApiKey $apiKey, ConsumerInterface $consumer): void
    {
        $this->consumers[$apiKey->toString()] = $consumer;
    }
}
