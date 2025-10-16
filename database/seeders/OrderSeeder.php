<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            Order::factory()->count(rand(0, 5))->create([
                'user_id' => $user->id,
            ])->each(function ($order) {
                // Създай OrderItems
                $products = \App\Models\Product::inRandomOrder()->take(rand(1, 5))->get();

                foreach ($products as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->sale_price ?? $product->price;

                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $quantity * $price,
                    ]);
                }

                // Създай OrderAddress
                \App\Models\OrderAddress::factory()->create([
                    'order_id' => $order->id,
                    'type' => 'billing',
                ]);

                \App\Models\OrderAddress::factory()->create([
                    'order_id' => $order->id,
                    'type' => 'shipping',
                ]);

                // Обнови total на поръчката
                $subtotal = $order->items()->sum('subtotal');
                $order->update([
                    'subtotal' => $subtotal,
                    'total' => $subtotal + $order->tax + $order->shipping - ($order->discount ?? 0),
                ]);
            });
        }
    }
}
