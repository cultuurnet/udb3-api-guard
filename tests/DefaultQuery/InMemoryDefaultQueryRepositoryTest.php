<?php

namespace CultuurNet\UDB3\ApiGuard\DefaultQuery;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use ValueObjects\StringLiteral\StringLiteral;

class InMemoryDefaultQueryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InMemoryDefaultQueryRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new InMemoryDefaultQueryRepository();
    }

    /**
     * @test
     */
    public function it_should_return_null_for_unknown_api_keys()
    {
        $apiKey = new ApiKey(uniqid());
        $this->assertNull($this->repository->get($apiKey));
    }

    /**
     * @test
     */
    public function it_should_return_the_query_of_a_previously_set_api_key_and_prefix_query()
    {
        $apiKey = new ApiKey(uniqid());

        $defaultQuery = new StringLiteral('labels:foo');

        $this->repository->set($apiKey, $defaultQuery);

        $this->assertEquals($defaultQuery, $this->repository->get($apiKey));
    }
}
