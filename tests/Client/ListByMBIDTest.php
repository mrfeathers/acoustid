<?php

namespace Tests\Client;


use AcoustidApi\ResponseModel\Collection\MBIdCollection;
use AcoustidApi\ResponseModel\Collection\TrackCollection;
use GuzzleHttp\Psr7\Response;
use Tests\Sample\ResponseData;

class ListByMBIDTest extends AcoustidMethodTest
{
    const EXPECTED_RETURN_TYPE_TRACK = TrackCollection::class;
    const EXPECTED_RETURN_TYPE_MBID = MBIdCollection::class;

    protected function getMockedResponses(): array
    {
        return [
            new Response(200, [], ResponseData::getDataForType(self::EXPECTED_RETURN_TYPE_TRACK)),
            new Response(200, [], ResponseData::getDataForType(self::EXPECTED_RETURN_TYPE_MBID)),
        ];
    }

    public function listByMBIdParams()
    {
        return [
            [['mbid1', 'mbid2'], self::EXPECTED_RETURN_TYPE_MBID],
            [['mbid'], self::EXPECTED_RETURN_TYPE_TRACK],
        ];
    }

    /**
     * @param $mbids
     * @param $returnType
     *
     * @dataProvider listByMBIdParams
     */
    public function testListByMBIDWithApiKey($mbids, $returnType)
    {
        $result = $this->clientWithKey->listByMBID($mbids);

        $this->assertInstanceOf($returnType, $result);
    }

    /**
     * @param $mbids
     * @param $returnType
     *
     * @dataProvider listByMBIdParams
     */
    public function testListByMBIDWithoutApiKey($mbids, $returnType)
    {
        $result = $this->clientWithoutKey->listByMBID($mbids);

        $this->assertInstanceOf($returnType, $result);
    }

}
