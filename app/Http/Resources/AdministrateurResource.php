<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdministrateurResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            // Optionnel : relations
            // 'profils' => ProfilResource::collection($this->whenLoaded('profils')),
            // 'commentaires' => CommentaireResource::collection($this->whenLoaded('commentaires')),
        ];
    }
}
