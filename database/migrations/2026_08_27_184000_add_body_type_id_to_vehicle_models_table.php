<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_models', 'body_type_id')) {
                $table->foreignId('body_type_id')->nullable()->after('brand_id')->constrained('body_types')->onDelete('cascade');
            }
            if (Schema::hasColumn('vehicle_models', 'body_type')) {
                $table->dropColumn('body_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->dropForeign(['body_type_id']);
            $table->dropColumn('body_type_id');
            $table->string('body_type')->nullable()->after('name');
        });
    }
};
