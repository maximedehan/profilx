<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdministrateurRequest;
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
    public function store(AdministrateurRequest $request)
    {
		$admin = Administrateur::create($request->validated());

        return new AdministrateurResource($admin);
    }

    // Affiche un administrateur par id
    public function show(Administrateur $administrateur)
    {
        return new AdministrateurResource($administrateur);
    }

    // Met à jour un administrateur
    public function update(AdministrateurRequest $request, Administrateur $administrateur)
    {
		$administrateur->update($request->validated());

        return new AdministrateurResource($administrateur);
    }

    // Supprime un administrateur
    public function destroy(Administrateur $administrateur)
    {
        $administrateur->delete();

        return response()->noContent();
    }
}
