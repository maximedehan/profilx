<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdministrateurFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
        ];
    }
}
