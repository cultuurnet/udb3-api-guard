<?php

namespace CultuurNet\UDB3\ApiGuard\Controller;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerWriteRepositoryInterface;

class ClearConsumerControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConsumerWriteRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repository;

    /**
     * @var \CultuurNet\UDB3\ApiGuard\Controller\ClearConsumerController
     */
    private $controller;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $class = ConsumerWriteRepositoryInterface::class;
        $this->repository = $this->getMockBuilder($class)->getMock();
        $this->controller = new ClearConsumerController($this->repository);
    }

    /**
     * @test
     */
    public function it_clears_a_consumer_from_the_repository()
    {
        $apiKey = 'foo';

        $this->repository->expects($this->once())
            ->method('clearConsumer')
            ->with(new ApiKey($apiKey));

        $this->controller->clear($apiKey);
    }
}
