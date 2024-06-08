<?php

namespace exceptions;

use Exception;

class InvalidSignatureException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}