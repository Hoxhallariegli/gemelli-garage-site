<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->uuid('public_token')->nullable()->after('id')->index();
        });

        // Generate tokens for existing jobs
        $jobs = DB::table('jobs')->get();
        foreach ($jobs as $job) {
            DB::table('jobs')->where('id', $job->id)->update(['public_token' => Str::uuid()]);
        }

        Schema::table('jobs', function (Blueprint $table) {
            $table->uuid('public_token')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('public_token');
        });
    }
};
