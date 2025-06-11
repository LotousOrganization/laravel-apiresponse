<?php

namespace SobhanAali\LaravelRepoControllerGenerator\Responses;

class ApiResponse
{
    public static function success($data = [], $message = 'Operation completed successfully.', $statusCode = 200)
    {
        return self::sendResponse(true, $message, $data, $statusCode);
    }

    public static function error($message = 'Operation failed. Please try again.', $statusCode = 400, $errors = [])
    {
        return self::sendResponse(false, $message, $errors, $statusCode);
    }

    public static function unauthorized($message = 'Unauthorized access or authentication failed.', $statusCode = 401, $errors = [])
    {
        return self::sendResponse(false, $message, $errors, $statusCode);
    }

    public static function validationError($message = 'Validation failed.', $errors = [] , $statusCode = 422)
    {
        return self::sendResponse(false, $message, $errors, $statusCode);
    }

    public static function notFound($message = 'Resource not found.', $statusCode = 404)
    {
        return self::sendResponse(false, $message, [], $statusCode);
    }

    public static function forbidden($message = 'Forbidden access.', $statusCode = 403)
    {
        return self::sendResponse(false, $message, [], $statusCode);
    }


    public static function sendResponse(bool $success, string $message, array $data, int $statusCode)
    {
        return response()->json(
            array_merge([
                'success' => $success,
                'message' => $message,
            ], $success ? ['data' => $data] : ['errors' => $data]),
            $statusCode
        );
    }
}
