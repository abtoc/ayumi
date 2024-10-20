<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

class BaseController extends Controller
{
     /**
     * success response method
     *
     * @param   string                  $message
     * @param   array<string, mixed>|Collection    $data
     * @return  \Illuminate\Http\JsonResponse
     */
    public function sendResponse(string $title, array|Collection $detail)
    {
        $response = [
            'success' => true,
            'title'   => $title,
            'detail'  => $detail,
        ];

        return response()->json(
            $response,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

   /**
     * return error response.
     *
     * @param   string  $message
     * @param   MessageBag|array<int|string, mixed> $errorMessages = []
     * @param   int $code = 404
     * @return  \Illuminate\Http\JsonResponse
     */
    public function sendError(
        string $title,
        MessageBag|array $detail = [],
        int $code = 404
    ) {
        $response = [
            'success' => false,
            'title'   => $title,
            'status' => $code
        ];

        if (!empty($data)) {
            $response['detail'] = $detail;
        }

        return response()->json($response,
            $code,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }
}
