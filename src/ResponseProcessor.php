<?php

namespace AcoustidApi;

use AcoustidApi\Exception\AcoustidApiException;
use AcoustidApi\Exception\AcoustidException;
use AcoustidApi\Exception\AcoustidSerializerException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseProcessor
{
    /** @var SerializerInterface */
    private $serializer;

    /**
     * ResponseProcessor constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ResponseInterface $response
     * @param string $resultType
     * @param string $responseFormat
     *
     * @return mixed
     * @throws AcoustidException
     */
    public function process(ResponseInterface $response, string $resultType, string $responseFormat)
    {
        if ($response->getStatusCode() != 200) {
            throw new AcoustidApiException(null, $response->getReasonPhrase());
        }

        $content = $response->getBody()->getContents();

        try {
            return $this->serializer->deserialize($content, $resultType, $responseFormat);
        } catch (Exception $exception) {
            throw new AcoustidSerializerException($exception);
        }
    }
}
