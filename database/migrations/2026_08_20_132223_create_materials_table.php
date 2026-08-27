<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('materials', function (Blueprint $table) { $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->decimal('sell_price');
            $table->decimal('stock_meters');
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('materials'); } };