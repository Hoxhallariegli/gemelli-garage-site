<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_services');
    }
};
