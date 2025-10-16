<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================
// FILE: xxxx_create_order_items_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('order_items', function (Blueprint $table) {
             $table->id();
             $table->foreignId('order_id')->constrained()->onDelete('cascade');
             $table->foreignId('product_id')->constrained()->onDelete('restrict');
             $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('restrict');
             $table->string('sku', 100);
             $table->string('name', 255);
             $table->integer('quantity');
             $table->decimal('price', 10, 2);
             $table->decimal('subtotal', 10, 2);
             $table->timestamps();

             $table->index('order_id');
             $table->index('product_id');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('order_items');
     }
 };
