<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponse;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * GET /api/cart
     * Retrieve the current cart with items and summary.
     */
    public function index(): JsonResponse
    {
        try {
            $summary = $this->cartService->getCartSummary();

            return $this->ok([
                'items' => CartItemResource::collection($summary['items']),
                'summary' => [
                    'subtotal'    => $summary['subtotal'],
                    'shipping'    => $summary['shipping'],
                    'tax'         => $summary['tax'],
                    'total'       => $summary['total'],
                    'total_items' => $summary['total_items'],
                ],
            ]);
        } catch (\Throwable $e) {
            return $this->error('CART_FETCH_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/cart/items
     * Add an item to the cart.
     */
    public function addItem(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:100',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        try {
            $item = $this->cartService->addItem(
                productId: $validated['product_id'],
                quantity: $validated['quantity'],
                variantId: $validated['variant_id'] ?? null
            );

            $summary = $this->cartService->getCartSummary();

            return $this->created([
                'item'       => new CartItemResource($item),
                'cart_count' => $summary['total_items'],
            ]);
        } catch (\Throwable $e) {
            return $this->error('CART_ADD_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * PUT /api/cart/items/{itemId}
     * Update the quantity of a cart item.
     */
    public function updateItem(Request $request, int $itemId): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        try {
            $item = $this->cartService->updateItem(
                cartItemId: $itemId,
                quantity: $validated['quantity']
            );

            $summary = $this->cartService->getCartSummary();

            return $this->ok([
                'item'       => new CartItemResource($item),
                'cart_count' => $summary['total_items'],
            ]);
        } catch (\Throwable $e) {
            return $this->error('CART_UPDATE_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * DELETE /api/cart/items/{itemId}
     * Remove a specific item from the cart.
     */
    public function removeItem(int $itemId): JsonResponse
    {
        try {
            $removed = $this->cartService->removeItem($itemId);

            if (! $removed) {
                return $this->error('CART_ITEM_NOT_FOUND', __('common.not_found'), [
                    'item_id' => $itemId,
                ], 404);
            }

            $summary = $this->cartService->getCartSummary();

            return $this->ok([
                'cart_count' => $summary['total_items'],
            ]);
        } catch (\Throwable $e) {
            return $this->error('CART_REMOVE_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * DELETE /api/cart
     * Clear all items from the cart.
     */
    public function clear(): JsonResponse
    {
        try {
            $this->cartService->clearCart();

            return $this->ok([
                'cart_count' => 0,
            ]);
        } catch (\Throwable $e) {
            return $this->error('CART_CLEAR_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/cart/count
     * Retrieve only the number of items in the cart.
     */
    public function count(): JsonResponse
    {
        try {
            $count = $this->cartService->getItemCount();

            return $this->ok([
                'count' => $count,
            ]);
        } catch (\Throwable $e) {
            return $this->error('CART_COUNT_FAILED', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/cart/checkout/validate
     * Validate the cart before checkout.
     */
    public function validateCart(): JsonResponse
    {
        try {
            $validation = $this->cartService->validateCart();

            if (! $validation['valid']) {
                return $this->error('CART_VALIDATION_FAILED', __('validation.failed'), $validation, 422);
            }

            return $this->ok($validation);
        } catch (\Throwable $e) {
            return $this->error('CART_VALIDATION_ERROR', __('common.something_went_wrong'), [
                'exception' => $e->getMessage(),
            ], 500);
        }
    }
}
