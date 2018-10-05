<?php

namespace CultuurNet\UDB3\ApiGuard\Controller;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerWriteRepositoryInterface;
use CultuurNet\UDB3\Label\ReadModels\JSON\Repository\WriteRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class ClearConsumerController
{
    /**
     * @var \CultuurNet\UDB3\ApiGuard\Consumer\ConsumerWriteRepositoryInterface
     */
    private $repository;

    /**
     * ClearConsumerController constructor.
     * @param \CultuurNet\UDB3\ApiGuard\Consumer\ConsumerWriteRepositoryInterface $repository
     */
    public function __construct(ConsumerWriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $apiKey
     */
    public function clear($apiKey)
    {
        $this->repository->clearConsumer(new ApiKey($apiKey));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
