<?php

namespace Tests\DataCompressor;


use AcoustidApi\DataCompressor\GzipCompressor;
use PHPUnit\Framework\TestCase;

class GzipCompressorTest extends TestCase
{
    const FORMAT = 'gzip';

    /**
     * @var GzipCompressor
     */
    private $compressor;

    public function setUp()
    {
        parent::setUp();
        $this->compressor = new GzipCompressor();
    }

    public function testCompress()
    {
        $data = 'testdata';

        $actual = $this->compressor->compress($data);

        $this->assertEquals(gzencode($data), $actual);
    }

    public function testGetFormat()
    {
        $this->assertEquals(self::FORMAT, $this->compressor->getFormat());
    }
}
