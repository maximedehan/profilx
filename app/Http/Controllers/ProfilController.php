<?php

namespace App\Http\Controllers;

use App\Enums\StatutProfilEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilRequest;
use App\Http\Resources\ProfilResource;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
	public function __construct()
	{
		// Protéger store, update et destroy avec l'authentification admin_api
		$this->middleware('auth:admin_api')->only(['store', 'update', 'destroy']);
	}
	
    public function index()
    {
        return ProfilResource::collection(
			Profil::where('statut', StatutProfilEnum::Actif->value)->get()
		);
    }

    public function store(ProfilRequest $request)
    {
		 // Récupérer l'administrateur connecté
		$admin = auth('admin_api')->user();
		
		if (!$admin) {
			return response()->json(['error' => 'Non autorisé. Aucun administrateur associé.'], 403);
		}

		$validated = $request->validated();
		// Ajouter id_admin manuellement
		$validated['id_admin'] = $admin->id;
	
        $profil = Profil::create($validated);

        return new ProfilResource($profil);
    }

    public function show(Profil $profil)
    {
        return new ProfilResource($profil);
    }

    public function update(ProfilRequest $request, Profil $profil)
    {
		$validated = $request->validated();
        $profil->update($validated);

        return new ProfilResource($profil);
    }

    public function destroy(Profil $profil)
    {
        $profil->delete();

        return response()->noContent();
    }
}
