<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

class AllowAnyAuthenticator implements ApiKeyAuthenticatorInterface
{
    /**
     * @param ApiKey $apiKey
     * @throws ApiKeyAuthenticationException
     */
    public function authenticate(ApiKey $apiKey)
    {
    }
}
