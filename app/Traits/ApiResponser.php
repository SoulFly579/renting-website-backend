<?php

namespace App\Traits;

trait ApiResponser{

    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'is_error'=> false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = null, $code)
    {
        return response()->json([
            'is_error'=> true,
            'message' => $message,
            'data' => null
        ], $code);
    }

}
