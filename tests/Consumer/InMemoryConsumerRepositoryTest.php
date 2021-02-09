<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use PHPUnit\Framework\TestCase;

class InMemoryConsumerRepositoryTest extends TestCase
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
        $apiKey = new ApiKey(uniqid());
        $this->assertNull($this->repository->getConsumer($apiKey));
    }

    /**
     * @test
     */
    public function it_should_return_the_associated_consumer_of_a_previously_set_api_key(): void
    {
        $apiKey = new ApiKey(uniqid());
        $consumer = $this->createMock(ConsumerInterface::class);

        $this->repository->setConsumer($apiKey, $consumer);

        $this->assertEquals($consumer, $this->repository->getConsumer($apiKey));
    }
}
