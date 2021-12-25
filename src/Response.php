<?php

namespace HitechraSharedLibLarvel\Rest;

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
            return response()->json($exception->errors(), 422);
        } elseif ($exception instanceof ModelNotFoundException) {
            return response()->json($exception->getMessage(), 404);
        } elseif ($exception instanceof AuthenticationException) {
            return response()->json($exception->getMessage(), 403);
        } elseif ($exception instanceof UnauthorizedException) {
            return response()->json($exception->getMessage(), 401);
        }

        return response()->json($exception->getMessage(), 500);
    }
}
