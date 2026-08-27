<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('body_types', function (Blueprint $table) { $table->id();
            $table->string('name');
            $table->decimal('wrap_meters');
            $table->string('image')->nullable();
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('body_types'); } };