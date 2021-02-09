<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

class AllowAnyAuthenticator implements ApiKeyAuthenticatorInterface
{
    public function authenticate(ApiKey $apiKey): void
    {
    }
}
