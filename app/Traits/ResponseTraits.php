<?php

namespace App\Traits;

//GLOBAL IMPORT
use Illuminate\Http\JsonResponse;
trait  ResponseTraits{

    public function response($status, $message, $data, $error): JsonResponse
    {
        return response()->json(
            [
                'status'=>$status,
                'message'=>$message,
                'data'=>$data,
                'error'=>$error
            ]
        );
    }
}
