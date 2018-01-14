<?php

namespace AcoustidApi\DataCompressor;


interface DataCompressorInterface
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function compress(string $data): string;

    /**
     * Must return compress format
     * @return string
     */
    public function getFormat(): string;
}
