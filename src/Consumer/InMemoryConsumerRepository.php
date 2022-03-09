<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

final class InMemoryConsumerRepository implements
    ConsumerReadRepository,
    ConsumerWriteRepository
{
    /**
     * @var Consumer[]
     */
    private array $consumers = [];

    private ?ConsumerReadRepository $fallbackReadRepository;

    public function __construct(?ConsumerReadRepository $fallbackReadRepository = null)
    {
        $this->fallbackReadRepository = $fallbackReadRepository;
    }

    public function getConsumer(ApiKey $apiKey): ?Consumer
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

    public function setConsumer(ApiKey $apiKey, Consumer $consumer): void
    {
        $this->consumers[$apiKey->toString()] = $consumer;
    }
}
