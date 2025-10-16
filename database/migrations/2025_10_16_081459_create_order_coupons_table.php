<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// ============================================
// ORDER COUPONS (PIVOT)
// File: xxxx_xx_xx_create_order_coupons_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('order_coupons', function (Blueprint $table) {
             $table->foreignId('order_id')->constrained()->onDelete('cascade');
             $table->foreignId('coupon_id')->constrained()->onDelete('restrict');
             $table->decimal('discount_amount', 10, 2);
             $table->primary(['order_id', 'coupon_id']);
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('order_coupons');
     }
 };
