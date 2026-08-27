<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('cars', function (Blueprint $table) { $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('brand_id')->constrained('vehicle_brands');
            $table->foreignId('model_id')->constrained('vehicle_models');
            $table->string('year')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('color')->nullable();
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('cars'); } };