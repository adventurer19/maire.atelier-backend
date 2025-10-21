<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Global exception handler for unified JSON responses.
 */
class Handler extends ExceptionHandler
{
    /**
     * Format validation exceptions (HTTP 422) to unified JSON error.
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'error' => [
                'code'    => 'VALIDATION_ERROR',
                'message' => __('validation.failed'),
                'details' => $exception->errors(),
            ]
        ], $exception->status);
    }

    /**
     * Render all other exceptions to unified JSON error format.
     */
    public function render($request, Throwable $e)
    {
        // Only handle JSON/API requests
        if ($request->expectsJson()) {
            // Handle authentication errors
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'error' => [
                        'code'    => 'UNAUTHENTICATED',
                        'message' => __('auth.unauthenticated'),
                        'details' => null,
                    ]
                ], 401);
            }

            // Handle forbidden errors
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'error' => [
                        'code'    => 'FORBIDDEN',
                        'message' => __('auth.forbidden'),
                        'details' => null,
                    ]
                ], 403);
            }

            // Handle model not found (404)
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'error' => [
                        'code'    => 'NOT_FOUND',
                        'message' => __('common.not_found'),
                        'details' => ['model' => class_basename($e->getModel())],
                    ]
                ], 404);
            }

            // Handle rate limiting
            if ($e instanceof ThrottleRequestsException) {
                return response()->json([
                    'error' => [
                        'code'    => 'TOO_MANY_REQUESTS',
                        'message' => __('common.too_many_requests'),
                        'details' => null,
                    ]
                ], 429);
            }

            // Respect prebuilt HttpResponseException JSONs
            if ($e instanceof HttpResponseException && $e->getResponse() instanceof JsonResponse) {
                return $e->getResponse();
            }

            // Generic errors (4xx/5xx)
            $status = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

            return response()->json([
                'error' => [
                    'code'    => $status >= 500 ? 'SERVER_ERROR' : 'HTTP_ERROR',
                    'message' => config('app.debug') ? $e->getMessage() : __('common.something_went_wrong'),
                    'details' => config('app.debug') ? [
                        'exception' => class_basename($e),
                        'trace'     => collect($e->getTrace())->take(3),
                    ] : null,
                ]
            ], $status);
        }

        // For non-API requests, use the default Laravel rendering
        return parent::render($request, $e);
    }
}
