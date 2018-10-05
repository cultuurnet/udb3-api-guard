<?php

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\Consumer\InMemoryConsumerRepository;

class CultureFeedApiKeyAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \ICultureFeed|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cultureFeed;

    /**
     * @var InMemoryConsumerRepository
     */
    private $consumerRepository;

    /**
     * @var CultureFeedApiKeyAuthenticator
     */
    private $authenticator;

    public function setUp()
    {
        $this->cultureFeed = $this->createMock(\ICultureFeed::class);
        $this->consumerRepository = new InMemoryConsumerRepository();

        $this->authenticator = new CultureFeedApiKeyAuthenticator(
            $this->cultureFeed,
            $this->consumerRepository,
            $this->consumerRepository
        );
    }

    /**
     * @test
     */
    public function it_should_authenticate_an_api_key_by_retrieving_and_caching_the_related_consumer()
    {
        $apiKey = new ApiKey('aeef4df2-07bc-4edb-a705-84acd7e700c8');

        $expectedCfConsumer = new \CultureFeed_Consumer();
        $expectedCfConsumer->apiKeySapi3 = 'aeef4df2-07bc-4edb-a705-84acd7e700c8';
        $expectedCfConsumer->searchPrefixSapi3 = 'labels:foo AND regions:gem-leuven';

        $expectedConsumer = new CultureFeedConsumerAdapter($expectedCfConsumer);

        $this->cultureFeed->expects($this->once())
            ->method('getServiceConsumerByApiKey')
            ->with($apiKey->toNative())
            ->willReturn($expectedCfConsumer);

        $this->authenticator->authenticate($apiKey);

        $actualConsumer = $this->consumerRepository->getConsumer($apiKey);

        $this->assertEquals($expectedConsumer, $actualConsumer);
    }

    /**
     * @test
     */
    public function it_should_throw_an_authentication_exception_if_no_related_consumer_could_be_found()
    {
        $apiKey = new ApiKey('aeef4df2-07bc-4edb-a705-84acd7e700c8');

        $this->cultureFeed->expects($this->once())
            ->method('getServiceConsumerByApiKey')
            ->with($apiKey->toNative())
            ->willThrowException(
                new \CultureFeed_HttpException(
                    '<error>service consumer not found</error>',
                    404
                )
            );

        $this->expectException(ApiKeyAuthenticationException::class);
        $this->expectExceptionMessage('Could not authenticate with API key "aeef4df2-07bc-4edb-a705-84acd7e700c8".');

        $this->authenticator->authenticate($apiKey);
    }

    /**
     * @test
     */
    public function it_immediately_authenticaties_if_the_consumer_is_found_in_the_repository()
    {
        $apiKey = new ApiKey('aeef4df2-07bc-4edb-a705-84acd7e700c8');

        $expectedCfConsumer = new \CultureFeed_Consumer();
        $expectedCfConsumer->apiKeySapi3 = 'aeef4df2-07bc-4edb-a705-84acd7e700c8';
        $expectedCfConsumer->searchPrefixSapi3 = 'labels:foo AND regions:gem-leuven';

        $expectedConsumer = new CultureFeedConsumerAdapter($expectedCfConsumer);

        $this->consumerRepository->setConsumer($apiKey, $expectedConsumer);

        $this->cultureFeed->expects($this->never())
            ->method('getServiceConsumerByApiKey');

        $this->authenticator->authenticate($apiKey);

        $actualConsumer = $this->consumerRepository->getConsumer($apiKey);

        $this->assertEquals($expectedConsumer, $actualConsumer);
    }
}