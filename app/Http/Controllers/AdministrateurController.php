<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdministrateurResource;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdministrateurController extends Controller
{
    // Liste tous les administrateurs
    public function index()
    {
        $admins = Administrateur::all();
        return AdministrateurResource::collection($admins);
    }

    // Crée un nouvel administrateur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
        ]);

        $admin = Administrateur::create($validated);

        return new AdministrateurResource($admin);
    }

    // Affiche un administrateur par id
    public function show(Administrateur $administrateur)
    {
        return new AdministrateurResource($administrateur);
    }

    // Met à jour un administrateur
    public function update(Request $request, Administrateur $administrateur)
    {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
        ]);

        $administrateur->update($validated);

        return new AdministrateurResource($administrateur);
    }

    // Supprime un administrateur
    public function destroy(Administrateur $administrateur)
    {
        $administrateur->delete();

        return response()->noContent();
    }
}
