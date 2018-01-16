<?php

namespace Tests\Client;

use AcoustidApi\{AcoustidClient, AcoustidFactory, RequestFactory, Request};
use GuzzleHttp\{Client, Handler\MockHandler};
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

abstract class AcoustidMethodTest extends TestCase
{
    /** @var AcoustidClient */
    protected $clientWithKey;

    /** @var AcoustidClient */
    protected $clientWithoutKey;

    abstract protected function getMockedResponses(): array;

    public function setUp()
    {
        parent::setUp();
        $requestFactory = $this->createRequestFactory();
        $responseProcessor = AcoustidFactory::createResponseProcessor();
        $this->clientWithKey = new AcoustidClient($requestFactory, $responseProcessor, 'apikey');
        $this->clientWithoutKey = new AcoustidClient($requestFactory, $responseProcessor);
    }

    /**
     * @return MockInterface
     */
    private function createRequestFactory(): MockInterface
    {
        $handler = new MockHandler($this->getMockedResponses());
        $client = new Client(['handler' => $handler]);
        $request = new Request($client);

        $requestFactory = Mockery::mock(RequestFactory::class);
        $requestFactory->shouldReceive('create')->andReturn($request);

        return $requestFactory;
    }

}
