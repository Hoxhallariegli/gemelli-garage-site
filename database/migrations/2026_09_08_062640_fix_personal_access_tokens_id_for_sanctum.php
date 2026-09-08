<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ne Hostinger/MySQL, ndryshimi i ID-se nga UUID ne BigInt kerkon fshirjen dhe rikrijimin
        // sepse eshte Primary Key.

        Schema::dropIfExists('personal_access_tokens');

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // Kjo krijon bigIncrements('id') standard
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
