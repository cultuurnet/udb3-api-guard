<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;

class InMemoryConsumerRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InMemoryConsumerRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryConsumerRepository();
    }

    /**
     * @test
     */
    public function it_should_return_null_for_unknown_api_keys()
    {
        $apiKey = new ApiKey(uniqid());
        $this->assertNull($this->repository->getConsumer($apiKey));
    }

    /**
     * @test
     */
    public function it_should_return_the_associated_consumer_of_a_previously_set_api_key()
    {
        $apiKey = new ApiKey(uniqid());
        $consumer = $this->createMock(ConsumerInterface::class);

        $this->repository->setConsumer($apiKey, $consumer);

        $this->assertEquals($consumer, $this->repository->getConsumer($apiKey));
    }
}
