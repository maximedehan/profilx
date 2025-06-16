<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentaireResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_admin' => $this->id_admin,
            'id_profil' => $this->id_profil,
            'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
            // Optionnel : relations formatées
            // 'administrateur' => new AdministrateurResource($this->whenLoaded('administrateur')),
            // 'profil' => new ProfilResource($this->whenLoaded('profil')),
        ];
    }
}
