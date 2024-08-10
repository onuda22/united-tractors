<?php

namespace App\Helper;

class Response {
    public static function res($data=null, $message = 'Response', $code = 200){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}