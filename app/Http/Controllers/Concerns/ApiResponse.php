<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use JsonSerializable;

trait ApiResponse
{
    protected function ok(mixed $data = null, array $meta = [], int $status = 200): JsonResponse
    {
        // Ако е Resource (JsonResource), не го сериализирай втори път
        if ($data instanceof JsonSerializable) {
            return response()->json(array_merge([
                'data' => $data,
            ], !empty($meta) ? ['meta' => $meta] : []), $status);
        }

        return response()->json([
            'data' => $data,
            'meta' => !empty($meta) ? $meta : null,
        ], $status);
    }

    protected function created(mixed $data = null, array $meta = []): JsonResponse
    {
        return $this->ok($data, $meta, 201);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    protected function paginated(LengthAwarePaginator $paginator, mixed $resourceData): JsonResponse
    {
        return $this->ok($resourceData, [
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }

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
