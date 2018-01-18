<?php

namespace AcoustidApi;

use AcoustidApi\DataCompressor\GzipCompressor;
use AcoustidApi\Request\RequestFactory;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\{
    Encoder\JsonEncoder,
    Normalizer\ArrayDenormalizer,
    Normalizer\ObjectNormalizer,
    Serializer
};
use AcoustidApi\FingerPrint\FingerPrintCollectionNormalizer;

class AcoustidFactory
{

    private const BASE_URI = 'http://api.acoustid.org/v2/';

    /**
     * @param string $apiKey
     *
     * @return AcoustidClient
     */
    public static function create(string $apiKey = ''): AcoustidClient
    {
        return new AcoustidClient(
            new RequestFactory(),
            self::createResponseProcessor(),
            self::createHttpClient(),
            new GzipCompressor(),
            $apiKey
        );
    }

    /**
     * @return ClientInterface
     */
    public static function createHttpClient(): ClientInterface
    {
        return new Client(['base_uri' => self::BASE_URI]);
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
