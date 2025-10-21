<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation to attributes
            $table->foreignId('attribute_id')
                ->constrained('attributes')
                ->cascadeOnDelete();

            // 🔤 Option details
            $table->string('slug')->index();
            $table->json('value'); // Translatable (e.g. {"en": "Red", "bg": "Червен"})
            $table->string('hex_color', 20)->nullable(); // Used for swatch attributes

            // ⚙️ Display settings
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // 🔒 Prevent duplicate slugs per attribute
            $table->unique(['attribute_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_options');
    }
};
