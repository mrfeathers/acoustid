<?php

namespace Tests\Request;

use AcoustidApi\DataCompressor\DataCompressorInterface;
use AcoustidApi\DataCompressor\GzipCompressor;
use AcoustidApi\Request\CompressedPostRequest;
use AcoustidApi\Request\Request;
use Psr\Http\Message\RequestInterface;

class CompressedPostRequestTest extends RequestTest
{
    /**
     * @dataProvider paramsProvider
     *
     * @param $params
     * @param $queryString
     * @param $apiKey
     */
    public function testBuild($params, $queryString, $apiKey)
    {
        $url = $this->faker->url;
        $compressor = new GzipCompressor();

        $request = new CompressedPostRequest($compressor, $url, $apiKey);
        $request->addParameters($params);

        $builtRequest = $request->build();

        $this->assertEquals((string)$builtRequest->getUri(), $url, 'Uri must be equal');
        $expectedBody = $compressor->compress($queryString);
        $this->assertEquals($expectedBody, (string)$builtRequest->getBody(), 'Body must be equal');
        $this->assertHeaders($builtRequest, $compressor);
    }

    /**
     * @param $builtRequest
     * @param $compressor
     */
    private function assertHeaders(RequestInterface $builtRequest, DataCompressorInterface $compressor): void
    {
        $this->assertEquals(
            Request::ACCEPT,
            $builtRequest->getHeader('Accept')[0],
            'Accept header must be set and equal'
        );

        $this->assertEquals(
            CompressedPostRequest::CONTENT_TYPE,
            $builtRequest->getHeader('Content-Type')[0],
            'Content-Type header must be set and equal'
        );

        $this->assertEquals(
            $compressor->getFormat(),
            $builtRequest->getHeader('Content-Encoding')[0],
            'Content-Encoding header must be set and equal'
        );
    }
}
