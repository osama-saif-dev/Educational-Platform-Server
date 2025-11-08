<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($message, $data = null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error($message, $data = null, $code = 422)
    {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['errors'] = $data;
        }

        return response()->json($response, $code);
    }
}