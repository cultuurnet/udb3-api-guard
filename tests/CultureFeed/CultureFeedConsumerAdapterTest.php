<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use PHPUnit\Framework\TestCase;

final class CultureFeedConsumerAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_adapt_a_culturefeed_consumer_to_the_api_guard_consumer_interface(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = '712a7071-e251-489d-8a73-46346078a072';
        $cfConsumer->searchPrefixSapi3 = 'labels:foo AND regions:gem-leuven';
        $cfConsumer->name = 'name';

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $expectedApiKey = new ApiKey('712a7071-e251-489d-8a73-46346078a072');
        $expectedQuery = 'labels:foo AND regions:gem-leuven';

        $this->assertEquals($expectedApiKey, $adapter->getApiKey());
        $this->assertEquals($expectedQuery, $adapter->getDefaultQuery());
        $this->assertEquals('name', $adapter->getName());
        $this->assertEquals(false, $adapter->isBlocked());
        $this->assertEquals(false, $adapter->isRemoved());
    }

    /**
     * @test
     */
    public function it_should_return_null_as_default_query_if_the_injected_consumer_has_no_sapi3_search_prefix(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = '712a7071-e251-489d-8a73-46346078a072';

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertEquals(new ApiKey('712a7071-e251-489d-8a73-46346078a072'), $adapter->getApiKey());
        $this->assertNull($adapter->getDefaultQuery());
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_a_culturefeed_consumer_without_api_key_is_injected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Given CultureFeed_Consumer has no "apiKeySapi3" value.');

        $cfConsumer = new \CultureFeed_Consumer();
        new CultureFeedConsumerAdapter($cfConsumer);
    }

    /**
     * @test
     */
    public function it_should_return_a_list_of_group_ids_as_string_literals(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = '712a7071-e251-489d-8a73-46346078a072';
        $cfConsumer->group = ['103fc3b3-7f20-4802-9e3a-3b540c8afaaa', '7538c603-0383-4842-bd96-c2cdab90333b'];

        $expected = [
            '103fc3b3-7f20-4802-9e3a-3b540c8afaaa',
            '7538c603-0383-4842-bd96-c2cdab90333b',
        ];

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);
        $actual = $adapter->getPermissionGroupIds();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_should_return_an_empty_list_of_group_ids_if_the_cf_consumer_has_no_groups(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = '712a7071-e251-489d-8a73-46346078a072';
        $cfConsumer->group = [];

        $expected = [];

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);
        $actual = $adapter->getPermissionGroupIds();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_should_be_blocked_if_the_culturefeed_status_is_BLOCKED(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = '712a7071-e251-489d-8a73-46346078a072';
        $cfConsumer->status = 'BLOCKED';

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertTrue($adapter->isBlocked());
    }

    /**
     * @test
     */
    public function it_should_be_removed_if_the_culturefeed_status_is_REMOVED(): void
    {
        $cfConsumer = new \CultureFeed_Consumer();
        $cfConsumer->apiKeySapi3 = '712a7071-e251-489d-8a73-46346078a072';
        $cfConsumer->status = 'REMOVED';

        $adapter = new CultureFeedConsumerAdapter($cfConsumer);

        $this->assertTrue($adapter->isRemoved());
    }
}
