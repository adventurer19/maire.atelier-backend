<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

/**
 * Provides unified JSON responses for all API controllers.
 * This ensures consistent structure for success and error responses.
 */
trait ApiResponse
{
    /**
     * Successful response with optional meta data.
     */
    protected function ok(mixed $data = null, array $meta = [], int $status = 200): JsonResponse
    {
        $payload = ['data' => $data];
        if (!empty($meta)) {
            $payload['meta'] = $meta;
        }

        return response()->json($payload, $status);
    }

    /**
     * Created (HTTP 201) response.
     */
    protected function created(mixed $data = null, array $meta = []): JsonResponse
    {
        return $this->ok($data, $meta, 201);
    }

    /**
     * No content (HTTP 204) response.
     */
    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Paginated response wrapper with meta pagination info.
     */
    protected function paginated(LengthAwarePaginator $paginator, mixed $resourceData): JsonResponse
    {
        return $this->ok($resourceData, [
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ]
        ]);
    }

    /**
     * Error response wrapper for unified format.
     */
    protected function error(string $code, string $message, array $details = [], int $status = 400): JsonResponse
    {
        return response()->json([
            'error' => [
                'code'    => strtoupper($code),
                'message' => $message,
                'details' => !empty($details) ? $details : null,
            ]
        ], $status);
    }
}
