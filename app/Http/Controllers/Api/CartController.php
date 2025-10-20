<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Get cart items and summary
     *
     * GET /api/cart
     */
    public function index(): JsonResponse
    {
        try {
            $summary = $this->cartService->getCartSummary();

            return response()->json([
                'data' => [
                    'items' => CartItemResource::collection($summary['items']),
                    'summary' => [
                        'subtotal' => $summary['subtotal'],
                        'shipping' => $summary['shipping'],
                        'tax' => $summary['tax'],
                        'total' => $summary['total'],
                        'total_items' => $summary['total_items'],
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add item to cart
     *
     * POST /api/cart/items
     * Body: { product_id, quantity, variant_id? }
     */
    public function addItem(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        try {
            $item = $this->cartService->addItem(
                productId: $validated['product_id'],
                quantity: $validated['quantity'],
                variantId: $validated['variant_id'] ?? null
            );

            $summary = $this->cartService->getCartSummary();

            return response()->json([
                'message' => 'Item added to cart successfully',
                'data' => [
                    'item' => new CartItemResource($item),
                    'cart_count' => $summary['total_items'],
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'CART_ADD_FAILED',
            ], 422);
        }
    }

    /**
     * Update cart item quantity
     *
     * PUT /api/cart/items/{item}
     * Body: { quantity }
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

            return response()->json([
                'message' => 'Cart item updated successfully',
                'data' => [
                    'item' => new CartItemResource($item),
                    'cart_count' => $summary['total_items'],
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'CART_UPDATE_FAILED',
            ], 422);
        }
    }

    /**
     * Remove item from cart
     *
     * DELETE /api/cart/items/{item}
     */
    public function removeItem(int $itemId): JsonResponse
    {
        try {
            $removed = $this->cartService->removeItem($itemId);

            if (!$removed) {
                return response()->json([
                    'message' => 'Cart item not found',
                    'error' => 'CART_ITEM_NOT_FOUND',
                ], 404);
            }

            $summary = $this->cartService->getCartSummary();

            return response()->json([
                'message' => 'Item removed from cart successfully',
                'data' => [
                    'cart_count' => $summary['total_items'],
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => 'CART_REMOVE_FAILED',
            ], 422);
        }
    }

    /**
     * Clear entire cart
     *
     * DELETE /api/cart
     */
    public function clear(): JsonResponse
    {
        try {
            $this->cartService->clearCart();

            return response()->json([
                'message' => 'Cart cleared successfully',
                'data' => [
                    'cart_count' => 0,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cart item count only (lightweight endpoint)
     *
     * GET /api/cart/count
     */
    public function count(): JsonResponse
    {
        try {
            $count = $this->cartService->getItemCount();

            return response()->json([
                'data' => [
                    'count' => $count,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch cart count',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate cart before checkout
     *
     * POST /api/cart/validate
     */
    public function validate(): JsonResponse
    {
        try {
            $validation = $this->cartService->validateCart();

            return response()->json([
                'data' => $validation,
            ], $validation['valid'] ? 200 : 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to validate cart',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
