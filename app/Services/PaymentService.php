<?php

namespace App\Services;

use App\Models\Order;
//use Stripe\StripeClient;

class PaymentService
{
    protected StripeClient $stripe;

    public function __construct()
    {
//        $this->stripe = new StripeClient(config('services.stripe.secret'));
        $this->stripe = null;
    }

    public function createPaymentIntent(Order $order)
    {
        return $this->stripe->paymentIntents->create([
            'amount' => (int) ($order->total * 100),
            'currency' => 'eur',
            'metadata' => ['order_id' => $order->id],
        ]);
    }

    public function handleWebhook(array $payload)
    {
        // process Stripe webhook (payment_succeeded, payment_failed etc.)
    }
}
