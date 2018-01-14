<?php

namespace Tests;

use AcoustidApi\Exceptions\AcoustidException;
use AcoustidApi\ResponseModel\Collection\ResultCollection;
use AcoustidApi\ResponseModel\Collection\SubmissionCollection;
use AcoustidApi\ResponseProcessor;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Mockery;
use Tests\Sample\ResponseData;

class ResponseProcessorTest extends TestCase
{
    /**
     * @var ResponseProcessor
     */
    private $responseProcessor;

    public function setUp()
    {
        parent::setUp();
        $this->responseProcessor = new ResponseProcessor();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfResponseNot200()
    {
        $response = $this->createResponseMock(400);
        $reasonPhrase = 'reason';
        $response->shouldReceive('getReasonPhrase')
            ->once()
            ->andReturn($reasonPhrase);

        $this->expectException(AcoustidException::class);
        $this->expectExceptionMessage($reasonPhrase);

        $this->responseProcessor->process($response, SubmissionCollection::class, 'json');
    }


    public function paramsProvider()
    {
        return [
            [$resultType = ResultCollection::class, ResponseData::getDataForType($resultType), ''],
            ['', ResponseData::getDataForType(ResultCollection::class), 'json'],
            [ResultCollection::class, '', 'json'],
        ];
    }

    /**
     * @test
     * @dataProvider paramsProvider
     */
    public function shouldThrowExceptionIfCantParseResponse($resultType, $content, $format)
    {
        $response = $this->createResponseMock(200, $content);

        $this->expectException(AcoustidException::class);

        $this->responseProcessor->process($response, $resultType, $format);
    }

    /**
     * @param $code
     * @param null $content
     *
     * @return MockInterface
     */
    private function createResponseMock($code, $content = null)
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn($code);

        if ($content !== null) {
            $stream = Mockery::mock(StreamInterface::class);
            $stream->shouldReceive('getContents')
                ->once()
                ->andReturn($content);
            $response->shouldReceive('getBody')
                ->once()
                ->andReturn($stream);
        }
        return $response;
    }
}
