<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // Static examples
        Coupon::create([
            'code' => 'WELCOME10',
            'description' => '10% off on your first order',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 10,
            'is_active' => true,
            'valid_from' => now()->subDays(5),
            'valid_to' => now()->addDays(60),
            'applies_to' => 'all',
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'description' => 'Free shipping on orders over 50 BGN',
            'type' => Coupon::TYPE_FIXED,
            'value' => 10,
            'min_purchase_amount' => 50,
            'is_active' => true,
            'valid_from' => now(),
            'valid_to' => now()->addDays(30),
            'applies_to' => 'all',
        ]);

        // Random generated
        Coupon::factory(8)->create();
    }
}
