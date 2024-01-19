<?php

namespace App\Exceptions;

//GLOBAL IMPORT
use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
//"There is no resource with that id."

class ResourceNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = response::HTTP_NOT_FOUND, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
