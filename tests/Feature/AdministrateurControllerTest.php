<?php

namespace Tests\Feature;

use App\Models\Administrateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdministrateurControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Administrateur::factory()->count(3)->create();
        $response = $this->getJson('/api/administrateurs');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_store()
    {
        $data = ['nom' => 'Dupont', 'prenom' => 'Jean'];
        $response = $this->postJson('/api/administrateurs', $data);
        $response->assertCreated()->assertJsonFragment($data);
        $this->assertDatabaseHas('administrateurs', $data);
    }

    public function test_show()
    {
        $admin = Administrateur::factory()->create();
        $response = $this->getJson("/api/administrateurs/{$admin->id}");
        $response->assertOk()->assertJsonFragment([
            'id' => $admin->id,
            'nom' => $admin->nom,
            'prenom' => $admin->prenom,
        ]);
    }

    public function test_update()
    {
        $admin = Administrateur::factory()->create();
        $data = ['nom' => 'Martin'];
        $response = $this->putJson("/api/administrateurs/{$admin->id}", $data);
        $response->assertOk()->assertJsonFragment($data);
        $this->assertDatabaseHas('administrateurs', array_merge(['id' => $admin->id], $data));
    }

    public function test_destroy()
    {
        $admin = Administrateur::factory()->create();
        $response = $this->deleteJson("/api/administrateurs/{$admin->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('administrateurs', ['id' => $admin->id]);
    }
}
