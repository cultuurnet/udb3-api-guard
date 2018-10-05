<?php

namespace CultuurNet\UDB3\ApiGuard\Doctrine;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerReadRepositoryInterface;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerWriteRepositoryInterface;
use Doctrine\Common\Cache\Cache;

class ConsumerRepository implements ConsumerReadRepositoryInterface, ConsumerWriteRepositoryInterface
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var int
     */
    private $lifeTime;

    /**
     * ConsumerRepository constructor.
     * @param \Doctrine\Common\Cache\Cache $cache
     * @param int $lifeTime
     *  The lifetime in number of seconds for cache entries.
     */
    public function __construct(Cache $cache, $lifeTime = 86400)
    {
        $this->cache = $cache;
    }

    /**
     * @inheritdoc
     */
    public function getConsumer(ApiKey $apiKey)
    {
        return $this->cache->fetch($apiKey->toNative());
    }

    /**
     * @inheritdoc
     */
    public function setConsumer(ApiKey $apiKey, ConsumerInterface $consumer)
    {
        $this->cache->save($apiKey->toNative(), $consumer, $this->lifeTime);
    }

    /**
     * @inheritdoc
     */
    public function clearConsumer(ApiKey $apiKey)
    {
        $this->cache->delete($apiKey->toNative());
    }
}
