<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================
// FILE: xxxx_create_redirects_table.php
// ============================================

 return new class extends Migration
 {
     public function up(): void
     {
         Schema::create('redirects', function (Blueprint $table) {
             $table->id();
             $table->string('old_url', 500);
             $table->string('new_url', 500);
             $table->smallInteger('status_code')->default(301);
             $table->boolean('is_active')->default(true);
             $table->timestamps();

             $table->index('old_url');
             $table->index('is_active');
         });
     }

     public function down(): void
     {
         Schema::dropIfExists('redirects');
     }
 };
