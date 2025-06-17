<?php

namespace App\Http\Controllers;

use App\Enums\StatutProfilEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfilResource;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin_api')->only(['store']);
	}
	
    public function index()
    {
        return ProfilResource::collection(Profil::all());
    }

    public function store(Request $request)
    {
		 // Récupérer l'administrateur connecté
		$admin = auth('admin_api')->user();
		
		if (!$admin) {
			return response()->json(['error' => 'Non autorisé. Aucun administrateur associé.'], 403);
		}

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'statut' => ['required', Rule::in(StatutProfilEnum::values())],
        ]);

		// Ajouter id_admin manuellement
		$validated['id_admin'] = $admin->id;
	
        $profil = Profil::create($validated);

        return new ProfilResource($profil);
    }

    public function show(Profil $profil)
    {
        return new ProfilResource($profil);
    }

    public function update(Request $request, Profil $profil)
    {
        $validated = $request->validate([
            'id_admin' => 'sometimes|required|exists:administrateurs,id',
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'image' => 'nullable|string|max:255',
            'statut' => ['sometimes', Rule::in(StatutProfilEnum::values())],
        ]);

        $profil->update($validated);

        return new ProfilResource($profil);
    }

    public function destroy(Profil $profil)
    {
        $profil->delete();

        return response()->noContent();
    }
}
