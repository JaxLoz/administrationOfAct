<?php

namespace exceptions;

use RuntimeException;
use Throwable;

class IncorectPasswordException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

}