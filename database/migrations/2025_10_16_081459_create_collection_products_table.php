<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// ============================================
// COLLECTION PRODUCTS (PIVOT)
// File: xxxx_xx_xx_create_collection_products_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('collection_products', function (Blueprint $table) {
             $table->foreignId('collection_id')->constrained()->onDelete('cascade');
             $table->foreignId('product_id')->constrained()->onDelete('cascade');
             $table->integer('position')->default(0);
             $table->primary(['collection_id', 'product_id']);
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('collection_products');
     }
 };
