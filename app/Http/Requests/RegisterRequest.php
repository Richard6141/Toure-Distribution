<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Knuckles\Scribe\Attributes\BodyParam;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    #[BodyParam("firstname", "string", "Prénom de l'utilisateur", required: true, example: "John")]
    #[BodyParam("lastname", "string", "Nom de famille de l'utilisateur", required: true, example: "DOE")]
    #[BodyParam("username", "string", "Nom d'utilisateur unique", required: true, example: "johndoe")]
    #[BodyParam("email", "string", "Adresse email unique", required: true, example: "john@example.com")]
    #[BodyParam("phonenumber", "string", "Numéro de téléphone (optionnel)", required: false, example: "+33612345678")]
    #[BodyParam("poste", "string", "Poste/fonction (optionnel)", required: false, example: "Développeur")]
    #[BodyParam("password", "string", "Mot de passe (min 8 caractères, majuscule, chiffre, symbole)", required: true, example: "SecurePass123!")]
    #[BodyParam("password_confirmation", "string", "Confirmation du mot de passe", required: true, example: "SecurePass123!")]
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
            'firstname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'lastname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÿ\s]+$/'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username', 'regex:/^[a-zA-Z0-9_.-]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phonenumber' => ['nullable', 'string', 'regex:/^(\+[0-9]{1,4})?[0-9]{8,15}$/'],
            'poste' => ['nullable', 'string', 'max:100'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase() // Majuscules et minuscules
                    ->numbers()   // Au moins un chiffre
                    ->symbols()   // Au moins un symbole
                    ->uncompromised() // Vérification contre les mots de passe compromis
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'Le prénom est obligatoire.',
            'firstname.regex' => 'Le prénom ne peut contenir que des lettres et espaces.',
            'lastname.required' => 'Le nom est obligatoire.',
            'lastname.regex' => 'Le nom ne peut contenir que des lettres et espaces.',
            'username.required' => 'Le nom d\'utilisateur est obligatoire.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé.',
            'username.regex' => 'Le nom d\'utilisateur ne peut contenir que des lettres, chiffres, points, tirets et underscores.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phonenumber.regex' => 'Le numéro de téléphone n\'est pas valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'firstname' => ucfirst(strtolower(trim($this->firstname))),
            'lastname' => strtoupper(trim($this->lastname)),
            'username' => strtolower(trim($this->username)),
            'email' => strtolower(trim($this->email)),
        ]);
    }
}