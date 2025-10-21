<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();

            // 🏷️ Core fields
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();

            // 🧠 SEO
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();

            // 🖼️ Image
            $table->string('image')->nullable();

            // ⚙️ Logic
            $table->enum('type', ['manual', 'auto'])->default('manual');
            $table->json('conditions')->nullable(); // rules for automatic collections

            // 📊 Display flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('position')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
