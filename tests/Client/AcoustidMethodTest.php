<?php

namespace Tests\Client;

use AcoustidApi\AcoustidClient;
use AcoustidApi\AcoustidFactory;
use AcoustidApi\DataCompressor\DataCompressorInterface;
use AcoustidApi\DataCompressor\GzipCompressor;
use AcoustidApi\Exception\AcoustidApiException;
use AcoustidApi\FingerPrint\FingerPrint;
use AcoustidApi\FingerPrint\FingerPrintCollection;
use AcoustidApi\Request\RequestFactory;
use AcoustidApi\ResponseProcessor;
use GuzzleHttp\{
    Client, ClientInterface, Exception\GuzzleException, Exception\TransferException, Handler\MockHandler
};
use PHPUnit\Framework\TestCase;

class AcoustidMethodTest extends TestCase
{
    /** @var AcoustidClient */
    protected $clientWithKey;

    /** @var AcoustidClient */
    protected $clientWithoutKey;
    /** @var RequestFactory */
    protected $requestFactory;
    /** @var ResponseProcessor */
    protected $responseProcessor;
    /** @var DataCompressorInterface */
    protected $compressor;

    protected function getMockedResponses(): array
    {
        return [];
    }

    public function setUp()
    {
        parent::setUp();
        $this->requestFactory = new RequestFactory();
        $this->responseProcessor = AcoustidFactory::createResponseProcessor();
        $this->compressor = new GzipCompressor();

        $this->clientWithKey = new AcoustidClient(
            $this->requestFactory,
            $this->responseProcessor,
            $this->createHttpClient(),
            $this->compressor,
            'apikey'
        );

        $this->clientWithoutKey = new AcoustidClient(
            $this->requestFactory,
            $this->responseProcessor,
            $this->createHttpClient(),
            $this->compressor
        );
    }

    /**
     * @return ClientInterface
     */
    private function createHttpClient(): ClientInterface
    {
        $handler = new MockHandler($this->getMockedResponses());
        return new Client(['handler' => $handler]);
    }

    public function methodsProvider()
    {
        return [
            ['lookupByFingerPrint', [new FingerPrint('', 0)]],
            ['lookupByTrackId', ['']],
            ['submit', [new FingerPrintCollection([]), '']],
            ['getSubmissionStatus', [0]],
            ['listByMBId', [[]]],
        ];
    }

    /**
     * @param $method
     * @param $args
     *
     * @test
     * @dataProvider methodsProvider
     */
    public function shouldThrowExceptionIfHttpClientThrows($method, $args)
    {
        $httpClient = \Mockery::mock(ClientInterface::class);
        $httpClient->shouldReceive('send')
            ->andThrow($this->createGuzzleException());

        $acoustidClient = new AcoustidClient(
            $this->requestFactory,
            $this->responseProcessor,
            $httpClient,
            $this->compressor,
            'apikey'
        );

        $this->expectException(AcoustidApiException::class);

        call_user_func_array([$acoustidClient, $method], $args);
    }

    /**
     * @return \Exception|GuzzleException|__anonymous@3052
     */
    private function createGuzzleException()
    {
        $exception = new class extends \Exception implements GuzzleException
        {
        };

        return $exception;
    }
}
