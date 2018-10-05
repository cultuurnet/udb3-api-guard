<?php

namespace CultuurNet\UDB3\ApiGuard\Doctrine;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;

class ConsumerRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \CultuurNet\UDB3\ApiGuard\Doctrine\ConsumerRepository
     */
    private $repository;

    /**
     * @var Cache|\PHPUnit_Framework_MockObject_MockObject
     */
    private $cache;

    /**
     * @var ApiKey
     */
    private $apiKey;

    public function setUp()
    {
        $this->cache = $this->getMockBuilder(Cache::class)->getMock();
        $this->repository = new ConsumerRepository($this->cache);

        $this->apiKey = new ApiKey('foo');
    }

    /**
     * @test
     */
    public function it_fetches_a_consumer_from_cache_when_getting_it()
    {
        $consumer = $this->createMock(ConsumerInterface::class);

        $this->cache->expects($this->once())
            ->method('fetch')
            ->with($this->apiKey->toNative())
            ->willReturn($consumer);

        $retrievedConsumer = $this->repository->getConsumer($this->apiKey);

        $this->assertEquals(
            $consumer,
            $retrievedConsumer
        );
    }

    /**
     * @test
     */
    public function it_saves_a_consumer_to_cache_when_setting_it()
    {
        $consumer = $this->createMock(ConsumerInterface::class);

        $this->cache->expects($this->once())
            ->method('save')
            ->with(
                $this->apiKey->toNative(),
                $consumer
            );

        $this->assertNull(
            $this->repository->setConsumer($this->apiKey, $consumer)
        );
    }

    /**
     * @test
     */
    public function it_deletes_a_consumer_from_cache_when_clearing_it()
    {
        $this->cache->expects($this->once())
            ->method('delete')
            ->with($this->apiKey->toNative());

        $this->assertNull(
            $this->repository->clearConsumer($this->apiKey)
        );
    }
}
