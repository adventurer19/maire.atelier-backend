<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Проверяваме дали колоните вече не съществуват преди да ги добавим
            if (!Schema::hasColumn('products', 'is_taxable')) {
                $table->boolean('is_taxable')->default(true)->after('is_featured');
            }

            if (!Schema::hasColumn('products', 'stock_status')) {
                $table->enum('stock_status', ['in_stock', 'out_of_stock', 'preorder'])
                    ->default('in_stock')
                    ->after('stock_quantity');
            }

            if (!Schema::hasColumn('products', 'requires_shipping')) {
                $table->boolean('requires_shipping')->default(true)->after('depth');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_taxable', 'stock_status', 'requires_shipping']);
        });
    }
};
