<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\StatutProfilEnum;

class ProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'nom' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'prenom' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'statut' => $isUpdate
                ? ['sometimes', Rule::in(StatutProfilEnum::values())]
                : ['required', Rule::in(StatutProfilEnum::values())],
        ];
    }
}
