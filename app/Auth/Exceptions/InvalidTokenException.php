<?php

declare(strict_types=1);

namespace App\Auth\Exceptions;

use RuntimeException;
use Throwable;

class InvalidTokenException extends RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}


