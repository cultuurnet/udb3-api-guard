<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Request;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticator;
use CultuurNet\UDB3\ApiGuard\ApiKey\Reader\QueryParameterApiKeyReader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

final class ApiKeyRequestAuthenticatorTest extends TestCase
{
    private QueryParameterApiKeyReader $apiKeyReader;

    /**
     * @var ApiKeyAuthenticator|MockObject
     */
    private MockObject $apiKeyAuthenticator;

    private ApiKeyRequestAuthenticator $requestAuthenticator;

    protected function setUp(): void
    {
        $this->apiKeyReader = new QueryParameterApiKeyReader('apiKey');
        $this->apiKeyAuthenticator = $this->createMock(ApiKeyAuthenticator::class);

        $this->requestAuthenticator = new ApiKeyRequestAuthenticator(
            $this->apiKeyReader,
            $this->apiKeyAuthenticator
        );
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_no_api_key_can_be_found_in_the_request(): void
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/');

        $this->expectException(RequestAuthenticationException::class);
        $this->expectExceptionMessage('No API key provided.');

        $this->requestAuthenticator->authenticate($request);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_the_provided_api_key_is_invalid(): void
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/?apiKey=0649b422-98c2-4ea0-a2c6-65bf935d11d5');


        $apiKey = new ApiKey('0649b422-98c2-4ea0-a2c6-65bf935d11d5');
        $exception = ApiKeyAuthenticationException::forApiKey($apiKey);
        $this->apiKeyAuthenticator->expects($this->once())
            ->method('authenticate')
            ->with($apiKey)
            ->willThrowException($exception);

        $this->expectException(RequestAuthenticationException::class);
        $this->expectExceptionMessage($exception->getMessage());

        $this->requestAuthenticator->authenticate($request);
    }

    /**
     * @test
     */
    public function it_should_not_throw_an_exception_if_the_api_key_does_not_raise_an_authentication_exception(): void
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/?apiKey=0649b422-98c2-4ea0-a2c6-65bf935d11d5');

        $this->apiKeyAuthenticator->expects($this->once())
            ->method('authenticate')
            ->with(new ApiKey('0649b422-98c2-4ea0-a2c6-65bf935d11d5'));

        $this->requestAuthenticator->authenticate($request);
    }
}
