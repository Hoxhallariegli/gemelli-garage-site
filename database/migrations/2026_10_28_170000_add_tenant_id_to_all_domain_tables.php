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
        $tables = [
            'users',
            'cars',
            'jobs',
            'clients',
            'payments',
            'expenses',
            'materials',
            'parts',
            'services',
            'suppliers',
            'purchases',
            'call_logs',
            'sms_templates',
            'job_requests',
            'sms_logs',
            'vehicle_brands',
            'vehicle_models',
            'material_brands',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->index();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'cars',
            'jobs',
            'clients',
            'payments',
            'expenses',
            'materials',
            'parts',
            'services',
            'suppliers',
            'purchases',
            'call_logs',
            'sms_templates',
            'job_requests',
            'sms_logs',
            'vehicle_brands',
            'vehicle_models',
            'material_brands',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
