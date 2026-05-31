<?php

namespace App\Exception;

class HttpException extends \Exception
{
    protected int $statusCode = 500;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}