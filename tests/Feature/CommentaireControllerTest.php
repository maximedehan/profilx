<?php

namespace Tests\Feature;

use App\Models\Administrateur;
use App\Models\Commentaire;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentaireControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        Commentaire::factory()->count(3)->create();
        $response = $this->getJson('/api/commentaires');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_store()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create(['id_admin' => $admin->id]);

        $data = [
            'id_profil' => $profil->id,
        ];

        $response = $this->actingAs($admin, 'admin_api')->postJson('/api/commentaires', $data);
        $response->assertCreated()->assertJsonFragment(['id_profil' => $profil->id]);
        $this->assertDatabaseHas('commentaires', ['id_profil' => $profil->id]);
    }
	
	public function test_store_fails_if_duplicate_commentaire()
	{
		$admin = Administrateur::factory()->create();
		$profil = Profil::factory()->create(['id_admin' => $admin->id]);

		// Créer un commentaire pour cet admin
		Commentaire::factory()->create([
			'id_admin' => $admin->id,
			'id_profil' => $profil->id,
		]);

		// Tenter d'en créer un second
		$data = ['id_profil' => $profil->id];
		$response = $this->actingAs($admin, 'admin_api')->postJson('/api/commentaires', $data);

		$response->assertStatus(409);
		$response->assertJsonFragment(['error' => 'Vous avez déjà soumis un commentaire.']);
	}

    public function test_store_fails_unauthorized()
    {
        $profil = Profil::factory()->create();
        $response = $this->postJson('/api/commentaires', ['id_profil' => $profil->id]);
        $response->assertStatus(401); // Non authentifié
    }

    public function test_store_fails_validation()
    {
        $admin = Administrateur::factory()->create();
        $response = $this->actingAs($admin, 'admin_api')->postJson('/api/commentaires', []);
        $response->assertStatus(422);
    }

    public function test_show()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create(['id_admin' => $admin->id]);
        $commentaire = Commentaire::factory()->create([
            'id_admin' => $admin->id,
            'id_profil' => $profil->id
        ]);

        $response = $this->getJson("/api/commentaires/{$commentaire->id}");
        $response->assertOk()->assertJsonFragment(['id' => $commentaire->id]);
    }

    public function test_update()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create(['id_admin' => $admin->id]);
        $commentaire = Commentaire::factory()->create([
            'id_admin' => $admin->id,
            'id_profil' => $profil->id
        ]);

        $newProfil = Profil::factory()->create(['id_admin' => $admin->id]);

        $response = $this->putJson("/api/commentaires/{$commentaire->id}", [
            'id_profil' => $newProfil->id
        ]);

        $response->assertOk()->assertJsonFragment(['id_profil' => $newProfil->id]);
    }

    public function test_update_fails_validation()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create(['id_admin' => $admin->id]);
        $commentaire = Commentaire::factory()->create([
            'id_admin' => $admin->id,
            'id_profil' => $profil->id
        ]);

        $response = $this->putJson("/api/commentaires/{$commentaire->id}", [
            'id_profil' => null  // champ requis manquant
        ]);

        $response->assertStatus(422);
    }

    public function test_destroy()
    {
        $admin = Administrateur::factory()->create();
        $profil = Profil::factory()->create(['id_admin' => $admin->id]);
        $commentaire = Commentaire::factory()->create([
            'id_admin' => $admin->id,
            'id_profil' => $profil->id
        ]);

        $response = $this->deleteJson("/api/commentaires/{$commentaire->id}");
        $response->assertNoContent();
        $this->assertDatabaseMissing('commentaires', ['id' => $commentaire->id]);
    }
}
