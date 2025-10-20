<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Get cart identifier (user_id or session_id)
     */
    protected function getCartIdentifier(): array
    {
        $user = auth()->user();

        if ($user) {
            return ['user_id' => $user->id, 'session_id' => null];
        }

        // For guests, use session ID
        $sessionId = session()->getId();
        if (!$sessionId) {
            session()->start();
            $sessionId = session()->getId();
        }

        return ['user_id' => null, 'session_id' => $sessionId];
    }

    /**
     * Get all cart items
     */
    public function getCartItems(): Collection
    {
        $identifier = $this->getCartIdentifier();

        $query = CartItem::query();

        if ($identifier['user_id']) {
            $query->where('user_id', $identifier['user_id']);
        } else {
            $query->where('session_id', $identifier['session_id']);
        }

        return $query->with(['product.media', 'variant'])
            ->get();
    }

    /**
     * Calculate cart totals
     */
    public function getCartSummary(): array
    {
        $items = $this->getCartItems();

        $subtotal = $items->sum(fn($item) => $item->subtotal);
        $totalItems = $items->sum('quantity');

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'total_items' => $totalItems,
            'shipping' => 0, // TODO: Calculate shipping
            'tax' => 0, // TODO: Calculate tax
            'total' => $subtotal,
        ];
    }

    /**
     * Add item to cart
     */
    public function addItem(
        int $productId,
        int $quantity = 1,
        ?int $variantId = null
    ): CartItem {
        // Validate product exists
        $product = Product::findOrFail($productId);

        // Validate variant if provided
        if ($variantId) {
            $variant = ProductVariant::where('product_id', $productId)
                ->findOrFail($variantId);

            // Check stock
            if ($variant->stock < $quantity) {
                throw new \Exception('Insufficient stock for this variant');
            }
        } else {
            // Check product stock
            if ($product->stock < $quantity) {
                throw new \Exception('Insufficient stock');
            }
        }

        $identifier = $this->getCartIdentifier();

        // Check if item already exists
        $existingItem = CartItem::where([
            'product_id' => $productId,
            'variant_id' => $variantId,
        ])
            ->when($identifier['user_id'], fn($q) => $q->where('user_id', $identifier['user_id']))
            ->when($identifier['session_id'], fn($q) => $q->where('session_id', $identifier['session_id']))
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $quantity;

            // Check stock again
            $stock = $variantId ? $variant->stock : $product->stock;
            if ($newQuantity > $stock) {
                throw new \Exception('Cannot add more items. Insufficient stock.');
            }

            $existingItem->update(['quantity' => $newQuantity]);
            return $existingItem->fresh();
        }

        // Create new cart item
        return CartItem::create([
            'user_id' => $identifier['user_id'],
            'session_id' => $identifier['session_id'],
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateItem(int $cartItemId, int $quantity): CartItem
    {
        $identifier = $this->getCartIdentifier();

        $item = CartItem::where('id', $cartItemId)
            ->when($identifier['user_id'], fn($q) => $q->where('user_id', $identifier['user_id']))
            ->when($identifier['session_id'], fn($q) => $q->where('session_id', $identifier['session_id']))
            ->firstOrFail();

        // Check stock
        $stock = $item->variant?->stock ?? $item->product->stock;
        if ($quantity > $stock) {
            throw new \Exception('Insufficient stock');
        }

        if ($quantity <= 0) {
            $item->delete();
            throw new \Exception('Item removed from cart');
        }

        $item->update(['quantity' => $quantity]);
        return $item->fresh();
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $cartItemId): bool
    {
        $identifier = $this->getCartIdentifier();

        $deleted = CartItem::where('id', $cartItemId)
            ->when($identifier['user_id'], fn($q) => $q->where('user_id', $identifier['user_id']))
            ->when($identifier['session_id'], fn($q) => $q->where('session_id', $identifier['session_id']))
            ->delete();

        return $deleted > 0;
    }

    /**
     * Clear entire cart
     */
    public function clearCart(): int
    {
        $identifier = $this->getCartIdentifier();

        return CartItem::query()
            ->when($identifier['user_id'], fn($q) => $q->where('user_id', $identifier['user_id']))
            ->when($identifier['session_id'], fn($q) => $q->where('session_id', $identifier['session_id']))
            ->delete();
    }

    /**
     * Merge guest cart with user cart on login
     */
    public function mergeGuestCart(string $guestSessionId, int $userId): void
    {
        DB::transaction(function () use ($guestSessionId, $userId) {
            $guestItems = CartItem::where('session_id', $guestSessionId)->get();

            foreach ($guestItems as $guestItem) {
                // Check if user already has this item
                $userItem = CartItem::where([
                    'user_id' => $userId,
                    'product_id' => $guestItem->product_id,
                    'variant_id' => $guestItem->variant_id,
                ])->first();

                if ($userItem) {
                    // Merge quantities
                    $newQuantity = $userItem->quantity + $guestItem->quantity;
                    $stock = $guestItem->variant?->stock ?? $guestItem->product->stock;

                    $userItem->update([
                        'quantity' => min($newQuantity, $stock)
                    ]);

                    $guestItem->delete();
                } else {
                    // Move guest item to user
                    $guestItem->update([
                        'user_id' => $userId,
                        'session_id' => null,
                    ]);
                }
            }
        });
    }

    /**
     * Get cart item count
     */
    public function getItemCount(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    /**
     * Validate cart before checkout
     */
    public function validateCart(): array
    {
        $items = $this->getCartItems();
        $errors = [];

        foreach ($items as $item) {
            // Check if product still exists and is active
            if (!$item->product->is_active) {
                $errors[] = "Product '{$item->product->name}' is no longer available";
            }

            // Check stock
            if (!$item->hasEnoughStock()) {
                $stock = $item->variant?->stock ?? $item->product->stock;
                $errors[] = "Only {$stock} items available for '{$item->product->name}'";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }
}
