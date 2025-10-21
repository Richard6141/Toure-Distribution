<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_client' => 'required|string|max:255',
            'name_representant' => 'nullable|string|max:255',
            'marketteur' => 'nullable|string|max:255',
            'client_type_id' => 'nullable|uuid|exists:client_types,client_type_id',
            'adresse' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'ifu' => 'nullable|string|max:50|unique:clients,ifu',
            'phones' => 'required|array|min:1',
            'phones.*.phone_number' => 'required|string|max:20|distinct',
            'phones.*.type' => 'required|in:mobile,fixe,whatsapp,autre',
            'phones.*.label' => 'nullable|string|max:50',
            'credit_limit' => 'nullable|numeric|min:0|max:999999999999.99',
            'current_balance' => 'nullable|numeric|min:-999999999999.99|max:999999999999.99',
            'base_reduction' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name_client.required' => 'Le nom du client est requis',
            'client_type_id.exists' => 'Le type de client sélectionné n\'existe pas',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'email.email' => 'L\'adresse email doit être valide',
            'ifu.unique' => 'Ce numéro IFU est déjà utilisé',
            'phones.required' => 'Les numéros de téléphone sont requis',
            'phones.min' => 'Vous devez fournir au minimum 1 numéro de téléphone',
            'phones.*.phone_number.required' => 'Le numéro de téléphone est requis',
            'phones.*.phone_number.distinct' => 'Les numéros de téléphone doivent être uniques',
            'phones.*.type.required' => 'Le type de téléphone est requis',
            'phones.*.type.in' => 'Le type de téléphone doit être: mobile, fixe, whatsapp ou autre',
            'credit_limit.min' => 'La limite de crédit doit être positive',
            'base_reduction.min' => 'La réduction de base doit être positive',
            'base_reduction.max' => 'La réduction de base ne peut pas dépasser 100%',
        ];
    }
}
