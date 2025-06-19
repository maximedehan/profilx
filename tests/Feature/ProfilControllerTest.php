<?php

namespace Tests\Feature;

use App\Enums\StatutProfilEnum;
use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
		$admin = Administrateur::factory()->create();
        Profil::factory()->count(2)->create(['statut' => StatutProfilEnum::Actif, 'id_admin' => $admin->id]);
        Profil::factory()->create(['statut' => StatutProfilEnum::Inactif, 'id_admin' => $admin->id]);
        $response = $this->getJson('/api/profils');
        $response->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_store()
    {
        $admin = Administrateur::factory()->create();
        $data = [
            'nom' => 'Dehan',
            'prenom' => 'Maxime',
            'image' => 'image.jpg',
            'statut' => StatutProfilEnum::Actif,
        ];
        $response = $this->actingAs($admin, 'admin_api')->postJson('/api/profils', $data);
        $response->assertCreated()->assertJsonFragment(['nom' => 'Dehan']);
        $this->assertDatabaseHas('profils', ['nom' => 'Dehan']);
    }

    public function test_store_fails_validation()
    {
        $admin = Administrateur::factory()->create();
        $response = $this->actingAs($admin, 'admin_api')->postJson('/api/profils', []);
        $response->assertStatus(422);
    }

    public function test_show()
    {
		$admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create(['id_admin' => $admin->id]);
        $response = $this->getJson("/api/profils/{$profil->id}");
        $response->assertOk()->assertJsonFragment(['id' => $profil->id]);
    }

    public function test_update()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create();
        $data = ['nom' => 'Updated'];
        $response = $this->actingAs($admin, 'admin_api')->putJson("/api/profils/{$profil->id}", $data);
        $response->assertOk()->assertJsonFragment($data);
    }

    public function test_update_fails_validation()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create();
        $response = $this->actingAs($admin, 'admin_api')->putJson("/api/profils/{$profil->id}", ['statut' => 'invalid']);
        $response->assertStatus(422);
    }

    public function test_destroy()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create();
        $response = $this->actingAs($admin, 'admin_api')->deleteJson("/api/profils/{$profil->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('profils', ['id' => $profil->id]);
    }
}
