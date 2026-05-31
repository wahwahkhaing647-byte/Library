<?php

namespace App\Exception;

class ValidationException extends HttpException
{
    protected int $statusCode = 422;

    private array $errors;

    public function __construct(array $errors)
    {
        parent::__construct("Validation Error", 422);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}