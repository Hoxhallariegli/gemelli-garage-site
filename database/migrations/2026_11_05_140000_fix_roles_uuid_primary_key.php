<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Kontrollo nese ekziston roli me ID "1" si integer (gabim i databazes se vjeter)
        $adminRole = DB::table('roles')->where('id', '1')->first();

        if ($adminRole) {
            $newUuid = (string) Str::uuid();

            // Caktivizo Foreign Key Checks (funksionon per MySQL ne Hostinger)
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Zevendeso '1' me UUID te re neper te gjitha tabelat
            DB::table('role_has_permissions')->where('role_id', '1')->update(['role_id' => $newUuid]);
            DB::table('model_has_roles')->where('role_id', '1')->update(['role_id' => $newUuid]);
            DB::table('roles')->where('id', '1')->update(['id' => $newUuid]);

            // Aktivizo perseri Foreign Key Checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    public function down(): void
    {
    }
};
