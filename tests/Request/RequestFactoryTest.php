<?php

namespace Tests\Request;

use AcoustidApi\DataCompressor\DataCompressorInterface;
use AcoustidApi\Request\CompressedPostRequest;
use AcoustidApi\Request\GetRequest;
use AcoustidApi\Request\RequestFactory;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    /** @var RequestFactory */
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = new RequestFactory();
    }
    public function apiKeyProvider()
    {
        return [
            [$apiKey = 'apikey', $apiKey, "Must set client parameter with $apiKey value"],
            ['', null, 'Must not set client parameter'],
        ];
    }

    /**
     * @param $apiKey
     * @param $expectedClientParameter
     * @param $parameterMessage
     *
     * @dataProvider apiKeyProvider
     */
    public function testCreateGetRequest($apiKey, $expectedClientParameter, $parameterMessage)
    {
        $request = $this->factory->createGetRequest('', $apiKey);

        $this->assertInstanceOf(GetRequest::class, $request, 'Must return GetRequest object');
        //api key is set to parameter with name `client`
        $this->assertEquals($expectedClientParameter, $request->getParameter('client', null), $parameterMessage);
    }

    /**
     * @param $apiKey
     * @param $expectedClientParameter
     * @param $parameterMessage
     *
     * @dataProvider apiKeyProvider
     */
    public function testCreateCompressedPostRequest($apiKey, $expectedClientParameter, $parameterMessage)
    {
        $request = $this->factory->createCompressedPostRequest(\Mockery::mock(DataCompressorInterface::class),'', $apiKey);

        $this->assertInstanceOf(CompressedPostRequest::class, $request, 'Must return CompressedPostRequest object');
        //api key is set to parameter with name `client`
        $this->assertEquals($expectedClientParameter, $request->getParameter('client', null), $parameterMessage);
    }

}
