<?php

namespace Tests\Request;

use AcoustidApi\Request\GetRequest;
use AcoustidApi\Request\Request;

class GetRequestTest extends RequestTest
{

    /**
     * @dataProvider paramsProvider
     *
     * @param $params
     * @param $expectedQueryString
     * @param $apiKey
     */
    public function testBuild($params, $expectedQueryString, $apiKey)
    {
        $url = $this->faker->url;
        $request = new GetRequest($url, $apiKey);
        $request->addParameters($params);

        $builtRequest = $request->build();
        $this->assertEquals((string)$builtRequest->getUri(), $url . "?" . $expectedQueryString, 'Uri must be equal');
        $this->assertEquals(Request::ACCEPT, $builtRequest->getHeader('Accept')[0], 'Accept header must be set and equal');
    }
}
