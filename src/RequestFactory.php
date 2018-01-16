<?php

namespace AcoustidApi;


use GuzzleHttp\Client;

class RequestFactory
{
    const BASE_URI = 'http://api.acoustid.org/v2/';

    /** @var Client  */
    private $guzzleClient;

    /**
     * RequestFactory constructor.
     */
    public function __construct()
    {
        $this->guzzleClient = new Client(['base_uri' => self::BASE_URI]);
    }

    /**
     * @param string $apiKey
     *
     * @return Request
     */
    public function create(string $apiKey = ''): Request
    {
        return new Request($this->guzzleClient, $apiKey);
    }
}
