<?php

namespace AcoustidApi\DataCompressor;


class GzipCompressor implements DataCompressorInterface
{
    public function compress(string $data): string
    {
        return gzencode($data);
    }

    public function getContentEncoding(): string
    {
        return 'gzip';
    }
}
