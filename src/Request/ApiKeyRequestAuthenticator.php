<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Request;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticator;
use CultuurNet\UDB3\ApiGuard\ApiKey\Reader\ApiKeyReader;
use Psr\Http\Message\ServerRequestInterface;

final class ApiKeyRequestAuthenticator implements RequestAuthenticator
{
    /**
     * @var ApiKeyReader
     */
    private $apiKeyReader;

    /**
     * @var ApiKeyAuthenticator
     */
    private $apiKeyAuthenticator;


    public function __construct(
        ApiKeyReader $apiKeyReader,
        ApiKeyAuthenticator $apiKeyAuthenticator
    ) {
        $this->apiKeyReader = $apiKeyReader;
        $this->apiKeyAuthenticator = $apiKeyAuthenticator;
    }

    /**
     * @throws RequestAuthenticationException
     */
    public function authenticate(ServerRequestInterface $request): void
    {
        $apiKey = $this->apiKeyReader->read($request);

        if ($apiKey === null) {
            throw new RequestAuthenticationException('No API key provided.');
        }

        try {
            $this->apiKeyAuthenticator->authenticate($apiKey);
        } catch (ApiKeyAuthenticationException $e) {
            throw new RequestAuthenticationException($e->getMessage());
        }
    }
}
