<?php

namespace Database\Factories;

use App\Models\Administrateur;
use App\Enums\StatutProfilEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'image' => $this->faker->imageUrl(200, 200, 'people'),
            'statut' => $this->faker->randomElement(StatutProfilEnum::values()),
            'id_admin' => Administrateur::inRandomOrder()->first()->id,
        ];
    }
}
