<?php

namespace App\exception;

use Exception;
use Throwable;

class ApplicationException extends Exception implements BaseException
{

    private Throwable|null $previous;

    public function __construct($message = "Internal Server Error", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->previous = $previous;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function status(): int
    {
        return $this->code;
    }

    public function throwable(): Throwable| null
    {
        return $this->previous;
    }
}
