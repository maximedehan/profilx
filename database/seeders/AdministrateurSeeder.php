<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrateur;

class AdministrateurSeeder extends Seeder
{
    public function run(): void
    {
        Administrateur::factory()->count(2)->create();
    }
}
