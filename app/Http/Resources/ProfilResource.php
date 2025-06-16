<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_admin' => $this->id_admin,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'image' => $this->image,
            'statut' => $this->statut,
            'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
            // Optionnel : inclure les relations
            // 'administrateur' => new AdministrateurResource($this->whenLoaded('administrateur')),
            // 'commentaires' => CommentaireResource::collection($this->whenLoaded('commentaires')),
        ];
    }
}
