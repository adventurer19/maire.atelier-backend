<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            // 🏷️ Core
            $table->string('code')->unique();
            $table->string('description')->nullable();

            // 💰 Discount type and value
            $table->enum('type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('value', 10, 2)->default(0);

            // 💵 Usage & limits
            $table->decimal('min_purchase_amount', 10, 2)->nullable();
            $table->decimal('max_discount_amount', 10, 2)->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('usage_count')->default(0);

            // 📅 Validity
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();

            // 🎯 Scope of application
            $table->string('applies_to')->default('all'); // 'all', 'category', 'product'

            // ⚙️ Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
