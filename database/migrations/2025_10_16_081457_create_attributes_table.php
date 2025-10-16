<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================
// FILE: xxxx_create_attributes_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('attributes', function (Blueprint $table) {
             $table->id();
             $table->string('slug', 100)->unique();
             $table->json('name');
             $table->enum('type', ['text', 'select', 'multiselect', 'color', 'image']);
             $table->boolean('is_filterable')->default(false);
             $table->boolean('is_visible')->default(true);
             $table->integer('position')->default(0);
             $table->integer('sort_order')->default(0);
             $table->timestamps();

             $table->index('slug');
             $table->index('position');
             $table->index('is_filterable');

         });
     }

     public function down(): void
     {
         Schema::dropIfExists('attributes');
     }
 };
