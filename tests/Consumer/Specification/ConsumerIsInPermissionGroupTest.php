<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\CultureFeed\CultureFeedConsumerAdapter;
use PHPUnit\Framework\TestCase;
use ValueObjects\StringLiteral\StringLiteral;

class ConsumerIsInPermissionGroupTest extends TestCase
{
    private const PERMISSION_GROUP_ID = 'c91f1278-3cbe-4384-ada8-aa571d31fa95';

    /**
     * @var ConsumerIsInPermissionGroup
     */
    private $specification;

    protected function setUp(): void
    {
        $this->specification = new ConsumerIsInPermissionGroup(
            new StringLiteral(self::PERMISSION_GROUP_ID)
        );
    }

    /**
     * @test
     */
    public function it_should_be_satisfied_by_a_consumer_with_the_same_group_id_in_its_list_of_group_ids(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = 'e1734ca6-0510-44de-9994-2f256de91b24';
        $cfConsumer->group = [
            'c72a0c29-7a59-4410-b407-662101d614f9',
            self::PERMISSION_GROUP_ID,
            '917e46a4-a22b-4104-92ef-fc257f5f5803',
        ];

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertTrue($this->specification->satisfiedBy($adapter));
    }

    /**
     * @test
     */
    public function it_should_be_satisfied_by_a_consumer_with_the_same_group_id_twice_in_its_list_of_group_ids(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = 'e1734ca6-0510-44de-9994-2f256de91b24';
        $cfConsumer->group = [
            'c72a0c29-7a59-4410-b407-662101d614f9',
            self::PERMISSION_GROUP_ID,
            '917e46a4-a22b-4104-92ef-fc257f5f5803',
            self::PERMISSION_GROUP_ID,
        ];

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertTrue($this->specification->satisfiedBy($adapter));
    }

    /**
     * @test
     */
    public function it_should_not_be_satisfied_by_a_consumer_without_the_same_group_id_in_its_list_of_group_ids(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = 'e1734ca6-0510-44de-9994-2f256de91b24';
        $cfConsumer->group = [
            'c72a0c29-7a59-4410-b407-662101d614f9',
            '917e46a4-a22b-4104-92ef-fc257f5f5803',
        ];

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertFalse($this->specification->satisfiedBy($adapter));
    }

    /**
     * @test
     */
    public function it_should_not_be_satisfied_by_a_consumer_without_group_ids(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = 'e1734ca6-0510-44de-9994-2f256de91b24';
        $cfConsumer->group = [];

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertFalse($this->specification->satisfiedBy($adapter));
    }
}
