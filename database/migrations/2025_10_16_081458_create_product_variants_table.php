r<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// ============================================
// PRODUCT VARIANTS TABLE
// File: xxxx_xx_xx_create_product_variants_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('product_variants', function (Blueprint $table) {
             $table->id();
             $table->foreignId('product_id')->constrained()->onDelete('cascade');
             $table->string('sku', 100)->unique();
             $table->decimal('price', 10, 2)->nullable()->comment('if different from base product');
             $table->integer('stock_quantity')->default(0);
             $table->boolean('is_active')->default(true);
             $table->timestamps();

             $table->index('product_id');
             $table->index('sku');
             $table->index('is_active');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('product_variants');
     }
 };
