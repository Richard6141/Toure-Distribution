<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'email' => 'nullable|email|max:255',
            'ifu' => 'nullable|string|max:50',
            'phonenumber' => 'nullable|string|max:20',
            'credit_limit' => 'nullable|numeric|min:0|max:999999999999.99',
            'current_balance' => 'nullable|numeric|min:-999999999999.99|max:999999999999.99',
            'base_reduction' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // name_client
            'name_client.required' => 'Le nom du client est obligatoire',
            'name_client.string' => 'Le nom du client doit être une chaîne de caractères',
            'name_client.max' => 'Le nom du client ne peut pas dépasser 255 caractères',

            // name_representant
            'name_representant.string' => 'Le nom du représentant doit être une chaîne de caractères',
            'name_representant.max' => 'Le nom du représentant ne peut pas dépasser 255 caractères',

            // marketteur
            'marketteur.string' => 'Le nom du marketteur doit être une chaîne de caractères',
            'marketteur.max' => 'Le nom du marketteur ne peut pas dépasser 255 caractères',

            // client_type_id
            'client_type_id.uuid' => 'Le type de client doit être un identifiant UUID valide',
            'client_type_id.exists' => 'Le type de client sélectionné n\'existe pas dans la base de données',

            // adresse
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères',

            // city
            'city.string' => 'La ville doit être une chaîne de caractères',
            'city.max' => 'La ville ne peut pas dépasser 100 caractères',

            // email
            'email.email' => 'L\'adresse email doit être valide (exemple: client@exemple.com)',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères',
            'email.unique' => 'Cette adresse email est déjà utilisée par un autre client',

            // ifu
            'ifu.string' => 'Le numéro IFU doit être une chaîne de caractères',
            'ifu.max' => 'Le numéro IFU ne peut pas dépasser 50 caractères',
            'ifu.unique' => 'Ce numéro IFU est déjà utilisé par un autre client',

            // phonenumber
            'phonenumber.string' => 'Le numéro de téléphone doit être une chaîne de caractères',
            'phonenumber.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères',

            // credit_limit
            'credit_limit.numeric' => 'La limite de crédit doit être un nombre',
            'credit_limit.min' => 'La limite de crédit doit être un nombre positif (minimum: 0)',
            'credit_limit.max' => 'La limite de crédit ne peut pas dépasser 999 999 999 999,99',

            // current_balance
            'current_balance.numeric' => 'Le solde actuel doit être un nombre',
            'current_balance.min' => 'Le solde actuel ne peut pas être inférieur à -999 999 999 999,99',
            'current_balance.max' => 'Le solde actuel ne peut pas dépasser 999 999 999 999,99',

            // base_reduction
            'base_reduction.numeric' => 'La réduction de base doit être un nombre',
            'base_reduction.min' => 'La réduction de base doit être un nombre positif (minimum: 0%)',
            'base_reduction.max' => 'La réduction de base ne peut pas dépasser 100%',

            // is_active
            'is_active.boolean' => 'Le statut actif doit être true ou false',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name_client' => 'nom du client',
            'name_representant' => 'nom du représentant',
            'marketteur' => 'marketteur',
            'client_type_id' => 'type de client',
            'adresse' => 'adresse',
            'city' => 'ville',
            'email' => 'adresse email',
            'ifu' => 'numéro IFU',
            'phonenumber' => 'numéro de téléphone',
            'credit_limit' => 'limite de crédit',
            'current_balance' => 'solde actuel',
            'base_reduction' => 'réduction de base',
            'is_active' => 'statut actif',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Erreur de validation des données',
                'errors' => $validator->errors(),
                'summary' => $this->getErrorSummary($validator->errors()->toArray())
            ], 422)
        );
    }

    /**
     * Get a summary of validation errors.
     */
    private function getErrorSummary(array $errors): array
    {
        $summary = [];
        foreach ($errors as $field => $messages) {
            $summary[] = [
                'field' => $field,
                'message' => $messages[0] // Premier message d'erreur pour chaque champ
            ];
        }
        return $summary;
    }
}
