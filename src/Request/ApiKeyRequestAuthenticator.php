<?php

namespace CultuurNet\UDB3\ApiGuard\Request;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticatorInterface;
use CultuurNet\UDB3\ApiGuard\ApiKey\Reader\ApiKeyReaderInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiKeyRequestAuthenticator implements RequestAuthenticatorInterface
{
    /**
     * @var ApiKeyReaderInterface
     */
    private $apiKeyReader;

    /**
     * @var ApiKeyAuthenticatorInterface
     */
    private $apiKeyAuthenticator;

    /**
     * @param ApiKeyReaderInterface $apiKeyReader
     * @param ApiKeyAuthenticatorInterface $apiKeyAuthenticator
     */
    public function __construct(
        ApiKeyReaderInterface $apiKeyReader,
        ApiKeyAuthenticatorInterface $apiKeyAuthenticator
    ) {
        $this->apiKeyReader = $apiKeyReader;
        $this->apiKeyAuthenticator = $apiKeyAuthenticator;
    }

    public function authenticate(ServerRequestInterface $request): void
    {
        $apiKey = $this->apiKeyReader->read($request);

        if ($apiKey === null) {
            throw new RequestAuthenticationException('No API key provided.');
        }

        try {
            $this->apiKeyAuthenticator->authenticate($apiKey);
        } catch (ApiKeyAuthenticationException $e) {
            throw new RequestAuthenticationException("Invalid API key provided ({$apiKey->toNative()}).");
        }
    }
}
