<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentaireRequest;
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

    public function store(CommentaireRequest $request)
    {
        // Récupérer l'administrateur connecté
        $admin = auth('admin_api')->user();

        if (!$admin) {
            return response()->json(['error' => 'Non autorisé.'], 403);
        }
		
		// Empêcher un administrateur de créer plus d'un commentaire
		$exists = Commentaire::where('id_admin', $admin->id)->exists();

		if ($exists) {
			return response()->json([
				'error' => 'Vous avez déjà soumis un commentaire.'
			], 409); // 409 = Conflict
		}

		$validated = $request->validated();
        // Ajout de l'id_admin automatiquement
        $validated['id_admin'] = $admin->id;

        $commentaire = Commentaire::create($validated);

        return new CommentaireResource($commentaire);
    }

    public function show(Commentaire $commentaire)
    {
        return new CommentaireResource($commentaire);
    }

    public function update(CommentaireRequest $request, Commentaire $commentaire)
    {
		$validated = $request->validated();
        $commentaire->update($validated);

        return new CommentaireResource($commentaire);
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();

        return response()->noContent();
    }
}
