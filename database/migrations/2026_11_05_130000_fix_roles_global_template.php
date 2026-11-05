<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Set all core roles to be global templates (tenant_id = 0)
        DB::table('roles')->whereIn('name', ['admin', 'manager', 'staff', 'admin1', 'berber', 'pronar_i_biznesit_/_sallonit'])->update(['tenant_id' => 0]);

        // 2. Ensure admin role has ALL permissions (111 count instead of 101)
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        if ($adminRole) {
            $permissions = DB::table('permissions')->pluck('id')->toArray();
            $insertData = array_map(fn($pid) => [
                'role_id' => $adminRole->id,
                'permission_id' => $pid
            ], $permissions);

            DB::table('role_has_permissions')->where('role_id', $adminRole->id)->delete();
            DB::table('role_has_permissions')->insert($insertData);
        }
    }

    public function down(): void
    {
    }
};
