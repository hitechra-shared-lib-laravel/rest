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
            return response_error(400, $exception->errors());
        } elseif ($exception instanceof ModelNotFoundException) {
            return response_error(404, $exception->getMessage());
        } elseif ($exception instanceof AuthenticationException) {
            return response_error(403, $exception->getMessage());
        } elseif ($exception instanceof UnauthorizedException) {
            return response_error(401, $exception->getMessage());
        } elseif ((int) $exception->getCode() >= 400) {
            return response_error((int) $exception->getCode(), $exception->getMessage());
        }

        return response_error(500, $exception->getMessage());
    }

    public static function format(mixed $data, bool $success, int $status, string|array|null $message)
    {
        $response = [
            'status' => $success ? 'success' : 'error',
            'code' => $status,
            'message' => $message,
            'data' => $data
        ];
        
        if (!$success) {
            $response['error'] = static::getMessage($status);
        }
        
        return $response;
    }

    
    public static function getMessage(int $statusCode)
    {
        $status = config('rest.status');

        return $status[$statusCode] ?? 'Unknown Status Code';
    }
}
