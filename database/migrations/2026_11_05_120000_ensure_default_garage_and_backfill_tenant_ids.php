<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ensure Garages table exists & has default Garage #1
        if (Schema::hasTable('garages')) {
            $defaultGarageExists = DB::table('garages')->where('id', 1)->exists();
            if (!$defaultGarageExists) {
                DB::table('garages')->insert([
                    'id' => 1,
                    'name' => 'Gemelli Garage',
                    'slug' => 'gemelli-garage',
                    'phone' => '+355690000000',
                    'email' => 'info@gemelligarage.com',
                    'sms_enabled' => true,
                    'whatsapp_enabled' => true,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 2. Ensure all users have tenant_id = 1 if null or 0
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'tenant_id')) {
            DB::table('users')->whereNull('tenant_id')->orWhere('tenant_id', 0)->update(['tenant_id' => 1]);

            // Link users to garage_user pivot table
            if (Schema::hasTable('garage_user')) {
                $users = DB::table('users')->get();
                foreach ($users as $u) {
                    DB::table('garage_user')->updateOrInsert(
                        ['garage_id' => 1, 'user_id' => $u->id],
                        ['created_at' => now(), 'updated_at' => now()]
                    );
                }
            }
        }

        // 3. Backfill tenant_id = 1 across ALL 18 domain tables
        $domainTables = [
            'jobs',
            'cars',
            'clients',
            'payments',
            'expenses',
            'materials',
            'parts',
            'services',
            'suppliers',
            'purchases',
            'job_requests',
            'sms_templates',
            'sms_logs',
            'sms_devices',
            'call_logs',
            'material_brands',
            'vehicle_brands',
            'vehicle_models',
        ];

        foreach ($domainTables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tenant_id')) {
                DB::table($table)->whereNull('tenant_id')->orWhere('tenant_id', 0)->update(['tenant_id' => 1]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op backfill migration
    }
};
