<?php

namespace App\Http\Services;

class HttpResponseService
{
    private static function factory($message, $dados)
    {
        $response = [
            'message' => $message,
            'data' => $dados,
        ];
        return $response;
    }

    public static function success($message, $dados = [])
    {
        return response()->json(self::factory($message, $dados), 200);
    }

    public static function created($message, $dados = [])
    {
        return response()->json(self::factory($message, $dados), 201);
    }

    public static function unauthorized($message, $dados = [])
    {
        return response()->json(self::factory($message, $dados), 401);
    }
}
