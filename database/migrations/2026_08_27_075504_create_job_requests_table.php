<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('job_requests', function (Blueprint $table) { $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('brand');
            $table->string('model');
            $table->foreignId('body_type_id')->constrained('body_types');
            $table->foreignId('service_id')->nullable()->constrained('services');
            $table->foreignId('material_id')->nullable()->constrained('materials');
            $table->decimal('estimated_price');
            $table->text('message')->nullable();
            $table->string('status');
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('job_requests'); } };
