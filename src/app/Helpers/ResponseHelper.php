<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseHelper
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function results(array $data): JsonResponse
    {
        return self::response(Response::HTTP_OK, $data);
    }
    /**
     * @param int $code
     * @param array $data
     * @return JsonResponse
     */
    private static function response(int $code, array $data = []): JsonResponse
    {
        return response()->json($data, $code);
    }
}
