<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use PHPUnit\Framework\TestCase;

final class InMemoryConsumerRepositoryTest extends TestCase
{
    /**
     * @var InMemoryConsumerRepository
     */
    private $repository;

    protected function setUp(): void
    {
        $this->repository = new InMemoryConsumerRepository();
    }

    /**
     * @test
     */
    public function it_should_return_null_for_unknown_api_keys(): void
    {
        $apiKey = new ApiKey('f84e2c2d-8cf4-44da-a4d7-2243ce6fd96b');
        $this->assertNull($this->repository->getConsumer($apiKey));
    }

    /**
     * @test
     */
    public function it_should_return_the_associated_consumer_of_a_previously_set_api_key(): void
    {
        $apiKey = new ApiKey('7fdd7d7f-4ce2-44e7-8615-e04ff0fb8624');
        $consumer = $this->createMock(ConsumerInterface::class);

        $this->repository->setConsumer($apiKey, $consumer);

        $this->assertEquals($consumer, $this->repository->getConsumer($apiKey));
    }

    /**
     * @test
     */
    public function it_should_try_a_fallback_read_repository_if_possible_when_a_consumer_is_not_found_in_memory(): void
    {
        $apiKey = new ApiKey('7fdd7d7f-4ce2-44e7-8615-e04ff0fb8624');

        $fallbackRepository = $this->createMock(ConsumerReadRepositoryInterface::class);
        $fallbackConsumer = $this->createMock(ConsumerInterface::class);

        $fallbackRepository->expects($this->once())
            ->method('getConsumer')
            ->with($apiKey)
            ->willReturn($fallbackConsumer);

        $repository = new InMemoryConsumerRepository($fallbackRepository);

        $this->assertEquals($fallbackConsumer, $repository->getConsumer($apiKey));
    }

    /**
     * @test
     */
    public function it_should_return_null_if_the_fallback_repository_does_not_return_a_consumer_either(): void
    {
        $apiKey = new ApiKey('7fdd7d7f-4ce2-44e7-8615-e04ff0fb8624');

        $fallbackRepository = $this->createMock(ConsumerReadRepositoryInterface::class);

        $fallbackRepository->expects($this->once())
            ->method('getConsumer')
            ->with($apiKey)
            ->willReturn(null);

        $repository = new InMemoryConsumerRepository($fallbackRepository);

        $this->assertNull($repository->getConsumer($apiKey));
    }
}
