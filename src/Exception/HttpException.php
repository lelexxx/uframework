<?php

/** 
* @file HttpException.php
*
* @author Muetton Julien, Durand William
*/

namespace Exception;

class HttpException extends \RuntimeException
{
    private $statusCode;

    public function __construct($statusCode, $message = null, \Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
