<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// ============================================
// COLLECTIONS TABLE
// File: xxxx_xx_xx_create_collections_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('collections', function (Blueprint $table) {
             $table->id();
             $table->string('slug')->unique();
             $table->json('name');
             $table->json('description')->nullable();
             $table->json('meta_title')->nullable();
             $table->json('meta_description')->nullable();
             $table->enum('type', ['manual', 'auto'])->default('manual');
             $table->boolean('is_active')->default(true);
             $table->integer('position')->default(0);
             $table->timestamps();

             $table->index('slug');
             $table->index('is_active');
             $table->index('position');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('collections');
     }
 };
