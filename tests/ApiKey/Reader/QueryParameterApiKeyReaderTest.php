<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class QueryParameterApiKeyReaderTest extends TestCase
{
    /**
     * @var CustomHeaderApiKeyReader
     */
    private $reader;

    public function setUp()
    {
        $this->reader = new QueryParameterApiKeyReader('apiKey');
    }

    /**
     * @test
     */
    public function it_should_return_null_if_the_configured_query_parameter_is_not_set()
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/');
        $this->assertNull($this->reader->read($request));
    }

    /**
     * @test
     */
    public function it_should_return_null_if_the_configured_query_parameter_is_an_empty_string()
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/?apiKey=');

        $this->assertNull($this->reader->read($request));
    }

    /**
     * @test
     */
    public function it_should_return_the_api_key_as_a_value_object_if_the_query_parameter_is_set_and_not_empty()
    {
        $expected = new ApiKey('4f3024ab-cfbb-40a0-848c-cb88ee999987');

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/?apiKey=4f3024ab-cfbb-40a0-848c-cb88ee999987');

        $this->assertEquals($expected, $this->reader->read($request));
    }
}
