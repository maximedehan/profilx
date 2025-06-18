<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Déjà protégé via middleware auth
    }

    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'POST') {
            return [
                'id_profil' => 'required|exists:profils,id',
            ];
        }

        if (in_array($method, ['PUT', 'PATCH'])) {
            return [
                'id_admin' => 'sometimes|required|exists:administrateurs,id',
                'id_profil' => 'sometimes|required|exists:profils,id',
            ];
        }

        return [];
    }
}
