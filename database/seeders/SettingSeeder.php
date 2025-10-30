<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // 🏪 Store info
            ['key' => 'store.name', 'value' => 'Maire Atelier', 'type' => Setting::TYPE_STRING],
            ['key' => 'store.email', 'value' => 'info@maireatelier.bg', 'type' => Setting::TYPE_STRING],
            ['key' => 'store.phone', 'value' => '+359 888 123 456', 'type' => Setting::TYPE_STRING],
            ['key' => 'store.address', 'value' => 'Sofia, Bulgaria', 'type' => Setting::TYPE_STRING],
            ['key' => 'store.currency', 'value' => 'BGN', 'type' => Setting::TYPE_STRING],
            ['key' => 'store.locale', 'value' => 'bg', 'type' => Setting::TYPE_STRING],
            ['key' => 'store.tax_rate', 'value' => '20', 'type' => Setting::TYPE_NUMBER],

            // 🛒 Orders
            ['key' => 'orders.auto_approve_reviews', 'value' => 'true', 'type' => Setting::TYPE_BOOLEAN],
            ['key' => 'orders.low_stock_threshold', 'value' => '5', 'type' => Setting::TYPE_NUMBER],
            ['key' => 'orders.free_shipping_minimum', 'value' => '100', 'type' => Setting::TYPE_NUMBER],

            // 💌 Emails
            ['key' => 'mail.from_address', 'value' => 'noreply@maireatelier.bg', 'type' => Setting::TYPE_STRING],
            ['key' => 'mail.from_name', 'value' => 'Maire Atelier', 'type' => Setting::TYPE_STRING],

            // 🌐 Socials
            ['key' => 'social.facebook', 'value' => 'https://facebook.com/maireatelier', 'type' => Setting::TYPE_STRING],
            ['key' => 'social.instagram', 'value' => 'https://instagram.com/maireatelier', 'type' => Setting::TYPE_STRING],
            ['key' => 'social.tiktok', 'value' => 'https://tiktok.com/@maireatelier', 'type' => Setting::TYPE_STRING],

            // ⚙️ Misc
            ['key' => 'site.maintenance_mode', 'value' => 'false', 'type' => Setting::TYPE_BOOLEAN],
            ['key' => 'site.allow_guest_checkout', 'value' => 'true', 'type' => Setting::TYPE_BOOLEAN],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info('⚙️ Settings seeded successfully.');
    }
}
