<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // 🔗 Relationships
            $table->foreignId('order_id')
                ->constrained() // references "orders" table
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained() // references "products" table
                ->nullOnDelete();

            $table->foreignId('variant_id')
                ->nullable()
                ->constrained('product_variants') // references "product_variants" table
                ->nullOnDelete();

            // 🧾 Item details
            $table->string('sku')->nullable();        // product SKU at the time of purchase
            $table->string('name')->nullable();       // product name at the time of purchase
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // ⏱️ Timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
