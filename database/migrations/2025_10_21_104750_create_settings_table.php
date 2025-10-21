<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // 🔑 Unique key name (e.g., "site_name", "currency", "tax_rate")
            $table->string('key')->unique();

            // 🧩 Value stored as string (can be JSON, number, boolean, etc.)
            $table->text('value')->nullable();

            // 📘 Type hint for casting ('string', 'number', 'boolean', 'json')
            $table->enum('type', ['string', 'number', 'boolean', 'json'])->default('string');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
