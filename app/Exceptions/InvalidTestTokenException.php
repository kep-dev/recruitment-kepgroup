<?php

namespace App\Exceptions;

use Exception;

class InvalidTestTokenException extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}
