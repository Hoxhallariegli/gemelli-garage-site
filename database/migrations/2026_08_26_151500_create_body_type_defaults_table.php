<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('body_type_defaults')) {
            Schema::create('body_type_defaults', function (Blueprint $table) {
                $table->id();
                $table->string('body_type')->unique();
                $table->string('model_3d_path')->nullable();
                $table->timestamps();
            });

            // Pre-fill with existing body types
            $types = ['MICRO', 'HATCH', 'CONVERTIBLE', 'COUPE', 'SEDAN', 'SMALL SUV', 'LARGE SUV/SEDAN', 'MPV', 'PICKUP TRUCK', 'SMALL VAN', 'LARGE VAN', 'TRUCK CAB'];
            foreach ($types as $type) {
                \Illuminate\Support\Facades\DB::table('body_type_defaults')->insert([
                    'body_type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('body_type_defaults');
    }
};
