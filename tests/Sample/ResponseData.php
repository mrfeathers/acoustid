<?php

namespace Tests\Sample;

use AcoustidApi\ResponseModel\Collection\MBIdCollection;
use AcoustidApi\ResponseModel\Collection\ResultCollection;
use AcoustidApi\ResponseModel\Collection\SubmissionCollection;
use AcoustidApi\ResponseModel\Collection\TrackCollection;
use AcoustidApi\ResponseModel\Result;

final class ResponseData
{
    private const RESPONSES_DIR = 'responses';

    /**
     * @var array
     */
    private static $data = [
        ResultCollection::class => 'result_collection.json',
        SubmissionCollection::class => 'submission_collection.json',
        TrackCollection::class => 'track_collection.json',
        MBIdCollection::class => 'mbid_collection.json',
    ];

    /**
     * @param string $type
     *
     * @return string
     */
    public static function getDataForType(string $type): string
    {
        if (!isset(self::$data[$type])) {
            throw new \InvalidArgumentException("No data for type $type");
        }

        $path = __DIR__ . DIRECTORY_SEPARATOR . self::RESPONSES_DIR . DIRECTORY_SEPARATOR . self::$data[$type];
        if (file_exists($path)) {
            return file_get_contents($path);
        } else {
            throw new \LogicException("No response file for type $type");
        }
    }
}
