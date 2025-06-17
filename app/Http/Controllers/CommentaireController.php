<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentaireResource;
use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin_api')->only(['store']);
	}
	
    public function index()
    {
        return CommentaireResource::collection(Commentaire::all());
    }

    public function store(Request $request)
    {
        // Récupérer l'administrateur connecté
        $admin = auth('admin_api')->user();

        if (!$admin) {
            return response()->json(['error' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'id_profil' => 'required|exists:profils,id',
        ]);

        // Ajout de l'id_admin automatiquement
        $validated['id_admin'] = $admin->id;

        $commentaire = Commentaire::create($validated);

        return new CommentaireResource($commentaire);
    }

    public function show(Commentaire $commentaire)
    {
        return new CommentaireResource($commentaire);
    }

    public function update(Request $request, Commentaire $commentaire)
    {
        $validated = $request->validate([
            'id_admin' => 'sometimes|required|exists:administrateurs,id',
            'id_profil' => 'sometimes|required|exists:profils,id',
        ]);

        $commentaire->update($validated);

        return new CommentaireResource($commentaire);
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();

        return response()->noContent();
    }
}
