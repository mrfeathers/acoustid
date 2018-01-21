<?php

namespace Tests\Client;

use AcoustidApi\Exception\AcoustidException;
use AcoustidApi\FingerPrint\FingerPrint;
use AcoustidApi\ResponseModel\Collection\ResultCollection;
use GuzzleHttp\Psr7\Response;
use Tests\Sample\ResponseData;

class LookupByFingerprintTest extends AcoustidMethodTest
{
    const EXPECTED_RETURN_TYPE = ResultCollection::class;

    protected function getMockedResponses(): array
    {
        $body = ResponseData::getDataForType(self::EXPECTED_RETURN_TYPE);
        return [
            new Response(200, [], $body)
        ];
    }

    public function testLookUpByFingerPrint()
    {
        $result = $this->clientWithKey->lookupByFingerPrint('fingerprint', 10);

        $this->assertInstanceOf(self::EXPECTED_RETURN_TYPE, $result);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfNoApiKey()
    {
        $this->expectException(AcoustidException::class);
        $this->clientWithoutKey->lookupByFingerPrint('fingerprint', 10);
    }
}
