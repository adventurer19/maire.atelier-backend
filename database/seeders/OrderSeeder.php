<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Coupon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = Coupon::all();

        Order::factory(20)
            ->create()
            ->each(function ($order) use ($coupons) {
                // Add random items
                OrderItem::factory(rand(1, 4))->create([
                    'order_id' => $order->id,
                ]);

                // Add addresses
                OrderAddress::factory()->create([
                    'order_id' => $order->id,
                    'type' => 'billing',
                ]);
                OrderAddress::factory()->create([
                    'order_id' => $order->id,
                    'type' => 'shipping',
                ]);

                // Randomly attach a coupon
                if ($coupons->isNotEmpty() && rand(0, 1)) {
                    $coupon = $coupons->random();
                    $order->coupons()->attach($coupon->id, [
                        'discount_amount' => $coupon->calculateDiscount($order->subtotal),
                    ]);
                }
            });
    }
}
