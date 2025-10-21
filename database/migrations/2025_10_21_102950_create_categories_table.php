<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // 🔗 Self-reference
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // 🏷️ Basic fields
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();

            // 🧠 SEO fields
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();

            // 🖼️ Image
            $table->string('image')->nullable();

            // ⚙️ Display flags
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('show_in_menu')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
