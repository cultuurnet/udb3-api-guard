<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

class AllowAnyAuthenticator implements ApiKeyAuthenticatorInterface
{
    public function authenticate(ApiKey $apiKey): void
    {
    }
}
