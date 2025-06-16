<?php

namespace App\Http\Controllers;

use App\Enums\StatutProfilEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfilResource;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index()
    {
        return ProfilResource::collection(Profil::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_admin' => 'required|exists:administrateurs,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'statut' => ['required', Rule::in(StatutProfilEnum::values())],
        ]);

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
