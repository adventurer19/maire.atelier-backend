<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/wishlist
     * Display all wishlist items for current user or guest token.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $token = $request->header('X-Wishlist-Token');

        $items = WishlistItem::forOwner($user?->id, $token)
            ->with('product')
            ->latest()
            ->get();

        return $this->ok(ProductResource::collection($items->pluck('product')));
    }

    /**
     * POST /api/wishlist
     * Add a product to the wishlist.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = $request->user();
        $token = $request->header('X-Wishlist-Token');

        try {
            $wishlistItem = WishlistItem::firstOrCreate(
                [
                    'user_id'   => $user?->id,
                    'token'     => $user ? null : $token,
                    'product_id' => $validated['product_id'],
                ]
            );

            return $this->created([
                'message' => __('Product added to wishlist'),
                'data' => new ProductResource($wishlistItem->product),
            ]);
        } catch (\Throwable $e) {
            return $this->error('WISHLIST_ADD_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * DELETE /api/wishlist/{product_id}
     * Remove a product from the wishlist.
     */
    public function destroy(Request $request, int $productId): JsonResponse
    {
        $user = $request->user();
        $token = $request->header('X-Wishlist-Token');

        $deleted = WishlistItem::forOwner($user?->id, $token)
            ->where('product_id', $productId)
            ->delete();

        if (! $deleted) {
            return $this->error('NOT_FOUND', __('common.not_found'), [
                'product_id' => $productId,
            ], 404);
        }

        return $this->ok(['message' => __('Product removed from wishlist')]);
    }
}
