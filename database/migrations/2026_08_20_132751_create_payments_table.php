<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up() { Schema::create('payments', function (Blueprint $table) { $table->id();
            $table->foreignId('job_id')->constrained('jobs');
            $table->decimal('amount');
            $table->enum('method', ['cash', 'card', 'transfer']);
            $table->datetime('payment_date');
            $table->timestamps(); }); } public function down() { Schema::dropIfExists('payments'); } };