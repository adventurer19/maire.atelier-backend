<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberFactory extends Factory
{
    protected $model = NewsletterSubscriber::class;

    public function definition(): array
    {
        $isSubscribed = $this->faker->boolean(80);

        return [
            'email' => $this->faker->unique()->safeEmail(),
            'status' => $isSubscribed
                ? NewsletterSubscriber::STATUS_SUBSCRIBED
                : NewsletterSubscriber::STATUS_UNSUBSCRIBED,
            'subscribed_at' => $this->faker->dateTimeBetween('-90 days', 'now'),
            'unsubscribed_at' => $isSubscribed
                ? null
                : $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * State for active subscribers only.
     */
    public function subscribed(): self
    {
        return $this->state(fn() => [
            'status' => NewsletterSubscriber::STATUS_SUBSCRIBED,
            'unsubscribed_at' => null,
        ]);
    }

    /**
     * State for unsubscribed users.
     */
    public function unsubscribed(): self
    {
        return $this->state(fn() => [
            'status' => NewsletterSubscriber::STATUS_UNSUBSCRIBED,
            'unsubscribed_at' => now(),
        ]);
    }
}
