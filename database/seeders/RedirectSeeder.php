<?php

namespace Database\Seeders;

use App\Models\Redirect;
use Illuminate\Database\Seeder;

class RedirectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 random redirects
        Redirect::factory()->count(20)->create();

        // Optionally, add some manual examples (useful for testing)
        Redirect::create([
            'from_url' => '/bg/stari-produkt',
            'to_url' => '/bg/nov-produkt',
            'status_code' => 301,
            'is_active' => true,
        ]);

        Redirect::create([
            'from_url' => '/en/old-page',
            'to_url' => '/en/new-page',
            'status_code' => 302,
            'is_active' => true,
        ]);

        $this->command->info('✅ Redirects seeded successfully.');
    }
}
