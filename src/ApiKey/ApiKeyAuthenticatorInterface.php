<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

interface ApiKeyAuthenticatorInterface
{
    /**
     * @param ApiKey $apiKey
     * @throws ApiKeyAuthenticationException
     */
    public function authenticate(ApiKey $apiKey);
}
