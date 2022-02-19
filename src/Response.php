<?php

namespace HitechraSharedLibLaravel\Rest;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Response
{
    public static function mapException(Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response_error(422, $exception->errors());
        } elseif ($exception instanceof ModelNotFoundException) {
            return response_error(404, $exception->getMessage());
        } elseif ($exception instanceof AuthenticationException) {
            return response_error(403, $exception->getMessage());
        } elseif ($exception instanceof UnauthorizedException) {
            return response_error(401, $exception->getMessage());
        }

        return response_error(500);
    }

    public static function format(mixed $data, bool $success, int $status, string|array|null $message)
    {
        return [
            'status' => $success ? 'success' : 'error',
            'code' => $status,
            'message' => $message ?? static::getMessage($status),
            'data' => $data
        ];
    }

    
    public static function getMessage(int $statusCode)
    {
        $status = config('rest.status');

        return $status[$statusCode] ?? 'Unknown Status Code';
    }
}
