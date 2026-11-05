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
        $tableNames = config('permission.table_names');
        $teamsKey = config('permission.column_names.team_foreign_key', 'tenant_id');

        // Add teams column to roles table if not exists
        if (Schema::hasTable($tableNames['roles']) && !Schema::hasColumn($tableNames['roles'], $teamsKey)) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($teamsKey) {
                $table->unsignedBigInteger($teamsKey)->nullable()->after('id');
                $table->index($teamsKey, 'roles_team_foreign_key_index');
            });
        }

        // Add teams column to model_has_roles table if not exists
        if (Schema::hasTable($tableNames['model_has_roles']) && !Schema::hasColumn($tableNames['model_has_roles'], $teamsKey)) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamsKey) {
                $table->unsignedBigInteger($teamsKey)->nullable();
                $table->index($teamsKey, 'model_has_roles_team_foreign_key_index');
            });
        }

        // Add teams column to model_has_permissions table if not exists
        if (Schema::hasTable($tableNames['model_has_permissions']) && !Schema::hasColumn($tableNames['model_has_permissions'], $teamsKey)) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamsKey) {
                $table->unsignedBigInteger($teamsKey)->nullable();
                $table->index($teamsKey, 'model_has_permissions_team_foreign_key_index');
            });
        }

        // Create device_tokens table
        if (!Schema::hasTable('device_tokens')) {
            Schema::create('device_tokens', function (Blueprint $table) use ($teamsKey) {
                $table->id();
                $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->unsignedBigInteger($teamsKey)->nullable()->index();
                $table->text('fcm_token');
                $table->string('device_name')->nullable();
                $table->string('platform')->nullable();
                $table->boolean('is_sms_gateway')->default(false);
                $table->timestamp('last_used_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_tokens');

        $tableNames = config('permission.table_names');
        $teamsKey = config('permission.column_names.team_foreign_key', 'tenant_id');

        if (Schema::hasTable($tableNames['roles']) && Schema::hasColumn($tableNames['roles'], $teamsKey)) {
            Schema::table($tableNames['roles'], function (Blueprint $table) use ($teamsKey) {
                $table->dropColumn($teamsKey);
            });
        }

        if (Schema::hasTable($tableNames['model_has_roles']) && Schema::hasColumn($tableNames['model_has_roles'], $teamsKey)) {
            Schema::table($tableNames['model_has_roles'], function (Blueprint $table) use ($teamsKey) {
                $table->dropColumn($teamsKey);
            });
        }

        if (Schema::hasTable($tableNames['model_has_permissions']) && Schema::hasColumn($tableNames['model_has_permissions'], $teamsKey)) {
            Schema::table($tableNames['model_has_permissions'], function (Blueprint $table) use ($teamsKey) {
                $table->dropColumn($teamsKey);
            });
        }
    }
};
