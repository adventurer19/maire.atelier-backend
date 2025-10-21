<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // ⭐ Review content
            $table->unsignedTinyInteger('rating')->default(0); // 1–5 stars
            $table->string('title')->nullable();
            $table->text('comment')->nullable();

            // ✅ Meta flags
            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_approved')->default(false);

            // 📊 Stats
            $table->unsignedInteger('helpful_count')->default(0);

            // 🌐 Tracking info
            $table->string('ip_address', 45)->nullable(); // supports IPv6
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // 🔍 Optional indexes
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
