<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        // 25 active, 5 unsubscribed
        NewsletterSubscriber::factory()->count(25)->subscribed()->create();
        NewsletterSubscriber::factory()->count(5)->unsubscribed()->create();
        $this->command->info('💌 Newsletter subscribers seeded successfully.');
    }
}
