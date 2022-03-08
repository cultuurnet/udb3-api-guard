<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\CultureFeed\CultureFeedConsumerAdapter;
use ICultureFeed;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CultureFeedConsumerReadRepositoryTest extends TestCase
{
    /** @var ICultureFeed|MockObject */
    private MockObject $cultureFeed;
    private CultureFeedConsumerReadRepository $cultureFeedConsumerReadRepository;

    protected function setUp(): void
    {
        $this->cultureFeed = $this->createMock(ICultureFeed::class);
        $this->cultureFeedConsumerReadRepository = new CultureFeedConsumerReadRepository($this->cultureFeed, true);
    }

    /**
     * @test
     */
    public function it_should_return_a_consumer_if_one_is_found(): void
    {
        $apiKey = new ApiKey('0454a0b6-f773-4913-9428-c85c19be75eb');

        $expectedCfConsumer = new \CultureFeed_Consumer();
        $expectedCfConsumer->apiKeySapi3 = '0454a0b6-f773-4913-9428-c85c19be75eb';

        $expectedConsumer = new CultureFeedConsumerAdapter($expectedCfConsumer);

        $this->cultureFeed->expects($this->once())
            ->method('getServiceConsumerByApiKey')
            ->with($apiKey->toString(), true)
            ->willReturn($expectedCfConsumer);

        $actualConsumer = $this->cultureFeedConsumerReadRepository->getConsumer($apiKey);

        $this->assertEquals($expectedConsumer, $actualConsumer);
    }

    /**
     * @test
     */
    public function it_should_return_null_if_a_culturefeed_exception_occurs(): void
    {
        $apiKey = new ApiKey('0454a0b6-f773-4913-9428-c85c19be75eb');

        $this->cultureFeed->expects($this->once())
            ->method('getServiceConsumerByApiKey')
            ->with($apiKey->toString())
            ->willThrowException(
                new \CultureFeed_HttpException(
                    '<error>service consumer not found</error>',
                    404
                )
            );

        $this->assertNull($this->cultureFeedConsumerReadRepository->getConsumer($apiKey));
    }
}
