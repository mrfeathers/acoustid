<?php

namespace AcoustidApi\DataCompressor;


interface DataCompressorInterface
{
    public function compress(string $data): string;

    public function getContentEncoding(): string;
}
