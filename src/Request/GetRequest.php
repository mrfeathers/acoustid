<?php

namespace AcoustidApi\Request;

use Psr\Http\Message\RequestInterface;

class GetRequest extends Request
{
    /**
     * GetRequest constructor.
     *
     * @param string $uri
     * @param string $apiKey
     */
    public function __construct(string $uri, string $apiKey = '')
    {
        parent::__construct('GET', $uri, $apiKey);
    }

    public function build(): RequestInterface
    {
        $uri = $this->request->getUri()->withQuery($this->getQueryString());
        return $this->request->withUri($uri);
    }
}
