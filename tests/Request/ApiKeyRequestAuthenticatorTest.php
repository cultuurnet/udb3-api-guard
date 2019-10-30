<?php

namespace CultuurNet\UDB3\ApiGuard\Request;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticatorInterface;
use CultuurNet\UDB3\ApiGuard\ApiKey\Reader\QueryParameterApiKeyReader;
use Slim\Psr7\Factory\ServerRequestFactory;

class ApiKeyRequestAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryParameterApiKeyReader
     */
    private $apiKeyReader;

    /**
     * @var ApiKeyAuthenticatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiKeyAuthenticator;

    /**
     * @var ApiKeyRequestAuthenticator
     */
    private $requestAuthenticator;

    public function setUp()
    {
        $this->apiKeyReader = new QueryParameterApiKeyReader('apiKey');
        $this->apiKeyAuthenticator = $this->createMock(ApiKeyAuthenticatorInterface::class);

        $this->requestAuthenticator = new ApiKeyRequestAuthenticator(
            $this->apiKeyReader,
            $this->apiKeyAuthenticator
        );
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_no_api_key_can_be_found_in_the_request()
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
    public function it_should_throw_an_exception_if_the_provided_api_key_is_invalid()
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
    public function it_should_not_throw_an_exception_if_the_api_key_does_not_raise_an_authentication_exception()
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/?apiKey=0649b422-98c2-4ea0-a2c6-65bf935d11d5');

        $this->apiKeyAuthenticator->expects($this->once())
            ->method('authenticate')
            ->with(new ApiKey('0649b422-98c2-4ea0-a2c6-65bf935d11d5'));

        $this->requestAuthenticator->authenticate($request);
    }
}
