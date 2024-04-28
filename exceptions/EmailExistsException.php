<?php

namespace exceptions;

use RuntimeException;

class EmailExistsException extends RuntimeException
{
    public function __construct(string $message){
        parent::__construct($message);
    }
}