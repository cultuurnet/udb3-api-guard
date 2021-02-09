<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

interface ApiKeyAuthenticatorInterface
{
    /**
     * @throws ApiKeyAuthenticationException
     */
    public function authenticate(ApiKey $apiKey): void;
}
