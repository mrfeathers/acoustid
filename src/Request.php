<?php

namespace AcoustidApi;

use AcoustidApi\DataCompressor\DataCompressorInterface;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Request
{
    const BASE_URI = 'http://api.acoustid.org/v2/';
    const ACCEPT = 'application/json';

    /** @var null|string  */
    protected $apiKey = null;
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * Request constructor.
     *
     * @param null|string $apiKey
     */
    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey;
        $this->guzzleClient = new Client(['base_uri' => self::BASE_URI]);
        $this->options[RequestOptions::HEADERS]['Accept'] = self::ACCEPT;
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->guzzleClient;
    }

    /**
     * @param array $parameters
     *
     * @return Request
     */
    public function addParameters(array $parameters): Request
    {
        foreach ($parameters as $name => $value) {
            $this->addParameter($name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return Request
     */
    public function addParameter(string $name, $value): Request
    {
        $value = is_array($value) ? implode('+', $value) : $value;
        $this->parameters[] = ['name' => $name, 'value' => $value];

        return $this;
    }


    /**
     * @return string
     */
    private function getQueryString(): string
    {
        $this->apiKey && $this->addParameter('client', $this->apiKey);
        return implode('&', array_map(function ($item) {
            return $item['name'] . '=' . $item['value'];
        }, $this->parameters));
    }


    /**
     * @param string $uri
     *
     * @return ResponseInterface
     */
    public function sendGet(string $uri): ResponseInterface
    {
        return $this->getClient()->get($uri, array_merge([RequestOptions::QUERY => $this->getQueryString()], $this->options));
    }

    /**
     * @param DataCompressorInterface $compressor
     * @param string $uri
     *
     * @return ResponseInterface
     */
    public function sendCompressedPost(DataCompressorInterface $compressor, string $uri): ResponseInterface
    {
        $this->options[RequestOptions::HEADERS]['Content-Encoding'] = $compressor->getFormat();
        $this->options[RequestOptions::HEADERS]['Content-Type'] = 'application/x-www-form-urlencoded';

        $body = $compressor->compress($this->getQueryString());

        return $this->getClient()->post($uri, array_merge(
            [RequestOptions::BODY => $body], $this->options
        ));
    }
}
