<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('vehicle_models', function (Blueprint $table) { $table->id();
            $table->foreignId('brand_id')->constrained('vehicle_brands');
            $table->string('name');
            $table->string('body_type')->nullable();
            $table->decimal('wrap_meters_needed');
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('vehicle_models'); } };