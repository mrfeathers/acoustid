<?php

namespace Tests\Client;

use AcoustidApi\Exception\AcoustidException;
use AcoustidApi\ResponseModel\Collection\SubmissionCollection;
use GuzzleHttp\Psr7\Response;
use Tests\Sample\ResponseData;

class GetSubmissionStatusTest extends AcoustidMethodTest
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
        $result = $this->clientWithKey->getSubmissionStatus(1);

        $this->assertInstanceOf(self::EXPECTED_RETURN_TYPE, $result);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfNoApiKey()
    {
        $this->expectException(AcoustidException::class);
        $this->clientWithoutKey->getSubmissionStatus(1);
    }

}
