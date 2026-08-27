<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('jobs', function (Blueprint $table) { $table->id();
            $table->foreignId('car_id')->constrained('cars');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('material_id')->constrained('materials')->nullable();
            $table->decimal('meters_used')->nullable();
            $table->decimal('final_price');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled']);
            $table->datetime('job_date');
            $table->text('notes')->nullable();
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('jobs'); } };