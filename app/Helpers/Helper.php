<?php

namespace App\Helpers;

class Helper
{
    public static function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'msg'     => $message,
            'result'  => $result
        ];

        return response()->json($response, $code);
    }

    public static function sendError($message, $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }
}
