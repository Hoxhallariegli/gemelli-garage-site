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
        if (!Schema::hasTable('garages')) {
            Schema::create('garages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('logo')->nullable();
                $table->boolean('sms_enabled')->default(true);
                $table->boolean('whatsapp_enabled')->default(true);
                $table->integer('reminder_hours_before')->default(2);
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        // Ensure pivot table for users <-> garages exists
        if (!Schema::hasTable('garage_user')) {
            Schema::create('garage_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('garage_id')->constrained('garages')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Add tenant_id (or garage_id) to users table if not exists
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'tenant_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('tenant_id')->nullable()->index()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garage_user');
        Schema::dropIfExists('garages');
    }
};
