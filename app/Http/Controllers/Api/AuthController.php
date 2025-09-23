<?php

namespace App\Http\Controllers\Api;

use Log;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Knuckles\Scribe\Attributes\Group;
use App\Http\Requests\RegisterRequest;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Illuminate\Validation\Rules\Password as PasswordRule;

#[Group("Authentification", "Gestion des utilisateurs et authentification")]

class AuthController extends Controller
{
    /**
     * Inscription d'un nouvel utilisateur
     */
    #[Endpoint(
        title: "Inscription d'un utilisateur",
        description: "Créer un nouveau compte utilisateur avec validation complète des données"
    )]
    #[Response([
        'success' => true,
        'message' => 'Inscription réussie',
        'data' => [
            'user' => [
                'user_id' => '550e8400-e29b-41d4-a716-446655440000',
                'firstname' => 'John',
                'lastname' => 'DOE',
                'username' => 'johndoe',
                'email' => 'john@example.com',
                'phonenumber' => '+33612345678',
                'poste' => 'Développeur',
                'is_active' => true,
                'email_verified' => false,
                'created_at' => '2024-01-15 10:30:00'
            ],
            'access_token' => '1|abcdef123456789...',
            'token_type' => 'Bearer'
        ]
    ], 201)]
    #[Response([
        'success' => false,
        'message' => 'Erreur de validation',
        'errors' => [
            'email' => ['Cet email est déjà utilisé.'],
            'username' => ['Ce nom d\'utilisateur est déjà pris.']
        ]
    ], 422)]

    public function register(Request $request): JsonResponse
    {
        try {
            // Préparation des données (nettoyage et formatage)
            $data = $request->all();
            if (isset($data['firstname'])) {
                $data['firstname'] = ucfirst(strtolower(trim($data['firstname'])));
            }
            if (isset($data['lastname'])) {
                $data['lastname'] = strtoupper(trim($data['lastname']));
            }
            if (isset($data['username'])) {
                $data['username'] = strtolower(trim($data['username']));
            }
            if (isset($data['email'])) {
                $data['email'] = strtolower(trim($data['email']));
            }

            // Règles de validation
            $rules = [
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

            // Messages d'erreur personnalisés
            $messages = [
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

            // Validation des données
            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validatedData = $validator->validated();

            // Créer l'utilisateur
            $user = User::create([
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'phonenumber' => $validatedData['phonenumber'] ?? null,
                'poste' => $validatedData['poste'] ?? null,
                'password' => Hash::make($validatedData['password']),
                'password_changed_at' => now(),
                'is_active' => true,
            ]);

            // Générer un token si Sanctum est disponible
            $token = null;
            if (class_exists(\Laravel\Sanctum\Sanctum::class)) {
                $token = $user->createToken('auth-token')->plainTextToken;
            }

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Inscription réussie',
                'data' => [
                    'user' => [
                        'user_id' => $user->user_id,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'username' => $user->username,
                        'email' => $user->email,
                        'is_active' => $user->is_active,
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'inscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vérifier la disponibilité d'un username
     */
    #[Endpoint(
        title: "Vérifier disponibilité username",
        description: "Vérifier si un nom d'utilisateur est disponible"
    )]
    #[Response([
        'success' => true,
        'available' => true,
        'message' => 'Nom d\'utilisateur disponible'
    ])]
    #[Response([
        'success' => true,
        'available' => false,
        'message' => 'Nom d\'utilisateur déjà pris'
    ])]

    public function checkUsername(string $username): JsonResponse
    {
        $available = !User::where('username', strtolower($username))->exists();

        return response()->json([
            'success' => true,
            'available' => $available,
            'message' => $available ? 'Nom d\'utilisateur disponible' : 'Nom d\'utilisateur déjà pris'
        ]);
    }

    /**
     * Vérifier la disponibilité d'un email
     */
    #[Endpoint(
        title: "Vérifier disponibilité email",
        description: "Vérifier si un email est disponible"
    )]
    public function checkEmail(string $email): JsonResponse
    {
        $available = !User::where('email', strtolower($email))->exists();

        return response()->json([
            'success' => true,
            'available' => $available,
            'message' => $available ? 'Email disponible' : 'Email déjà utilisé'
        ]);
    }

    /**
     * Obtenir le profil de l'utilisateur connecté
     */
    #[Endpoint(
        title: "Profil utilisateur",
        description: "Récupérer les informations de l'utilisateur connecté"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification")]
    #[ResponseFromApiResource(UserResource::class, User::class)]

    public function profile(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Connexion utilisateur
     */
    #[Endpoint(
        title: "Connexion utilisateur",
        description: "Authentifier un utilisateur avec email/username et mot de passe"
    )]
    #[BodyParam("login", "string", "Email ou nom d'utilisateur", required: true, example: "john@example.com")]
    #[BodyParam("password", "string", "Mot de passe", required: true, example: "SecurePass123!")]
    #[BodyParam("remember", "boolean", "Se souvenir de moi", required: false, example: false)]
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'login' => ['required', 'string'],
                'password' => ['required', 'string'],
                'remember' => ['boolean']
            ], [
                'login.required' => 'L\'email ou nom d\'utilisateur est obligatoire.',
                'password.required' => 'Le mot de passe est obligatoire.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $login = strtolower(trim($request->login));
            $password = $request->password;
            $remember = $request->boolean('remember', false);

            // Déterminer si c'est un email ou username
            $loginField = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            // Récupérer l'utilisateur
            $user = User::where($loginField, $login)->first();

            if (!$user) {
                $this->recordLoginAttempt(null, $login, $request->ip(), 'user_not_found');
                return response()->json([
                    'success' => false,
                    'message' => 'Identifiants incorrects.'
                ], 401);
            }

            // Vérifier si le compte est actif
            if (!$user->is_active) {
                $this->recordLoginAttempt($user->user_id, $login, $request->ip(), 'account_disabled');
                return response()->json([
                    'success' => false,
                    'message' => 'Votre compte a été désactivé.'
                ], 401);
            }

            // Vérifier si le compte est verrouillé
            if ($user->locked_until && Carbon::parse($user->locked_until)->isFuture()) {
                $this->recordLoginAttempt($user->user_id, $login, $request->ip(), 'account_locked');
                return response()->json([
                    'success' => false,
                    'message' => 'Votre compte est temporairement verrouillé. Réessayez plus tard.'
                ], 423);
            }

            // Vérifier le mot de passe
            if (!Hash::check($password, $user->password)) {
                $user->increment('failed_login_attempts');

                // Verrouiller le compte après 5 tentatives échouées
                if ($user->failed_login_attempts >= 5) {
                    $user->update(['locked_until' => now()->addMinutes(15)]);
                }

                $this->recordLoginAttempt($user->user_id, $login, $request->ip(), 'wrong_password');
                return response()->json([
                    'success' => false,
                    'message' => 'Identifiants incorrects.'
                ], 401);
            }

            // Authentification réussie
            $user->update([
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => now(),
                'last_login_ip' => $request->ip()
            ]);

            $this->recordLoginAttempt($user->user_id, $login, $request->ip(), 'success');

            // Générer le token
            $tokenName = 'auth-token';
            if ($remember) {
                $tokenName = 'remember-token';
            }

            $token = $user->createToken($tokenName)->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'data' => [
                    'user' => [
                        'user_id' => $user->user_id,
                        'firstname' => $user->firstname,
                        'lastname' => $user->lastname,
                        'username' => $user->username,
                        'email' => $user->email,
                        'is_active' => $user->is_active,
                        'last_login_at' => $user->last_login_at,
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la connexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Changement de mot de passe pour utilisateur connecté
     */
    #[Endpoint(
        title: "Changer le mot de passe",
        description: "Changer le mot de passe de l'utilisateur connecté"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification")]
    #[BodyParam("current_password", "string", "Mot de passe actuel", required: true)]
    #[BodyParam("password", "string", "Nouveau mot de passe", required: true)]
    #[BodyParam("password_confirmation", "string", "Confirmation du nouveau mot de passe", required: true)]
    public function changePassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'password' => [
                    'required',
                    'confirmed',
                    'different:current_password',
                    PasswordRule::min(8)->mixedCase()->numbers()->symbols()->uncompromised()
                ],
            ], [
                'current_password.required' => 'Le mot de passe actuel est obligatoire.',
                'password.required' => 'Le nouveau mot de passe est obligatoire.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
                'password.different' => 'Le nouveau mot de passe doit être différent de l\'ancien.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();

            // Vérifier le mot de passe actuel
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le mot de passe actuel est incorrect.'
                ], 400);
            }

            // Mettre à jour le mot de passe
            $user->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => now()
            ]);

            // Optionnel : révoquer tous les autres tokens sauf le current
            $user->tokens()->where('id', '!=', $request->user()->currentAccessToken()->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mot de passe modifié avec succès'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de mot de passe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déconnexion utilisateur
     */
    #[Endpoint(
        title: "Déconnexion utilisateur",
        description: "Déconnecter l'utilisateur et révoquer son token"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification")]
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Supprimer le token actuel
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Déconnexion réussie'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la déconnexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déconnexion de tous les appareils
     */
    #[Endpoint(
        title: "Déconnexion globale",
        description: "Déconnecter l'utilisateur de tous ses appareils"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification")]
    public function logoutAll(Request $request): JsonResponse
    {
        try {
            // Supprimer tous les tokens de l'utilisateur
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Déconnexion de tous les appareils réussie'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la déconnexion globale',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Demande de réinitialisation de mot de passe
     */
    #[Endpoint(
        title: "Mot de passe oublié",
        description: "Envoyer un lien de réinitialisation de mot de passe par email"
    )]
    #[BodyParam("email", "string", "Adresse email", required: true, example: "john@example.com")]
    public function forgotPassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:users,email']
            ], [
                'email.required' => 'L\'email est obligatoire.',
                'email.email' => 'L\'email doit être valide.',
                'email.exists' => 'Aucun compte associé à cet email.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = strtolower(trim($request->email));
            $user = User::where('email', $email)->first();

            if (!$user || !$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun compte actif associé à cet email.'
                ], 404);
            }

            // Générer un token de réinitialisation
            $token = Str::random(64);

            // Stocker le token dans la base de données
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

            // Envoyer l'email (à adapter selon votre classe Mail)
            Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

            return response()->json([
                'success' => true,
                'message' => 'Lien de réinitialisation envoyé par email',
                'data' => [
                    'reset_token' => $token // À retirer en production
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du lien',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Réinitialisation du mot de passe
     */
    #[Endpoint(
        title: "Réinitialiser le mot de passe",
        description: "Réinitialiser le mot de passe avec le token reçu par email"
    )]
    #[BodyParam("email", "string", "Adresse email", required: true, example: "john@example.com")]
    #[BodyParam("token", "string", "Token de réinitialisation", required: true, example: "abc123...")]
    #[BodyParam("password", "string", "Nouveau mot de passe", required: true, example: "NewSecurePass123!")]
    #[BodyParam("password_confirmation", "string", "Confirmation du mot de passe", required: true, example: "NewSecurePass123!")]
    public function resetPassword(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'token' => ['required', 'string'],
                'password' => [
                    'required',
                    'confirmed',
                    PasswordRule::min(8)->mixedCase()->numbers()->symbols()->uncompromised()
                ],
            ], [
                'email.required' => 'L\'email est obligatoire.',
                'email.email' => 'L\'email doit être valide.',
                'token.required' => 'Le token est obligatoire.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreurs de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = strtolower(trim($request->email));
            $token = $request->token;

            // Vérifier le token
            $resetRecord = DB::table('password_reset_tokens')
                ->where('email', $email)
                ->first();

            if (!$resetRecord || !Hash::check($token, $resetRecord->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token de réinitialisation invalide.'
                ], 400);
            }

            // Vérifier l'expiration (24 heures)
            if (Carbon::parse($resetRecord->created_at)->addHours(24)->isPast()) {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Le token de réinitialisation a expiré.'
                ], 400);
            }

            // Récupérer l'utilisateur
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé.'
                ], 404);
            }

            // Mettre à jour le mot de passe
            $user->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
                'failed_login_attempts' => 0,
                'locked_until' => null
            ]);

            // Supprimer le token utilisé
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            // Révoquer tous les tokens existants pour forcer une nouvelle connexion
            $user->tokens()->delete();
            try {
                Mail::to($user->email)->send(new PasswordChangedMail($user, $request->ip()));
            } catch (Exception $mailException) {
                Log::warning('Erreur envoi email confirmation changement mot de passe: ' . $mailException->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Mot de passe réinitialisé avec succès'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la réinitialisation',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Enregistrer une tentative de connexion
     */
    private function recordLoginAttempt(?string $userId, string $email, string $ipAddress, string $status): void
    {
        try {
            DB::table('login_attempts')->insert([
                'user_id' => $userId,
                'email' => $email,
                'ip_address' => $ipAddress,
                'status' => $status === 'success' ? 'success' : 'failed',
                'failure_reason' => $status !== 'success' ? $status : null,
                'attempted_at' => now(),
            ]);
        } catch (Exception $e) {
            // Log l'erreur mais ne pas faire échouer la requête principale
            Log::error('Erreur enregistrement tentative de connexion: ' . $e->getMessage());
        }
    }
}