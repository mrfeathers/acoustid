<?php

namespace Tests\Client;


use AcoustidApi\Exceptions\AcoustidException;
use AcoustidApi\RequestModel\FingerPrint;
use AcoustidApi\RequestModel\FingerPrintCollection;
use AcoustidApi\ResponseModel\Collection\SubmissionCollection;
use GuzzleHttp\Psr7\Response;
use Tests\Sample\ResponseData;

class SubmitTest extends AcoustidMethodTest
{
    const EXPECTED_RETURN_TYPE = SubmissionCollection::class;

    protected function getMockedResponses(): array
    {
        $body = ResponseData::getDataForType(self::EXPECTED_RETURN_TYPE);
        return [
            new Response(200, [], $body)
        ];
    }

    public function testSubmit()
    {
        $fingerPrintCollection = $this->createFingerPrintCollection();
        $result = $this->clientWithKey->submit($fingerPrintCollection, 'userapikey');

        $this->assertInstanceOf(self::EXPECTED_RETURN_TYPE, $result);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfNoApiKey()
    {
        $this->expectException(AcoustidException::class);
        $fingerPrintCollection = $this->createFingerPrintCollection();
        $this->clientWithoutKey->submit($fingerPrintCollection, 'userapikey');
    }

    /**
     * @return FingerPrintCollection
     */
    private function createFingerPrintCollection(): FingerPrintCollection
    {
        $fingerPrintCollection = new FingerPrintCollection([
            new FingerPrint('fingerprint', 1),
        ]);

        return $fingerPrintCollection;
    }
}
