<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fshijmë tabelën ekzistuese që të pastrojmë konfigurimin e gabuar
        Schema::dropIfExists('personal_access_tokens');

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // ID e vete tokenit (Auto-increment)

            // Përdorim uuidMorphs sepse User model përdor UUID.
            // Kjo krijon 'tokenable_type' dhe 'tokenable_id' (si string/uuid).
            $table->uuidMorphs('tokenable');

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
