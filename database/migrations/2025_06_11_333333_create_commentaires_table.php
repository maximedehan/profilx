<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->constrained('administrateurs')->onDelete('cascade');
            $table->foreignId('id_profil')->constrained('profils')->onDelete('cascade');
            $table->timestamps(); // created_at remplace date_creation
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};
