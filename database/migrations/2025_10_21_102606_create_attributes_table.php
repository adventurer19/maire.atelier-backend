<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            // 🔤 Basic info
            $table->string('slug')->unique();
            $table->json('name'); // Translatable (e.g. {"en": "Color", "bg": "Цвят"})
            $table->string('type')->default('select'); // e.g. 'select', 'swatch'

            // ⚙️ Behavior
            $table->integer('position')->default(0);
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
