<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class CompositeApiKeyReaderTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_traverse_the_injected_readers_until_one_returns_an_api_key_for_the_given_request(): void
    {
        $expectedApiKey = new ApiKey('8f244d08-36e6-49e5-a201-b8119408d2b7');

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/');

        $reader1 = $this->getMockReader();
        $reader2 = $this->getMockReader();
        $reader3 = $this->getMockReader();
        $reader4 = $this->getMockReader();

        $compositeReader = new CompositeApiKeyReader($reader1, $reader2, $reader3, $reader4);

        $reader1->expects($this->once())
            ->method('read')
            ->with($request)
            ->willReturn(null);

        $reader2->expects($this->once())
            ->method('read')
            ->with($request)
            ->willReturn(null);

        $reader3->expects($this->once())
            ->method('read')
            ->with($request)
            ->willReturn($expectedApiKey);

        $reader4->expects($this->never())
            ->method('read');

        $this->assertEquals($expectedApiKey, $compositeReader->read($request));
    }

    /**
     * @test
     */
    public function it_should_return_null_if_none_of_the_injected_readers_returns_an_api_key(): void
    {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/');

        $reader1 = $this->getMockReader();
        $reader2 = $this->getMockReader();

        $compositeReader = new CompositeApiKeyReader($reader1, $reader2);

        $reader1->expects($this->once())
            ->method('read')
            ->with($request)
            ->willReturn(null);

        $reader2->expects($this->once())
            ->method('read')
            ->with($request)
            ->willReturn(null);

        $this->assertNull($compositeReader->read($request));
    }

    /**
     * @return ApiKeyReaderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockReader()
    {
        return $this->createMock(ApiKeyReaderInterface::class);
    }
}
