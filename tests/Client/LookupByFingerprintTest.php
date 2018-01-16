<?php

namespace Tests\Client;

use AcoustidApi\Exceptions\AcoustidException;
use AcoustidApi\RequestModel\FingerPrint;
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
        $result = $this->clientWithKey->lookupByFingerPrint($this->createFingerPrint());

        $this->assertInstanceOf(self::EXPECTED_RETURN_TYPE, $result);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfNoApiKey()
    {
        $this->expectException(AcoustidException::class);
        $this->clientWithoutKey->lookupByFingerPrint($this->createFingerPrint());
    }

    /**
     * @return FingerPrint
     */
    private function createFingerPrint(): FingerPrint
    {
        return new FingerPrint('fingerprint', 10);
    }
}
