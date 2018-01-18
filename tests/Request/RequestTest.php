<?php

namespace Tests\Request;

use AcoustidApi\Meta;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

abstract class RequestTest extends TestCase
{
    /** @var Generator */
    protected $faker;

    public function setUp()
    {
        $this->faker = Factory::create();
    }

    public function paramsProvider()
    {
        return [
            [
                $params = [
                    'trackid' => 'id',
                    'meta' => [
                        Meta::RECORDINGS,
                        Meta::RELEASE_GROUPS,
                    ],
                    'format' => 'json',
                ],
                sprintf(
                    "trackid=%s&meta=%s+%s&format=%s",
                    $params['trackid'],
                    $params['meta'][0],
                    $params['meta'][1],
                    $params['format']
                ),
                ''
            ],
            [
                $params = [
                    'trackid' => 'id',
                    'meta' => [
                        Meta::RECORDINGS,
                        Meta::RELEASE_GROUPS,
                    ],
                    'format' => 'json',
                ],
                sprintf(
                    "client=%s&trackid=%s&meta=%s+%s&format=%s",
                    $apiKey = 'apikey',
                    $params['trackid'],
                    $params['meta'][0],
                    $params['meta'][1],
                    $params['format']

                ),
                $apiKey
            ]
        ];
    }
}
