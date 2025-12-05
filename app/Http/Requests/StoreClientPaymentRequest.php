<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreClientPaymentRequest extends FormRequest
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
            'client_id' => [
                'required',
                'uuid',
                'exists:clients,client_id',
            ],
            'montant' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999999.99',
            ],
            'mode_paiement' => [
                'required',
                'string',
                'in:especes,cheque,virement,mobile_money,carte',
            ],
            'numero_transaction' => [
                'nullable',
                'string',
                'max:100',
                'required_if:mode_paiement,mobile_money,virement',
            ],
            'numero_cheque' => [
                'nullable',
                'string',
                'max:50',
                'required_if:mode_paiement,cheque',
            ],
            'banque' => [
                'nullable',
                'string',
                'max:100',
                'required_if:mode_paiement,cheque,virement',
            ],
            'note' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'date_paiement' => [
                'nullable',
                'date',
            ],
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
            'client_id.required' => 'Le client est requis.',
            'client_id.uuid' => 'L\'identifiant du client doit être un UUID valide.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',

            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.gt' => 'Le montant doit être supérieur à 0.',
            'montant.max' => 'Le montant est trop élevé.',

            'mode_paiement.required' => 'Le mode de paiement est requis.',
            'mode_paiement.in' => 'Le mode de paiement sélectionné n\'est pas valide. Modes acceptés : espèces, chèque, virement, mobile money, carte.',

            'numero_transaction.required_if' => 'Le numéro de transaction est requis pour le mode de paiement sélectionné.',
            'numero_transaction.max' => 'Le numéro de transaction ne peut pas dépasser 100 caractères.',

            'numero_cheque.required_if' => 'Le numéro de chèque est requis pour un paiement par chèque.',
            'numero_cheque.max' => 'Le numéro de chèque ne peut pas dépasser 50 caractères.',

            'banque.required_if' => 'La banque est requise pour ce mode de paiement.',
            'banque.max' => 'Le nom de la banque ne peut pas dépasser 100 caractères.',

            'note.max' => 'La note ne peut pas dépasser 1000 caractères.',

            'date_paiement.date' => 'La date de paiement n\'est pas valide.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'client_id' => 'client',
            'montant' => 'montant',
            'mode_paiement' => 'mode de paiement',
            'numero_transaction' => 'numéro de transaction',
            'numero_cheque' => 'numéro de chèque',
            'banque' => 'banque',
            'note' => 'note',
            'date_paiement' => 'date de paiement',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erreur de validation des données',
            'errors' => $validator->errors()
        ], 422));
    }
}
