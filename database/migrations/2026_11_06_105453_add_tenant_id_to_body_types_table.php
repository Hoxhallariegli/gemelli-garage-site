<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('body_types') && !Schema::hasColumn('body_types', 'tenant_id')) {
            Schema::table('body_types', function (Blueprint $table) {
                $table->unsignedBigInteger('tenant_id')->nullable()->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('body_types') && Schema::hasColumn('body_types', 'tenant_id')) {
            Schema::table('body_types', function (Blueprint $table) {
                $table->dropColumn('tenant_id');
            });
        }
    }
};
