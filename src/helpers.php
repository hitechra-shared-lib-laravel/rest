<?php

if (!function_exists('response_success')) {
    function response_success(mixed $data, int $status = 200, string|array $message = null)
    {
        return response()->json(\HitechraSharedLibLaravel\Rest\Response::format($data, true, $status, $message), $status);
    }
}

if (!function_exists('response_error')) {
    function response_error(int $status = 500, string|array $message = null)
    {
        return response()->json(\HitechraSharedLibLaravel\Rest\Response::format(null, false, $status, $message), $status);
    }
}