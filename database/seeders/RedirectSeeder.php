<?php

namespace Database\Seeders;

use App\Models\Redirect;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RedirectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        Redirect::factory()->count(10)->create();
    }
}
