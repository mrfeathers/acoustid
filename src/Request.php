<?php

namespace AcoustidApi;

use AcoustidApi\DataCompressor\DataCompressorInterface;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class Request
{
    const ACCEPT = 'application/json';

    /** @var string  */
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
     * @param Client $guzzleClient
     * @param string $apiKey
     */
    public function __construct(Client $guzzleClient, string $apiKey = '')
    {
        $this->guzzleClient = $guzzleClient;
        if (!empty($apiKey)) {
            $this->addParameter('client', $apiKey);
        }
        $this->options[RequestOptions::HEADERS]['Accept'] = self::ACCEPT;
    }

    /**
     * @param string $name
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getParameter(string $name, $default = null)
    {
        foreach ($this->parameters as $parameter) {
            if ($parameter['name'] == $name) {
                return $parameter['value'];
            }
        }

        return $default;
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
        return $this->guzzleClient->get($uri, array_merge([RequestOptions::QUERY => $this->getQueryString()], $this->options));
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

        return $this->guzzleClient->post($uri, array_merge(
            [RequestOptions::BODY => $body], $this->options
        ));
    }
}
