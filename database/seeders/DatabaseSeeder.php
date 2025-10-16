<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->count(20)->create();

        $this->call([
            CategorySeeder::class,
            AttributeSeeder::class,
            AttributeOptionSeeder::class,
            MediaSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
            ProductMediaSeeder::class,
            CollectionSeeder::class,
            AddressSeeder::class,
            CartItemSeeder::class,
            WishlistItemSeeder::class,
            OrderSeeder::class,
            ReviewSeeder::class,
            NewsletterSubscriberSeeder::class,
            CouponSeeder::class,
            RedirectSeeder::class,
        ]);
    }
}
