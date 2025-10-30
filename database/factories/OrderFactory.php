<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statuses = [
            Order::STATUS_PENDING,
            Order::STATUS_PROCESSING,
            Order::STATUS_SHIPPED,
            Order::STATUS_DELIVERED,
        ];

        $paymentStatuses = [
            Order::PAYMENT_PENDING,
            Order::PAYMENT_PAID,
            Order::PAYMENT_FAILED,
        ];

        $subtotal = $this->faker->randomFloat(2, 50, 300);
        $shipping = $this->faker->randomFloat(2, 0, 15);
        $tax = $this->faker->randomFloat(2, 2, 15);
        $discount = $this->faker->randomFloat(2, 0, 20);

        return [
            'order_number' => Order::generateOrderNumber(),
            'user_id' => User::inRandomOrder()->value('id'),
            'guest_name' => null,
            'guest_email' => null,
            'guest_phone' => null,
            'status' => $this->faker->randomElement($statuses),
            'payment_status' => $this->faker->randomElement($paymentStatuses),
            'payment_method' => $this->faker->randomElement(['cod', 'card', 'paypal']),
            'subtotal' => $subtotal,
            'shipping_total' => $shipping,
            'tax_total' => $tax,
            'discount_total' => $discount,
            'total' => $subtotal + $shipping + $tax - $discount,
            'currency' => 'BGN',
            'notes' => $this->faker->optional()->sentence(),
            'customer_ip' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
