<?php

namespace AcoustidApi\Request;

use AcoustidApi\DataCompressor\DataCompressorInterface;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\RequestInterface;

class CompressedPostRequest extends Request
{
    const CONTENT_TYPE = 'application/x-www-form-urlencoded';

    /** @var DataCompressorInterface  */
    private $compressor;

    /**
     * CompressedPostRequest constructor.
     *
     * @param DataCompressorInterface $compressor
     * @param string $uri
     * @param string $apiKey
     */
    public function __construct(DataCompressorInterface $compressor, string $uri, string $apiKey = '')
    {
        parent::__construct('POST', $uri, $apiKey);
        $this->compressor = $compressor;

    }

    /**
     * @return RequestInterface
     */
    public function build(): RequestInterface
    {
        $this->addHeader('Content-Encoding', $this->compressor->getFormat());
        $this->addHeader('Content-Type', self::CONTENT_TYPE);

        $body = $this->compressor->compress($this->getQueryString());

        return  $this->request->withBody(stream_for($body));
    }
}
