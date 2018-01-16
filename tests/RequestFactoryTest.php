<?php

namespace Tests;

use AcoustidApi\Request;
use AcoustidApi\RequestFactory;
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
    public function testCreate($apiKey, $expectedClientParameter, $parameterMessage)
    {

        $request = $this->factory->create($apiKey);

        $this->assertInstanceOf(Request::class, $request, 'Must return Request object');
        //api key is set to parameter with name `client`
        $this->assertEquals($expectedClientParameter, $request->getParameter('client', null), $parameterMessage);
    }

}
