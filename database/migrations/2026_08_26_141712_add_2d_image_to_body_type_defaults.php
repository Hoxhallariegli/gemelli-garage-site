<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('body_type_defaults', function (Blueprint $table) {
            $table->string('image_2d_path')->nullable()->after('model_3d_path');
        });
    }

    public function down(): void
    {
        Schema::table('body_type_defaults', function (Blueprint $table) {
            $table->dropColumn('image_2d_path');
        });
    }
};
