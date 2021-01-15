<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Factory\UriFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;

class CustomHeaderApiKeyReaderTest extends TestCase
{
    /**
     * @var CustomHeaderApiKeyReader
     */
    private $reader;

    public function setUp()
    {
        $this->reader = new CustomHeaderApiKeyReader('X-Api-Key');
    }

    /**
     * @test
     */
    public function it_should_return_null_if_the_configured_header_is_not_set()
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/');

        $this->assertNull($this->reader->read($request));
    }

    /**
     * @test
     */
    public function it_should_return_null_if_the_configured_header_is_an_empty_string()
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/', ['X-Api-Key' => '']);

        $this->assertNull($this->reader->read($request));
    }

    /**
     * @test
     */
    public function it_should_return_the_api_key_as_a_value_object_if_the_configured_header_is_set_and_not_empty()
    {
        $expected = new ApiKey('4f3024ab-cfbb-40a0-848c-cb88ee999987');

        $uri = (new UriFactory())->createUri('/');
        $body = (new StreamFactory())->createStream();
        $request = new Request(
            'GET',
            $uri,
            new Headers(['X-Api-Key' => '4f3024ab-cfbb-40a0-848c-cb88ee999987']),
            [],
            [],
            $body
        );

        $this->assertEquals($expected, $this->reader->read($request));
    }
}
