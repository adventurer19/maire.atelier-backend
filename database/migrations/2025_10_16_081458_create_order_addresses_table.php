<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// ============================================
// FILE: xxxx_create_order_addresses_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('order_addresses', function (Blueprint $table) {
             $table->id();
             $table->foreignId('order_id')->constrained()->onDelete('cascade');
             $table->enum('type', ['shipping', 'billing']);
             $table->string('first_name', 100);
             $table->string('last_name', 100);
             $table->string('company', 255)->nullable();
             $table->string('address_line1', 255);
             $table->string('address_line2', 255)->nullable();
             $table->string('city', 100);
             $table->string('state', 100)->nullable();
             $table->string('postal_code', 20);
             $table->string('country', 2)->comment('ISO 3166-1 alpha-2');
             $table->string('phone', 50)->nullable();
             $table->string('email', 255)->nullable();
             $table->timestamps();

             $table->index('order_id');
             $table->index('type');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('order_addresses');
     }
 };
