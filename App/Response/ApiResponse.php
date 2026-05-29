<?php
namespace App\Response;

class ApiResponse
{
    public static function success($data = null, string $message = "OK"): array
    {
        return [
            'status' => true,
            'message' => $message,
            'data' => $data
        ];
    }

    public static function error(string $message, array $errors = []): array
    {
        return [
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ];
    }
}