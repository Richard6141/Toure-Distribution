<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockMovementRequest extends FormRequest
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
        $rules = [
            'reference' => 'required|string|max:255',
            'movement_type_id' => 'required|exists:stock_movement_types,stock_movement_type_id',
            'entrepot_from_id' => 'nullable|exists:entrepots,entrepot_id',
            'entrepot_to_id' => 'nullable|exists:entrepots,entrepot_id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,fournisseur_id',
            'client_id' => 'nullable|exists:clients,client_id',
            'statut' => 'required|in:pending,completed,cancelled',
            'note' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,user_id',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,product_id',
            'details.*.quantity' => 'required|integer|min:1'
        ];

        // Pour la mise à jour, on exclut l'ID actuel de la validation unique
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $id = $this->route('id');
            $rules['reference'] .= '|unique:stock_movements,reference,' . $id . ',stock_movement_id';
        } else {
            $rules['reference'] .= '|unique:stock_movements,reference';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reference.required' => 'La référence est obligatoire.',
            'reference.string' => 'La référence doit être une chaîne de caractères.',
            'reference.max' => 'La référence ne peut pas dépasser 255 caractères.',
            'reference.unique' => 'Cette référence existe déjà.',
            'movement_type_id.required' => 'Le type de mouvement est obligatoire.',
            'movement_type_id.exists' => 'Le type de mouvement sélectionné n\'existe pas.',
            'entrepot_from_id.exists' => 'L\'entrepôt source sélectionné n\'existe pas.',
            'entrepot_to_id.exists' => 'L\'entrepôt destination sélectionné n\'existe pas.',
            'fournisseur_id.exists' => 'Le fournisseur sélectionné n\'existe pas.',
            'client_id.exists' => 'Le client sélectionné n\'existe pas.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut doit être "pending", "completed" ou "cancelled".',
            'note.string' => 'La note doit être une chaîne de caractères.',
            'note.max' => 'La note ne peut pas dépasser 1000 caractères.',
            'user_id.required' => 'L\'utilisateur est obligatoire.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'details.required' => 'Les détails du mouvement sont obligatoires.',
            'details.array' => 'Les détails doivent être un tableau.',
            'details.min' => 'Au moins un détail est requis.',
            'details.*.product_id.required' => 'Le produit est obligatoire pour chaque détail.',
            'details.*.product_id.exists' => 'Le produit sélectionné n\'existe pas.',
            'details.*.quantity.required' => 'La quantité est obligatoire pour chaque détail.',
            'details.*.quantity.integer' => 'La quantité doit être un nombre entier.',
            'details.*.quantity.min' => 'La quantité doit être au moins 1.'
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
            'reference' => 'référence',
            'movement_type_id' => 'type de mouvement',
            'entrepot_from_id' => 'entrepôt source',
            'entrepot_to_id' => 'entrepôt destination',
            'fournisseur_id' => 'fournisseur',
            'client_id' => 'client',
            'statut' => 'statut',
            'note' => 'note',
            'user_id' => 'utilisateur',
            'details' => 'détails',
            'details.*.product_id' => 'produit',
            'details.*.quantity' => 'quantité'
        ];
    }
}