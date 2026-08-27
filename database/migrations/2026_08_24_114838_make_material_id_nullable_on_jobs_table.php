<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('material_id')->nullable()->change();
            $table->decimal('meters_used')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('material_id')->nullable(false)->change();
            $table->decimal('meters_used')->nullable(false)->change();
        });
    }
};
