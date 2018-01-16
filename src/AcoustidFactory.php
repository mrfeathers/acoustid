<?php

namespace AcoustidApi;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\{
    Encoder\JsonEncoder,
    Normalizer\ArrayDenormalizer,
    Normalizer\ObjectNormalizer,
    Serializer
};
use AcoustidApi\RequestModel\FingerPrintCollectionNormalizer;

class AcoustidFactory
{
    /**
     * @param string $apiKey
     *
     * @return AcoustidClient
     */
    public static function create(string $apiKey = ''): AcoustidClient
    {
        return new AcoustidClient(
            self::createRequestFactory(),
            self::createResponseProcessor(),
            $apiKey
        );
    }

    /**
     * @return RequestFactory
     */
    public static function createRequestFactory(): RequestFactory
    {
        return new RequestFactory();
    }

    /**
     * @return ResponseProcessor
     */
    public static function createResponseProcessor(): ResponseProcessor
    {
        $normalizers = [
            new ObjectNormalizer(
                null, null, null, new ReflectionExtractor()
            ),
            new ArrayDenormalizer(),
            new FingerPrintCollectionNormalizer(),
        ];
        $serializer = new Serializer($normalizers, [new JsonEncoder()]);

        return new ResponseProcessor($serializer);
    }
}
