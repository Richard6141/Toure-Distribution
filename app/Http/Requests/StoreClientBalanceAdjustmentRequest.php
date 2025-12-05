<?php

namespace App\Http\Requests;

use App\Models\ClientBalanceAdjustment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreClientBalanceAdjustmentRequest extends FormRequest
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
            'client_id' => 'required|uuid|exists:clients,client_id',
            'type' => 'required|in:dette_initiale,ajustement_credit,ajustement_debit,correction,remise_exceptionnelle',
            'montant' => 'required|numeric|not_in:0',
            'motif' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'source' => 'nullable|in:migration,manuel,import',
            'date_ajustement' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // client_id
            'client_id.required' => 'Le client est obligatoire',
            'client_id.uuid' => 'L\'identifiant du client doit être un UUID valide',
            'client_id.exists' => 'Le client sélectionné n\'existe pas',

            // type
            'type.required' => 'Le type d\'ajustement est obligatoire',
            'type.in' => 'Le type d\'ajustement doit être: dette_initiale, ajustement_credit, ajustement_debit, correction ou remise_exceptionnelle',

            // montant
            'montant.required' => 'Le montant est obligatoire',
            'montant.numeric' => 'Le montant doit être un nombre',
            'montant.not_in' => 'Le montant ne peut pas être égal à zéro',

            // motif
            'motif.required' => 'Le motif de l\'ajustement est obligatoire',
            'motif.string' => 'Le motif doit être une chaîne de caractères',
            'motif.max' => 'Le motif ne peut pas dépasser 255 caractères',

            // note
            'note.string' => 'La note doit être une chaîne de caractères',
            'note.max' => 'La note ne peut pas dépasser 1000 caractères',

            // source
            'source.in' => 'La source doit être: migration, manuel ou import',

            // date_ajustement
            'date_ajustement.date' => 'La date d\'ajustement doit être une date valide',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'client_id' => 'client',
            'type' => 'type d\'ajustement',
            'montant' => 'montant',
            'motif' => 'motif',
            'note' => 'note',
            'source' => 'source',
            'date_ajustement' => 'date d\'ajustement',
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
                'message' => $messages[0]
            ];
        }
        return $summary;
    }
}
