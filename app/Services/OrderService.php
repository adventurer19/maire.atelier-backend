<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class OrderService
{
    /**
     * Get all orders for a specific user.
     */
    public function getUserOrders(User $user): EloquentCollection
    {
        return Order::where('user_id', $user->id)
            ->with(['items.product', 'address'])
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Get a single order by ID, ensuring it belongs to the user.
     */
    public function getOrderById(string $orderId, User $user): ?Order
    {
        return Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->with(['items.product', 'address'])
            ->first();
    }

    /**
     * Create an order for a given user.
     */
    public function createOrder(?User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $cartItems = CartItem::query()
                ->when($user, fn ($q) => $q->where('user_id', $user->id))
                ->when(!$user && isset($data['cart_token']), fn ($q) => $q->where('token', $data['cart_token']))
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $subtotal = $cartItems->sum(fn ($item) => $item->price * $item->quantity);
            $shipping = 9.90;
            $tax = $subtotal * 0.2;
            $total = $subtotal + $shipping + $tax;

            $orderData = [
                'subtotal'       => $subtotal,
                'shipping_total' => $shipping,
                'tax_total'      => $tax,
                'total'          => $total,
                'status'         => 'pending',
                'payment_method' => $data['payment_method'],
                'notes'          => $data['notes'] ?? null,
                'address_id'     => $data['address_id'] ?? null,
            ];

            if ($user) {
                $orderData['user_id'] = $user->id;
            } else {
                // Guest checkout data
                $orderData['guest_name']  = $data['guest_name'] ?? 'Guest';
                $orderData['guest_email'] = $data['guest_email'] ?? null;
                $orderData['guest_phone'] = $data['guest_phone'] ?? null;
            }

            $order = Order::create($orderData);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $item->price * $item->quantity,
                ]);
            }

            // Clear guest cart by token or user_id
            if ($user) {
                CartItem::where('user_id', $user->id)->delete();
            } elseif (isset($data['cart_token'])) {
                CartItem::where('token', $data['cart_token'])->delete();
            }

            return $order->load(['items.product']);
        });
    }

    /**
     * Cancel a user's order.
     */
    public function cancelOrder(string $orderId, User $user): ?Order
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if (! $order) {
            return null;
        }

        if (in_array($order->status, ['shipped', 'completed'])) {
            throw new \Exception('Cannot cancel an order that has already shipped.');
        }

        $order->update(['status' => 'cancelled']);

        Log::info("Order {$order->id} cancelled by user {$user->id}");

        return $order;
    }

    /**
     * Delete an order (for admin or system cleanup).
     */
    public function deleteOrder(string $orderId): bool
    {
        $order = Order::find($orderId);

        if (! $order) {
            return false;
        }

        return $order->delete();
    }
}
