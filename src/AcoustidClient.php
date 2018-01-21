<?php

namespace AcoustidApi;

use AcoustidApi\DataCompressor\DataCompressorInterface;
use AcoustidApi\Exception\{AcoustidApiException, AcoustidException};
use AcoustidApi\FingerPrint\{FingerPrintCollection, FingerPrintCollectionNormalizer};
use AcoustidApi\Request\{Request, RequestFactory};
use AcoustidApi\ResponseModel\Collection\{CollectionModel, MBIdCollection, SubmissionCollection, TrackCollection};
use AcoustidApi\ResponseModel\Collection\ResultCollection;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Serializer;

class AcoustidClient
{
    const FORMAT = 'json';

    /** @var string */
    private $apiKey;
    /** @var ResponseProcessor */
    private $responseProcessor;
    /** @var RequestFactory */
    private $requestFactory;
    /** @var ClientInterface */
    private $httpClient;
    /** @var DataCompressorInterface */
    private $compressor;

    /**
     * AcoustidClient constructor.
     *
     * @param RequestFactory $requestFactory
     * @param ResponseProcessor $responseProcessor
     * @param ClientInterface $httpClient
     * @param DataCompressorInterface $compressor
     * @param null|string $apiKey
     */
    public function __construct(
        RequestFactory $requestFactory,
        ResponseProcessor $responseProcessor,
        ClientInterface $httpClient,
        DataCompressorInterface $compressor,
        string $apiKey = '')
    {
        $this->apiKey = $apiKey;
        $this->responseProcessor = $responseProcessor;
        $this->requestFactory = $requestFactory;
        $this->httpClient = $httpClient;
        $this->compressor = $compressor;
    }

    /**
     * @return bool
     */
    public function isApiKeySet(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * @param string $apiKey
     *
     * @return AcoustidClient
     */
    public function setApiKey(string $apiKey): AcoustidClient
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @throws AcoustidException
     */
    private function checkApiKey(): void
    {
        if (!$this->isApiKeySet()) {
            throw new AcoustidException('You need to set api key to use this method');
        }
    }

    /**
     * @param string $fingerprint
     * @param int $duration
     * @param array $meta - all meta values are available in AcoustidApi/Meta class
     *
     * @return ResultCollection
     * @throws AcoustidException
     */
    public function lookupByFingerPrint(string $fingerprint, int $duration, array $meta = []): ResultCollection
    {
        $this->checkApiKey();

        $request = $this->requestFactory->createCompressedPostRequest($this->compressor, Actions::LOOKUP, $this->apiKey)
            ->addParameters([
                    'fingerprint' => $fingerprint,
                    'duration' => $duration,
                    'meta' => $meta,
                    'format' => self::FORMAT,
                ]
            );

        return $this->responseProcessor->process($this->sendRequest($request), ResultCollection::class, self::FORMAT);
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
        $this->checkApiKey();

        $request = $this->requestFactory->createGetRequest(Actions::LOOKUP, $this->apiKey)
            ->addParameters([
                    'trackid' => $trackId,
                    'meta' => $meta,
                    'format' => self::FORMAT,
                ]
            );

        return $this->responseProcessor->process($this->sendRequest($request), ResultCollection::class, self::FORMAT);
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
    public function submit(FingerPrintCollection $fingerPrints, string $userApiKey, int $wait = 1, string $clientVersion = '1.0'): SubmissionCollection
    {
        $this->checkApiKey();

        $serializer = new Serializer([new FingerPrintCollectionNormalizer()]);
        $normalizedFingerPrints = $serializer->normalize($fingerPrints);

        $request = $this->requestFactory->createCompressedPostRequest($this->compressor,Actions::SUBMIT, $this->apiKey)
            ->addParameters([
                'user' => $userApiKey,
                'clientversion' => $clientVersion,
                'wait' => $wait,
            ])
            ->addParameters($normalizedFingerPrints);

        return $this->responseProcessor->process($this->sendRequest($request), SubmissionCollection::class, self::FORMAT);
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
        $this->checkApiKey();

        $request = $this->requestFactory->createGetRequest(Actions::SUBMISSION_STATUS, $this->apiKey)
            ->addParameters([
                'id' => $submissionId,
                'clientversion' => $clientVersion,
                'format' => self::FORMAT,
            ]);

        return $this->responseProcessor->process($this->sendRequest($request), SubmissionCollection::class, self::FORMAT);
    }

    /**
     * @param array $mbids
     *
     * @return CollectionModel
     * @throws AcoustidException
     */
    public function listByMBId(array $mbids): CollectionModel
    {
        $batch = count($mbids) > 1;
        $request = $this->requestFactory->createGetRequest(Actions::TRACKLIST_BY_MBID, $this->apiKey)
            ->addParameter('batch', (int)$batch);

        foreach ($mbids as $mbid) {
            $request->addParameter('mbid', $mbid);
        }

        $resultType = $batch ? MBIdCollection::class : TrackCollection::class;

        return $this->responseProcessor->process($this->sendRequest($request), $resultType, self::FORMAT);
    }

    /**
     * @param Request $request
     *
     * @return ResponseInterface
     * @throws AcoustidException
     */
    private function sendRequest(Request $request): ResponseInterface
    {
        try {
            return $this->httpClient->send($request->build());
        } catch (GuzzleException $exception) {
            throw new AcoustidApiException($exception);
        }
    }
}
