<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_admin')->constrained('administrateurs')->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom');
            $table->string('image')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'en_attente'])->default('en_attente');
            $table->timestamps(); // créé automatiquement created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
