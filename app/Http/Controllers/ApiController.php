<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Respond with success message and data.
     *
     * @param  string  $message
     * @param  array|null  $data
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($message, $data = null, $statusCode = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Respond with error message and status code.
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $error, $statusCode)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'error' => $error
        ];

        return response()->json($response, $statusCode);
    }
}
