<?php

namespace AcoustidApi;

use AcoustidApi\Exceptions\AcoustidException;
use AcoustidApi\RequestModel\FingerPrintCollectionNormalizer;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\{
    Encoder\JsonEncoder,
    Normalizer\ArrayDenormalizer,
    Normalizer\DateTimeNormalizer,
    Normalizer\ObjectNormalizer,
    Serializer,
    SerializerInterface
};

class ResponseProcessor
{
    /** @var SerializerInterface */
    private $serializer;

    /**
     * ResponseProcessor constructor.
     */
    public function __construct()
    {
        $normalizers = [
            new ObjectNormalizer(
                null, null, null, new ReflectionExtractor()
            ),
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new FingerPrintCollectionNormalizer(),
        ];
        $this->serializer = new Serializer($normalizers, [new JsonEncoder()]);
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
            throw new AcoustidException($response->getReasonPhrase());
        }

        $content = $response->getBody()->getContents();

        try {
            return $this->serializer->deserialize($content, $resultType, $responseFormat);
        } catch (Exception $exception) {
            throw new AcoustidException('Can`t deserialize response', 0, $exception);
        }
    }
}
