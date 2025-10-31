<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/collections
     * List all collections (paginated or full).
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 12);
        $collections = Collection::query()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return $this->paginated($collections, CollectionResource::collection($collections));
    }

    /**
     * POST /api/collections
     * Create a new collection.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:collections,slug',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $collection = Collection::create($validated);

        return $this->created(new CollectionResource($collection));
    }

    /**
     * GET /api/collections/{id}
     * Retrieve a single collection by ID or slug.
     */
    public function show(string $id): JsonResponse
    {
        $collection = Collection::where('id', $id)
            ->orWhere('slug', $id)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)
                    ->with(['categories', 'variants.attributeOptions', 'media']);
            }])
            ->first();

        if (! $collection) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'collection_id' => $id,
            ], 404);
        }

        return $this->ok(new CollectionResource($collection));
    }

    /**
     * PUT /api/collections/{id}
     * Update a specific collection.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $collection = Collection::find($id);

        if (! $collection) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'collection_id' => $id,
            ], 404);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'slug'        => 'sometimes|string|max:255|unique:collections,slug,' . $collection->id,
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $collection->update($validated);

        return $this->ok(new CollectionResource($collection->fresh()));
    }

    /**
     * DELETE /api/collections/{id}
     * Delete a collection.
     */
    public function destroy(string $id): JsonResponse
    {
        $collection = Collection::find($id);

        if (! $collection) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'collection_id' => $id,
            ], 404);
        }

        $collection->delete();

        return $this->ok(['message' => __('Collection deleted successfully')]);
    }

    /**
     * GET /api/collections/latest
     * Get the latest/featured collection with its products.
     */
    public function latest(): JsonResponse
    {
        // Try to find featured collection first, then latest by date
        $collection = Collection::query()
            ->where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)
                    ->with(['categories', 'media'])
                    ->limit(8) // Limit to 8 products for homepage carousel
                    ->orderBy('created_at', 'desc');
            }])
            ->where(function ($query) {
                $query->where('is_featured', true)
                    ->orWhere('created_at', '>=', now()->subMonths(3)); // Collections from last 3 months
            })
            ->orderByDesc('is_featured') // Prioritize featured
            ->orderByDesc('created_at')
            ->first();

        if (! $collection) {
            // Fallback: get any active collection
            $collection = Collection::query()
                ->where('is_active', true)
                ->with(['products' => function ($query) {
                    $query->where('is_active', true)
                        ->with(['categories', 'media'])
                        ->limit(8)
                        ->orderBy('created_at', 'desc');
                }])
                ->orderByDesc('created_at')
                ->first();
        }

        if (! $collection) {
            return $this->error('NOT_FOUND', __('No collections found'), [], 404);
        }

        return $this->ok(new CollectionResource($collection));
    }
}
