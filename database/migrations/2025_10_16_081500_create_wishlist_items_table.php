<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// ============================================
// FILE: xxxx_create_wishlist_items_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('wishlist_items', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->foreignId('product_id')->constrained()->onDelete('cascade');
             $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
             $table->timestamps();

             $table->unique(['user_id', 'product_id', 'variant_id']);
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('wishlist_items');
     }
 };
