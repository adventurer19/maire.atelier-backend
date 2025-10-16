<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================
// FILE: xxxx_create_attribute_options_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('attribute_options', function (Blueprint $table) {
             $table->id();
             $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
             $table->string('slug', 100)->unique();
             $table->json('value');
             $table->json('label');
             $table->string('hex_color', 7)->nullable()->comment('For color swatches');
             $table->integer('position')->default(0);
             $table->timestamps();

             $table->unique(['attribute_id', 'slug']);
             $table->index('attribute_id');
             $table->index('position');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('attribute_options');
     }
 };
