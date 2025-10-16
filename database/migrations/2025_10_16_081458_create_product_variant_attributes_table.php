<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================
// PRODUCT VARIANT ATTRIBUTES (PIVOT)
// File: xxxx_xx_xx_create_product_variant_attributes_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('product_variant_attributes', function (Blueprint $table) {
             $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade');
             $table->foreignId('attribute_option_id')->constrained()->onDelete('cascade');
             $table->primary(['variant_id', 'attribute_option_id'], 'pva_primary');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('product_variant_attributes');
     }
 };
