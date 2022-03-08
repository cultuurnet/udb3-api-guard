<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

interface ApiKeyAuthenticator
{
    /**
     * @throws ApiKeyAuthenticationException
     */
    public function authenticate(ApiKey $apiKey): void;
}
