<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministrateurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
            ];
        }

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            return [
                'nom' => 'sometimes|required|string|max:255',
                'prenom' => 'sometimes|required|string|max:255',
            ];
        }

        return [];
    }
}
