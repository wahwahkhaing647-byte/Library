<?php

namespace App\Exception;

class NotFoundException extends HttpException
{
    protected int $statusCode = 404;

    public function __construct(string $message = "Page Not Found")
    {
        parent::__construct($message, 404);
    }
}