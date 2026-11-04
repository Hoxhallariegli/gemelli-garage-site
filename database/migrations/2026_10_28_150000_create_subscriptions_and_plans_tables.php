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
        if (!Schema::hasTable('plans')) {
            Schema::create('plans', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('price', 12, 2)->default(0);
                $table->integer('duration_months')->default(1);
                $table->integer('max_users')->default(5);
                $table->integer('max_cars')->default(100);
                $table->integer('max_jobs')->default(500);
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tenant_id')->nullable()->index();
                $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
                $table->datetime('starts_at');
                $table->datetime('ends_at');
                $table->enum('status', ['trial', 'active', 'expired', 'cancelled'])->default('trial');
                $table->boolean('auto_renew')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('subscription_renewals')) {
            Schema::create('subscription_renewals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tenant_id')->nullable()->index();
                $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
                $table->enum('payment_method', ['bank_transfer', 'cash', 'card', 'online'])->default('bank_transfer');
                $table->string('transfer_document')->nullable();
                $table->decimal('amount', 12, 2)->default(0);
                $table->text('notes')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_renewals');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('plans');
    }
};
