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
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('purchase_price', 10, 2)->after('brand')->default(0);
        });

        Schema::table('parts', function (Blueprint $table) {
            $table->renameColumn('price', 'sell_price');
            $table->decimal('purchase_price', 10, 2)->after('name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
        });

        Schema::table('parts', function (Blueprint $table) {
            $table->renameColumn('sell_price', 'price');
            $table->dropColumn('purchase_price');
        });
    }
};
