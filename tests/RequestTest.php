<?php

namespace Tests;

use AcoustidApi\Actions;
use AcoustidApi\DataCompressor\GzipCompressor;
use AcoustidApi\Meta;
use AcoustidApi\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RequestTest extends TestCase
{
    public function paramsProvider()
    {
        return [
            [
                $params = [
                    'trackid' => 'id',
                    'meta' => [
                        Meta::RECORDINGS,
                        Meta::RELEASE_GROUPS,
                    ],
                    'format' => 'json',
                ],
                sprintf(
                    "trackid=%s&meta=%s+%s&format=%s",
                    $params['trackid'],
                    $params['meta'][0],
                    $params['meta'][1],
                    $params['format']
                ),
                null
            ],
            [
                $params = [
                    'trackid' => 'id',
                    'meta' => [
                        Meta::RECORDINGS,
                        Meta::RELEASE_GROUPS,
                    ],
                    'format' => 'json',
                ],
                sprintf(
                    "trackid=%s&meta=%s+%s&format=%s&client=%s",
                    $params['trackid'],
                    $params['meta'][0],
                    $params['meta'][1],
                    $params['format'],
                    $apiKey = 'apikey'
                ),
                $apiKey
            ]
        ];
    }

    /**
     * @dataProvider paramsProvider
     *
     * @param $params
     * @param $expectedQueryString
     * @param $apiKey
     */
    public function testSendGet($params, $expectedQueryString, $apiKey)
    {
        $action = Actions::LOOKUP;
        $expectedOptions =  [
            RequestOptions::QUERY => $expectedQueryString,
            RequestOptions::HEADERS => [
                'Accept' => Request::ACCEPT,
            ],
        ];
        $client = $this->createHttpClient('get', [$action, $expectedOptions]);

        $request = $this->createRequestWithClient($client, $apiKey);
        $request->addParameters($params);
        $response = $request->sendGet($action);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @dataProvider paramsProvider
     *
     * @param $params
     * @param $expectedQueryString
     * @param $apiKey
     */
    public function testSendCompressedPost($params, $expectedQueryString, $apiKey)
    {
        $action = Actions::LOOKUP;
        $compressor = new GzipCompressor();
        $expectedBody = $compressor->compress($expectedQueryString);
        $expectedOptions  = [
            RequestOptions::BODY => $expectedBody,
            RequestOptions::HEADERS => [
                'Accept' => Request::ACCEPT,
                'Content-Encoding' => $compressor->getFormat(),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ];
        $client = $this->createHttpClient('post', [$action, $expectedOptions]);

        $request = $this->createRequestWithClient($client, $apiKey);
        $request->addParameters($params);
        $response = $request->sendCompressedPost($compressor, $action);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }



    /**
     * @param $mockMethod
     * @param $args
     *
     * @return MockInterface
     */
    private function createHttpClient($mockMethod, $args): MockInterface
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive($mockMethod)
            ->once()
            ->withArgs($args)
            ->andReturn(Mockery::mock(ResponseInterface::class));

        return $client;
    }

    /**
     * @param $client
     *
     * @param null $apiKey
     *
     * @return MockInterface
     */
    private function createRequestWithClient($client, $apiKey): MockInterface
    {
        $request = Mockery::mock(Request::class, [$apiKey])->makePartial()->shouldAllowMockingProtectedMethods();
        $request->shouldReceive('getClient')->andReturn($client);

        return $request;
    }
}
