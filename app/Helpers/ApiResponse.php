<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function error($message, $code = 404, $details = null)
    {
        $response = [
            'status' => 'error',
            'code' => $code,
            'message' => $message,
        ];

        if (!is_null($details)) {
            $response['details'] = $details;
        }

        return response()->json($response, $code);
    }

    public static function success($data, $code = 200)
    {
        $response = [
            'status' => 'success',
            'code' => $code,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }
}
