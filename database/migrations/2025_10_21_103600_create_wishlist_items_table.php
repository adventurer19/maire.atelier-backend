<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlist_items', function (Blueprint $table) {
            $table->id();

            // 🔗 Relationships
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            // 🧾 Guest wishlist support
            $table->string('token', 100)->nullable()->index();

            // ⏱️ Timestamps
            $table->timestamps();

            // 🔒 Prevent duplicates (user or guest cannot wishlist the same product twice)
            $table->unique(['user_id', 'product_id', 'variant_id', 'token'], 'wishlist_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist_items');
    }
};
