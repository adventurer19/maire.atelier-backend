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
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
            WishlistItemSeeder::class,
            ReviewSeeder::class,
            NewsletterSubscriberSeeder::class,
            SettingSeeder::class,
            RedirectSeeder::class,
        ]);
    }
}
