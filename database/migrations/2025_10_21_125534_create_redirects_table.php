<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();

            // Original URL (unique)
            $table->string('from_url')->unique();

            // Target URL
            $table->string('to_url');

            // HTTP status code (301 = permanent, 302 = temporary)
            $table->unsignedSmallInteger('status_code')->default(301);

            // Enable/disable redirect
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Optional indexing for faster lookups
            $table->index(['is_active', 'status_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
