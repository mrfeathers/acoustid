<?php

namespace AcoustidApi\Request;

use Psr\Http\Message\RequestInterface;
use \GuzzleHttp\Psr7\Request as PsrRequest;

abstract class Request
{
    const ACCEPT = 'application/json';

    /** @var string  */
    protected $apiKey = null;
    /**
     * @var array
     */
    protected $parameters = [];

    /** @var RequestInterface  */
    protected $request;

    /**
     * Request constructor.
     *
     * @param $method
     * @param $uri
     * @param string $apiKey
     */
    public function __construct($method, $uri, string $apiKey = '')
    {
        $this->request = new PsrRequest($method, $uri, ['Accept' => self::ACCEPT]);
        if (!empty($apiKey)) {
            $this->addParameter('client', $apiKey);
        }
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
    protected function getQueryString(): string
    {
        return implode('&', array_map(function ($item) {
            return $item['name'] . '=' . $item['value'];
        }, $this->parameters));
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return Request
     */
    protected function addHeader(string $name, string $value): Request
    {
        $this->request = $this->request->withHeader($name, $value);
        return $this;
    }

    /**
     * @return RequestInterface
     */
    abstract public function build(): RequestInterface;
}
