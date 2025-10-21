<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
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

            // 🧾 Cart data
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 10, 2)->nullable(); // can store snapshot price
            $table->string('token', 100)->nullable()->index(); // guest token

            $table->timestamps();

            // 🔒 Prevent duplicates for same user/product/variant/token
            $table->unique(['user_id', 'product_id', 'variant_id', 'token'], 'cart_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
