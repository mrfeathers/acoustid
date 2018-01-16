<?php

namespace Tests;

use AcoustidApi\AcoustidClient;
use AcoustidApi\AcoustidFactory;
use PHPUnit\Framework\TestCase;

class AcoustidFactoryTest extends TestCase
{
    public function apiKeyProvider()
    {
        return [
            ['apikey', true, 'Must set api key'],
            ['', false, 'Must not set api key'],
        ];
    }

    /**
     * @param $apiKey
     * @param $isApiKeySet
     * @dataProvider apiKeyProvider
     */
    public function testCreate($apiKey, $isApiKeySet, $apiKeyMessage)
    {
        $client = AcoustidFactory::create($apiKey);
        $this->assertInstanceOf(AcoustidClient::class, $client, 'Must return AcoustidApi\AcoustidClient object');
        $this->assertEquals($isApiKeySet, $client->isApiKeySet(), $apiKeyMessage);
    }
}
