<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "creating" event.
     */
    public function creating(Order $order): void
    {
        // Ако няма номер – генерирай автоматично
        if (! $order->order_number) {
            $order->order_number = Order::generateOrderNumber();
        }

        // Задай начални статуси, ако липсват
        $order->status = $order->status ?? Order::STATUS_PENDING;
        $order->payment_status = $order->payment_status ?? Order::PAYMENT_PENDING;
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Тук можеш да сложиш логика за известяване по имейл, webhook, и т.н.
        Log::info("✅ Order #{$order->order_number} was created.");
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        cache()->forget("order_{$order->id}");
    }
}
