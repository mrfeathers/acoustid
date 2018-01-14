<?php

namespace AcoustidApi\DataCompressor;


class GzipCompressor implements DataCompressorInterface
{
    /**
     * Compress string
     * @param string $data
     *
     * @return string
     */
    public function compress(string $data): string
    {
        return gzencode($data);
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return 'gzip';
    }
}
