<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// ============================================
// COUPONS TABLE
// File: xxxx_xx_xx_create_coupons_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('coupons', function (Blueprint $table) {
             $table->id();
             $table->string('code', 50)->unique();
             $table->enum('type', ['percentage', 'fixed']);
             $table->decimal('value', 10, 2);
             $table->decimal('min_purchase_amount', 10, 2)->nullable();
             $table->decimal('max_discount_amount', 10, 2)->nullable();
             $table->integer('usage_limit')->nullable();
             $table->integer('usage_count')->default(0);
             $table->timestamp('starts_at')->nullable();
             $table->timestamp('expires_at')->nullable();
             $table->boolean('is_active')->default(true);
             $table->timestamps();

             $table->index('code');
             $table->index('is_active');
             $table->index('expires_at');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('coupons');
     }
 };
