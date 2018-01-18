<?php

namespace AcoustidApi\Exceptions;

use Throwable;

class AcoustidSerializerException extends AcoustidException
{
    public function __construct(Throwable $previous = null, string $message = "Can't parse the response", int $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
