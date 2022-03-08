<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticator;
use CultuurNet\UDB3\ApiGuard\Consumer\Consumer;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerReadRepository;

final class CultureFeedApiKeyAuthenticator implements ApiKeyAuthenticator
{
    private ConsumerReadRepository $consumerReadRepository;

    public function __construct(ConsumerReadRepository $consumerReadRepository)
    {
        $this->consumerReadRepository = $consumerReadRepository;
    }

    /**
     * @throws ApiKeyAuthenticationException
     */
    public function authenticate(ApiKey $apiKey): void
    {
        $consumer = $this->consumerReadRepository->getConsumer($apiKey);
        if ($consumer === null) {
            throw ApiKeyAuthenticationException::forApiKey($apiKey);
        }

        $this->guardAgainstInvalidConsumerStatus($consumer);
    }

    private function guardAgainstInvalidConsumerStatus(Consumer $consumer): void
    {
        if ($consumer->isBlocked()) {
            throw ApiKeyAuthenticationException::forApiKey($consumer->getApiKey(), 'Key is blocked');
        }

        if ($consumer->isRemoved()) {
            throw ApiKeyAuthenticationException::forApiKey($consumer->getApiKey(), 'Key is removed');
        }
    }
}
