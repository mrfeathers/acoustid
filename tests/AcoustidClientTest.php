<?php

namespace Tests;

use AcoustidApi\AcoustidClient;
use AcoustidApi\Request;
use AcoustidApi\RequestModel\FingerPrint;
use AcoustidApi\RequestModel\FingerPrintCollection;
use AcoustidApi\ResponseModel\Collection\MBIdCollection;
use AcoustidApi\ResponseModel\Collection\ResultCollection;
use AcoustidApi\ResponseModel\Collection\SubmissionCollection;
use AcoustidApi\ResponseModel\Collection\TrackCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tests\Sample\ResponseData;
use Mockery;

class AcoustidClientTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function methodsProvider()
    {
        return [
            ['lookupByTrackId', ['']],
            ['lookupByFingerPrint', [new FingerPrint('', 0)]],
            ['submit', [new FingerPrintCollection([]), '']],
            ['getSubmissionStatus', [0]],
        ];
    }

    /**
     * @test
     * @dataProvider methodsProvider
     * @expectedException \AcoustidApi\Exceptions\AcoustidException
     *
     * @param $method
     * @param $arguments
     */
    public function shouldThrowExceptionIfNoApiKey($method, $arguments)
    {

        $client = new AcoustidClient();

        call_user_func_array([$client, $method], $arguments);
    }

    public function testLookUpByTrackId()
    {
        $client = $this->getAcoustIdClientWithMockedRequest(200, ResponseData::getDataForType(ResultCollection::class));

        $result = $client->lookupByTrackId('some-trackid');

        $this->assertInstanceOf(ResultCollection::class, $result);
    }

    public function testLookUpByFingerPrint()
    {
        $client = $this->getAcoustIdClientWithMockedRequest(200, ResponseData::getDataForType(ResultCollection::class));

        $result = $client->lookupByFingerPrint(new FingerPrint('fingerprint', 10));

        $this->assertInstanceOf(ResultCollection::class, $result);
    }

    public function testSubmit()
    {
        $client = $this->getAcoustIdClientWithMockedRequest(200, ResponseData::getDataForType(SubmissionCollection::class));

        $fingerPrintCollection = new FingerPrintCollection([
            new FingerPrint('fingerprint', 1),
        ]);
        $result = $client->submit($fingerPrintCollection, 'apikey');

        $this->assertInstanceOf(SubmissionCollection::class, $result);
    }

    public function testGetSubmissionStatus()
    {
        $client = $this->getAcoustIdClientWithMockedRequest(200, ResponseData::getDataForType(SubmissionCollection::class));


        $result = $client->getSubmissionStatus(1);

        $this->assertInstanceOf(SubmissionCollection::class, $result);
    }

    public function listByMBIdParams()
    {
        return [
            [true, MBIdCollection::class],
            [false, TrackCollection::class],
        ];
    }

    /**
     * @param $batc
     * @param $returnType
     *
     * @dataProvider listByMBIdParams
     */
    public function testListByMBID($batch, $returnType)
    {
        $client = $this->getAcoustIdClientWithMockedRequest(200, ResponseData::getDataForType($returnType));

        $result = $client->listByMBID('mbid', $batch);

        $this->assertInstanceOf($returnType, $result);
    }

    /**
     * @param $statusCode
     * @param $body
     *
     * @return AcoustidClient
     */
    private function getAcoustIdClientWithMockedRequest($statusCode, $body): AcoustidClient
    {
        $handler = new MockHandler([
            new Response($statusCode, [], $body),
        ]);
        $client = new Client(['handler' => $handler]);

        $request = Mockery::mock(Request::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $request->shouldReceive('getClient')->andReturn($client);

        $acoustIdClient = Mockery::mock(AcoustidClient::class, ['apikey'])->makePartial()->shouldAllowMockingProtectedMethods();
        $acoustIdClient->shouldReceive('createRequest')->andReturn($request);

        return $acoustIdClient;
    }
}
