<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            // Check if model_3d exists and model_3d_path doesn't
            if (Schema::hasColumn('vehicle_models', 'model_3d') && !Schema::hasColumn('vehicle_models', 'model_3d_path')) {
                $table->renameColumn('model_3d', 'model_3d_path');
            } elseif (!Schema::hasColumn('vehicle_models', 'model_3d_path')) {
                $table->string('model_3d_path')->nullable()->after('wrap_meters_needed');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->renameColumn('model_3d_path', 'model_3d');
        });
    }
};
