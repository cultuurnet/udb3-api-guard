<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticatorInterface;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerWriteRepositoryInterface;

final class CultureFeedApiKeyAuthenticator implements ApiKeyAuthenticatorInterface
{
    public const STATUS_BLOCKED = 'BLOCKED';
    public const STATUS_REMOVED = 'REMOVED';
    /**
     * @var \ICultureFeed
     */
    private $cultureFeed;

    /**
     * @var ConsumerWriteRepositoryInterface
     */
    private $consumerWriteRepository;

    /**
     * @var bool
     */
    private $includePermissions;

    /**
     *   CultureFeed returns a consumer detail while authenticating.
     *   This consumer will be written to the injected write repository as a
     *   form of caching.
     */
    public function __construct(
        \ICultureFeed $cultureFeed,
        ConsumerWriteRepositoryInterface $consumerWriteRepository,
        bool $includePermissions = false
    ) {
        $this->cultureFeed = $cultureFeed;
        $this->consumerWriteRepository = $consumerWriteRepository;
        $this->includePermissions = $includePermissions;
    }

    /**
     * @throws ApiKeyAuthenticationException
     */
    public function authenticate(ApiKey $apiKey): void
    {
        try {
            $consumer = $this->cultureFeed->getServiceConsumerByApiKey(
                $apiKey->getValue(),
                $this->includePermissions
            );
        } catch (\Exception $e) {
            throw ApiKeyAuthenticationException::forApiKey($apiKey);
        }

        $this->guardAgainstInvalidConsumerStatus($apiKey, $consumer);

        $this->consumerWriteRepository->setConsumer($apiKey, new CultureFeedConsumerAdapter($consumer));
    }

    private function guardAgainstInvalidConsumerStatus(ApiKey $apiKey, \CultureFeed_Consumer $consumer): void
    {
        if ($consumer->status === self::STATUS_BLOCKED) {
            throw ApiKeyAuthenticationException::forApiKey($apiKey, 'Key is blocked');
        }

        if ($consumer->status === self::STATUS_REMOVED) {
            throw ApiKeyAuthenticationException::forApiKey($apiKey, 'Key is removed');
        }
    }
}
