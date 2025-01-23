<?php

namespace App\Exception;

use Exception;

class HandleUserException extends Exception
{
    public function __construct(string $message, int $code, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}