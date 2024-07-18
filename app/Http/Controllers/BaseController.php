<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function buildSuccessResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'result' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function buildErrorResponse($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['result'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
