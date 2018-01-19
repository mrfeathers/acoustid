<?php

namespace AcoustidApi\Exception;


use Throwable;

class AcoustidApiException extends AcoustidException
{
    public function __construct(Throwable $previous = null, string $message = "Acoustid API responded with error", int $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
