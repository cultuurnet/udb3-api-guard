<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

use PHPUnit\Framework\TestCase;

final class AllowAnyAuthenticatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_never_throw_an_api_key_authentication_exception(): void
    {
        $randomApiKey = new ApiKey(uniqid());
        $authenticator = new AllowAnyAuthenticator();
        $authenticator->authenticate($randomApiKey);
        $this->addToAssertionCount(1);
    }
}
