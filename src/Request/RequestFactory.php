<?php

namespace AcoustidApi\Request;

use AcoustidApi\DataCompressor\DataCompressorInterface;

class RequestFactory
{
    /**
     * @param string $uri
     * @param string $apiKey
     *
     * @return GetRequest
     */
    public function createGetRequest(string $uri, string $apiKey = ''): GetRequest
    {
        return new GetRequest($uri, $apiKey);
    }

    /**
     * @param DataCompressorInterface $compressor
     * @param string $uri
     * @param string $apiKey
     *
     * @return CompressedPostRequest
     */
    public function createCompressedPostRequest(
        DataCompressorInterface $compressor,
        string $uri,
        string $apiKey = ''): CompressedPostRequest
    {
        return new CompressedPostRequest($compressor, $uri, $apiKey);
    }
}
