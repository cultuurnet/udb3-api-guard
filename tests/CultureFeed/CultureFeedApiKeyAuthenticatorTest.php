<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKeyAuthenticationException;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerReadRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CultureFeedApiKeyAuthenticatorTest extends TestCase
{
    /**
     * @var ConsumerReadRepository|MockObject
     */
    private MockObject $consumerReadRepository;

    /**
     * @var CultureFeedApiKeyAuthenticator
     */
    private $authenticator;

    protected function setUp(): void
    {
        $this->consumerReadRepository = $this->createMock(ConsumerReadRepository::class);
        $this->authenticator = new CultureFeedApiKeyAuthenticator($this->consumerReadRepository);
    }

    /**
     * @test
     */
    public function it_should_authenticate_an_api_key_by_retrieving_the_related_consumer(): void
    {
        $apiKey = new ApiKey('aeef4df2-07bc-4edb-a705-84acd7e700c8');

        $expectedCfConsumer = new \CultureFeed_Consumer();
        $expectedCfConsumer->apiKeySapi3 = 'aeef4df2-07bc-4edb-a705-84acd7e700c8';
        $expectedCfConsumer->searchPrefixSapi3 = 'labels:foo AND regions:gem-leuven';

        $expectedConsumer = new CultureFeedConsumerAdapter($expectedCfConsumer);

        $this->consumerReadRepository->expects($this->once())
            ->method('getConsumer')
            ->with($apiKey)
            ->willReturn($expectedConsumer);

        $this->authenticator->authenticate($apiKey);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     */
    public function it_should_throw_an_authentication_exception_if_no_related_consumer_could_be_found(): void
    {
        $apiKey = new ApiKey('aeef4df2-07bc-4edb-a705-84acd7e700c8');

        $this->consumerReadRepository->expects($this->once())
            ->method('getConsumer')
            ->with($apiKey)
            ->willReturn(null);

        $this->expectException(ApiKeyAuthenticationException::class);
        $this->expectExceptionMessage('Could not authenticate with API key "aeef4df2-07bc-4edb-a705-84acd7e700c8".');

        $this->authenticator->authenticate($apiKey);
    }

    /**
     * @test
     * @dataProvider invalidStatusConsumers
     * @throws ApiKeyAuthenticationException
     */
    public function it_should_throw_an_authentication_exception_if_consumer_has_invalid_status(
        string $status,
        string $message
    ): void {
        $apiKey = new ApiKey('aeef4df2-07bc-4edb-a705-84acd7e700c8');

        $expectedCfConsumer = new \CultureFeed_Consumer();
        $expectedCfConsumer->apiKeySapi3 = 'aeef4df2-07bc-4edb-a705-84acd7e700c8';
        $expectedCfConsumer->searchPrefixSapi3 = 'labels:foo AND regions:gem-leuven';
        $expectedCfConsumer->status = $status;

        $expectedConsumer = new CultureFeedConsumerAdapter($expectedCfConsumer);

        $this->consumerReadRepository->expects($this->once())
            ->method('getConsumer')
            ->with($apiKey)
            ->willReturn($expectedConsumer);

        $this->expectException(ApiKeyAuthenticationException::class);
        $this->expectExceptionMessage(
            'Could not authenticate with API key "aeef4df2-07bc-4edb-a705-84acd7e700c8". ' . $message
        );

        $this->authenticator->authenticate($apiKey);
    }

    public function invalidStatusConsumers(): array
    {
        return [
            [
                'BLOCKED',
                'Key is blocked',
            ],
            [
                'REMOVED',
                'Key is removed',
            ],
        ];
    }
}
