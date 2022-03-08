<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

final class AllowAnyAuthenticator implements ApiKeyAuthenticator
{
    public function authenticate(ApiKey $apiKey): void
    {
    }
}
