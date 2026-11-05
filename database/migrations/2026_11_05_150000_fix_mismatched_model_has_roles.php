<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Gjej te gjitha rolet ekzistuese te sakta ne tabele
        $adminRole = DB::table('roles')->where('name', 'admin')->first();

        if ($adminRole) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Nëse te model_has_roles ID-ja ka ngelur "1" ose ndonje vlere qe s'perputhet
            // Forcoje me ID-në e saktë (UUID) të rolit Admin
            DB::table('model_has_roles')
                ->where('role_id', '1')
                ->orWhere('role_id', 1)
                ->update([
                    'role_id' => $adminRole->id,
                    'tenant_id' => 0 // Global Admin for Team 0
                ]);

            // Nëse role_has_permissions ka mbetur pas
            DB::table('role_has_permissions')
                ->where('role_id', '1')
                ->orWhere('role_id', 1)
                ->update(['role_id' => $adminRole->id]);

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    public function down(): void
    {
    }
};
