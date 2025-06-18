<?php

namespace Database\Factories;

use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_admin' => Administrateur::inRandomOrder()->first()->id,
            'id_profil' => Profil::inRandomOrder()->first()->id,
        ];
    }
}
