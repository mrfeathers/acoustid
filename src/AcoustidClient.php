<?php

namespace AcoustidApi;

use AcoustidApi\DataCompressor\GzipCompressor;
use AcoustidApi\Exceptions\AcoustidException;
use AcoustidApi\RequestModel\FingerPrint;
use AcoustidApi\RequestModel\FingerPrintCollection;
use AcoustidApi\RequestModel\FingerPrintCollectionNormalizer;
use AcoustidApi\ResponseModel\Collection\{
    CollectionModel, MBIdCollection, SubmissionCollection, TrackCollection
};
use AcoustidApi\ResponseModel\Collection\ResultCollection;
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

class AcoustidClient
{
    const FORMAT = 'json';

    /** @var string */
    private $apiKey;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * AcoustidClient constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
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
     * @param FingerPrint $fingerPrint
     * @param array $meta - all meta values are available in AcoustidApi/Meta class
     *
     * @return ResultCollection
     * @throws AcoustidException
     */
    public function lookupByFingerPrint(FingerPrint $fingerPrint, array $meta = []): ResultCollection
    {
        $response = $this->createRequest()
            ->addParameters([
                    'fingerprint' => $fingerPrint->getFingerPrint(),
                    'duration' => $fingerPrint->getDuration(),
                    'meta' => $meta,
                    'format' => self::FORMAT,
                ]
            )->sendCompressedPost(new GzipCompressor(), Actions::LOOKUP);

        return $this->processResponse($response, ResultCollection::class);
    }

    /**
     * @param string $trackId
     * @param array $meta - all meta values are available in AcoustidApi/Meta class
     *
     * @return ResultCollection
     * @throws AcoustidException
     */
    public function lookupByTrackId(string $trackId, array $meta = []): ResultCollection
    {
        $response = $this->createRequest()
            ->addParameters([
                    'trackid' => $trackId,
                    'meta' => $meta,
                    'format' => self::FORMAT,
                ]
            )->sendGet(Actions::LOOKUP);

        return $this->processResponse($response, ResultCollection::class);
    }

    /**
     * @param FingerPrintCollection $fingerPrints
     * @param string $userApiKey - users's API key
     * @param string $clientVersion - application's version, default '1.0'
     * @param int $wait - wait up to $wait seconds for the submission(s) to import, default 1
     *
     * @return SubmissionCollection
     * @throws AcoustidException
     */
    public function submit(FingerPrintCollection $fingerPrints, string $userApiKey, string $clientVersion = '1.0', int $wait = 1): SubmissionCollection
    {
        $response = $this->createRequest()
            ->addParameters([
                'user' => $userApiKey,
                'clientversion' => $clientVersion,
                'wait' => $wait,
            ])
            ->addParameters($this->serializer->normalize($fingerPrints))
            ->sendCompressedPost(new GzipCompressor(), Actions::SUBMIT);

        return $this->processResponse($response, SubmissionCollection::class);
    }

    /**
     * @param int $submissionId
     * @param string $clientVersion
     *
     * @return SubmissionCollection
     * @throws AcoustidException
     */
    public function getSubmissionStatus(int $submissionId, string $clientVersion = '1.0'): SubmissionCollection
    {
        $response = $this->createRequest()
            ->addParameters([
                'id' => $submissionId,
                'clientversion' => $clientVersion,
                'format' => self::FORMAT
            ])
            ->sendGet(Actions::SUBMISSION_STATUS);

        return $this->processResponse($response, SubmissionCollection::class);
    }

    /**
     * @param string $mdid
     * @param bool $batch
     *
     * @return CollectionModel
     * @throws AcoustidException
     */
    public function listByMBID(string $mdid, bool $batch = false): CollectionModel
    {
        $response = $this->createRequest()
            ->addParameters([
                'mbid' => $mdid,
                'batch' => (int)$batch,
            ])->sendGet(Actions::TRACKLIST_BY_MBID);

        $resultType = $batch ? MBIdCollection::class : TrackCollection::class;

        return $this->processResponse($response, $resultType);
    }

    /**
     * @return Request
     */
    private function createRequest(): Request
    {
        return new Request($this->apiKey);
    }

    /**
     * @param ResponseInterface $response
     * @param string $resultType
     *
     * @return mixed
     * @throws AcoustidException
     */
    private function processResponse(ResponseInterface $response, string $resultType)
    {
        if ($response->getStatusCode() != 200) {
            throw new AcoustidException($response->getReasonPhrase());
        }

        $content = $response->getBody()->getContents();

        return $this->serializer->deserialize($content, $resultType, self::FORMAT);
    }

}
