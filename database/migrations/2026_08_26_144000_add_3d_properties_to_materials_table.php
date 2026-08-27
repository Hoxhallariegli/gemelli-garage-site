<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('hex_code')->nullable()->after('brand');
            $table->decimal('roughness', 3, 2)->default(0.5)->after('hex_code');
            $table->decimal('metalness', 3, 2)->default(0.0)->after('roughness');
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['hex_code', 'roughness', 'metalness']);
        });
    }
};
