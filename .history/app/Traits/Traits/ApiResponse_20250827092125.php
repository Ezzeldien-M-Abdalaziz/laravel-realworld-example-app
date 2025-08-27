<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    protected function successResponse($data = [], string $message = 'Success', int $status = Response::HTTP_OK)
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function errorResponse(string $message = 'Error', int $status = Response::HTTP_BAD_REQUEST, $errors = [])
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    protected function unauthorizedResponse(string $message = 'Unauthorized')
    {
        return $this->errorResponse($message, Response::HTTP_UNAUTHORIZED);
    }

    protected function forbiddenResponse(string $message = 'Forbidden')
    {
        return $this->errorResponse($message, Response::HTTP_FORBIDDEN);
    }

    protected function notFoundResponse(string $message = 'Not Found')
    {
        return $this->errorResponse($message, Response::HTTP_NOT_FOUND);
    }
}
