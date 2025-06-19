<?php

namespace Database\Factories;

use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    public function definition(): array
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create([
            'id_admin' => $admin->id,
        ]);

        return [
            'id_admin' => $admin->id,
            'id_profil' => $profil->id,
        ];
    }
}
