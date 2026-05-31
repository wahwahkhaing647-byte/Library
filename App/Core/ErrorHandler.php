<?php

namespace App\Core;

use App\Exception\HttpException;
use App\Exception\ValidationException;

class ErrorHandler
{
    public static function register(): void
    {
        set_exception_handler([self::class, 'handle']);
        set_error_handler([self::class, 'handleError']);
    }

    public static function handle(\Throwable $e): void
    {
        http_response_code($e instanceof HttpException ? $e->getStatusCode() : 500);

        $message = $e->getMessage();
        $errors = [];

        if ($e instanceof ValidationException) {
            $errors = $e->getErrors();
        }

        require BASE_PATH . '/view/errors/error.php';
        exit;
    }

    public static function handleError($severity, $message, $file, $line): void
    {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }
}