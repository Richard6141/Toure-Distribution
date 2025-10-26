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
use App\Mail\PasswordChangedMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserListResource;
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
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Illuminate\Validation\Rules\Password as PasswordRule;

#[Group("Authentification", "Gestion des utilisateurs et authentification")]

class AuthController extends Controller
{

    /**
     * Liste de tous les utilisateurs
     * 
     * Récupère la liste paginée de tous les utilisateurs avec filtres et recherche.
     */
    #[Endpoint(
        title: "Liste des utilisateurs",
        description: "Récupérer la liste paginée de tous les utilisateurs avec filtres optionnels"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[QueryParam("search", "string", "Recherche par nom, email ou username", required: false, example: "jean")]
    #[QueryParam("is_active", "boolean", "Filtrer par statut actif/inactif", required: false, example: true)]
    #[QueryParam("poste", "string", "Filtrer par poste", required: false, example: "Développeur")]
    #[QueryParam("per_page", "integer", "Nombre d'éléments par page (défaut: 15)", required: false, example: 15)]
    #[QueryParam("sort_by", "string", "Tri par champ (created_at, lastname, email)", required: false, example: "created_at")]
    #[QueryParam("sort_order", "string", "Ordre de tri (asc, desc)", required: false, example: "desc")]
    #[Response([
        'success' => true,
        'data' => [
            'users' => [
                [
                    'user_id' => '550e8400-e29b-41d4-a716-446655440000',
                    'firstname' => 'Jean',
                    'lastname' => 'DUPONT',
                    'username' => 'jean.dupont',
                    'email' => 'jean.dupont@example.com',
                    'phonenumber' => '+33612345678',
                    'poste' => 'Développeur',
                    'is_active' => true,
                    'email_verified_at' => '2024-01-10 10:00:00',
                    'last_login_at' => '2024-01-15 14:30:00',
                    'created_at' => '2024-01-10 09:15:00'
                ]
            ],
            'pagination' => [
                'total' => 50,
                'per_page' => 15,
                'current_page' => 1,
                'last_page' => 4,
                'from' => 1,
                'to' => 15
            ]
        ]
    ], 200, "Liste récupérée")]
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 15);
            $sortBy = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');

            $query = User::query();

            // Recherche
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Filtre par statut
            if ($request->has('is_active')) {
                $query->where('is_active', $request->boolean('is_active'));
            }

            // Filtre par poste
            if ($request->has('poste')) {
                $query->where('poste', 'like', "%{$request->poste}%");
            }

            // Tri
            $query->orderBy($sortBy, $sortOrder);

            // Charger les rôles pour la resource
            $query->with('roles');

            // Pagination
            $users = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'users' => UserListResource::collection($users->items()),
                    'pagination' => [
                        'total' => $users->total(),
                        'per_page' => $users->perPage(),
                        'current_page' => $users->currentPage(),
                        'last_page' => $users->lastPage(),
                        'from' => $users->firstItem(),
                        'to' => $users->lastItem(),
                    ]
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des utilisateurs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Inscription d'un nouvel utilisateur
     * 
     * Cette route permet de créer un nouveau compte utilisateur avec validation complète des données.
     * Le mot de passe doit contenir au minimum 8 caractères avec majuscules, minuscules, chiffres et symboles.
     */
    #[Endpoint(
        title: "Inscription d'un utilisateur",
        description: "Créer un nouveau compte utilisateur avec validation complète des données et génération automatique d'un token d'authentification"
    )]
    #[BodyParam("firstname", "string", "Prénom de l'utilisateur (lettres et espaces uniquement)", required: true, example: "Jean")]
    #[BodyParam("lastname", "string", "Nom de famille (lettres et espaces uniquement)", required: true, example: "DUPONT")]
    #[BodyParam("username", "string", "Nom d'utilisateur unique (lettres, chiffres, points, tirets et underscores)", required: true, example: "jean.dupont")]
    #[BodyParam("email", "string", "Adresse email valide et unique", required: true, example: "jean.dupont@example.com")]
    #[BodyParam("phonenumber", "string", "Numéro de téléphone avec indicatif international (optionnel)", required: false, example: "+33612345678")]
    #[BodyParam("poste", "string", "Poste/fonction de l'utilisateur (optionnel)", required: false, example: "Développeur Full-Stack")]
    #[BodyParam("password", "string", "Mot de passe (min. 8 caractères, majuscules, minuscules, chiffres, symboles)", required: true, example: "SecurePass123!")]
    #[BodyParam("password_confirmation", "string", "Confirmation du mot de passe (doit être identique)", required: true, example: "SecurePass123!")]
    #[Response([
        'success' => true,
        'code' => 200,
        'message' => 'Inscription réussie',
        'data' => [
            'user' => [
                'user_id' => '550e8400-e29b-41d4-a716-446655440000',
                'firstname' => 'Jean',
                'lastname' => 'DUPONT',
                'username' => 'jean.dupont',
                'email' => 'jean.dupont@example.com',
                'is_active' => true,
            ],
            'access_token' => '1|abcdef123456789...',
            'token_type' => 'Bearer'
        ]
    ], 201, "Inscription réussie")]
    #[Response([
        'success' => false,
        'message' => 'Erreurs de validation',
        'errors' => [
            'email' => ['Cet email est déjà utilisé.'],
            'username' => ['Ce nom d\'utilisateur est déjà utilisé.'],
            'password' => ['Le mot de passe doit contenir au moins 8 caractères.']
        ]
    ], 422, "Erreurs de validation")]
    #[Response([
        'success' => false,
        'message' => 'Erreur lors de l\'inscription',
        'error' => 'Message d\'erreur détaillé'
    ], 500, "Erreur serveur")]
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

            // Charger les rôles et permissions (si l'utilisateur en a)
            $user->load(['roles.permissions', 'permissions']);

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Inscription réussie',
                'data' => [
                    'user' => new UserResource($user),
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
     * Voir un utilisateur spécifique
     */
    #[Endpoint(
        title: "Détails d'un utilisateur",
        description: "Récupérer les informations complètes d'un utilisateur par son ID"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[UrlParam("id", "string", "UUID de l'utilisateur", required: true, example: "550e8400-e29b-41d4-a716-446655440000")]
    #[Response([
        'success' => true,
        'data' => [
            'user_id' => '550e8400-e29b-41d4-a716-446655440000',
            'firstname' => 'Jean',
            'lastname' => 'DUPONT',
            'username' => 'jean.dupont',
            'email' => 'jean.dupont@example.com',
            'phonenumber' => '+33612345678',
            'poste' => 'Développeur',
            'is_active' => true,
            'email_verified_at' => '2024-01-10 10:00:00',
            'last_login_at' => '2024-01-15 14:30:00',
            'failed_login_attempts' => 0,
            'created_at' => '2024-01-10 09:15:00'
        ]
    ], 200, "Utilisateur trouvé")]
    #[Response([
        'success' => false,
        'message' => 'Utilisateur non trouvé'
    ], 404, "Utilisateur non trouvé")]
    public function show(string $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ], 404);
            }

            // Charger les rôles et permissions
            $user->load(['roles.permissions', 'permissions']);

            return response()->json([
                'success' => true,
                'data' => new UserResource($user)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vérifier la disponibilité d'un nom d'utilisateur
     * 
     * Permet de vérifier en temps réel si un nom d'utilisateur est disponible avant la soumission du formulaire d'inscription.
     */
    #[Endpoint(
        title: "Vérifier disponibilité username",
        description: "Vérifier si un nom d'utilisateur est disponible pour l'inscription"
    )]
    #[UrlParam("username", "string", "Nom d'utilisateur à vérifier", required: true, example: "jean.dupont")]
    #[Response([
        'success' => true,
        'available' => true,
        'message' => 'Nom d\'utilisateur disponible'
    ], 200, "Username disponible")]
    #[Response([
        'success' => true,
        'available' => false,
        'message' => 'Nom d\'utilisateur déjà pris'
    ], 200, "Username indisponible")]
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
     * Activer un utilisateur
     */
    #[Endpoint(
        title: "Activer un utilisateur",
        description: "Réactiver un compte utilisateur désactivé"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[UrlParam("id", "string", "UUID de l'utilisateur", required: true)]
    #[Response([
        'success' => true,
        'message' => 'Utilisateur activé avec succès'
    ], 200, "Activation réussie")]
    public function activate(string $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ], 404);
            }

            $user->update([
                'is_active' => true,
                'failed_login_attempts' => 0,
                'locked_until' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Utilisateur activé avec succès',
                'data' => new UserResource($user->fresh())
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'activation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Statistiques des utilisateurs
     */
    #[Endpoint(
        title: "Statistiques utilisateurs",
        description: "Obtenir des statistiques globales sur les utilisateurs"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[Response([
        'success' => true,
        'data' => [
            'total_users' => 150,
            'active_users' => 142,
            'inactive_users' => 8,
            'verified_emails' => 130,
            'users_with_login_today' => 45,
            'users_with_login_this_week' => 98,
            'locked_accounts' => 2
        ]
    ], 200, "Statistiques récupérées")]
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'active_users' => User::where('is_active', true)->count(),
                'inactive_users' => User::where('is_active', false)->count(),
                'verified_emails' => User::whereNotNull('email_verified_at')->count(),
                'users_with_login_today' => User::whereDate('last_login_at', today())->count(),
                'users_with_login_this_week' => User::whereBetween('last_login_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'locked_accounts' => User::where('locked_until', '>', now())->count()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déverrouiller un compte utilisateur
     */
    #[Endpoint(
        title: "Déverrouiller un compte",
        description: "Déverrouiller un compte utilisateur bloqué après plusieurs tentatives échouées"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[UrlParam("id", "string", "UUID de l'utilisateur", required: true)]
    #[Response([
        'success' => true,
        'message' => 'Compte déverrouillé avec succès'
    ], 200, "Déverrouillage réussi")]
    public function unlock(string $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ], 404);
            }

            $user->update([
                'failed_login_attempts' => 0,
                'locked_until' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Compte déverrouillé avec succès'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du déverrouillage',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vérifier la disponibilité d'un email
     * 
     * Permet de vérifier en temps réel si un email est disponible avant la soumission du formulaire d'inscription.
     */
    #[Endpoint(
        title: "Vérifier disponibilité email",
        description: "Vérifier si un email est disponible pour l'inscription"
    )]
    #[UrlParam("email", "string", "Adresse email à vérifier", required: true, example: "jean.dupont@example.com")]
    #[Response([
        'success' => true,
        'available' => true,
        'message' => 'Email disponible'
    ], 200, "Email disponible")]
    #[Response([
        'success' => true,
        'available' => false,
        'message' => 'Email déjà utilisé'
    ], 200, "Email indisponible")]
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
     * 
     * Récupère toutes les informations du profil de l'utilisateur actuellement authentifié.
     */
    #[Endpoint(
        title: "Profil utilisateur connecté",
        description: "Récupérer les informations complètes de l'utilisateur connecté"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[Response([
        'success' => true,
        'data' => [
            'user_id' => '550e8400-e29b-41d4-a716-446655440000',
            'firstname' => 'Jean',
            'lastname' => 'DUPONT',
            'username' => 'jean.dupont',
            'email' => 'jean.dupont@example.com',
            'phonenumber' => '+33612345678',
            'poste' => 'Développeur Full-Stack',
            'is_active' => true,
            'email_verified' => false,
            'last_login_at' => '2024-01-15 14:30:00',
            'created_at' => '2024-01-10 09:15:00'
        ]
    ], 200, "Profil récupéré avec succès")]
    #[Response([
        'message' => 'Unauthenticated.'
    ], 401, "Token manquant ou invalide")]

    public function profile(): JsonResponse
    {
        $user = auth()->user();

        // Charger les rôles et permissions
        $user->load(['roles.permissions', 'permissions']);

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Connexion utilisateur
     * 
     * Authentifie un utilisateur avec son email ou nom d'utilisateur et son mot de passe.
     * Retourne un token d'accès en cas de succès.
     * Implémente un système de verrouillage après 5 tentatives échouées.
     */
    #[Endpoint(
        title: "Connexion utilisateur",
        description: "Authentifier un utilisateur avec email/username et mot de passe. Le compte est verrouillé 15 minutes après 5 tentatives échouées."
    )]
    #[BodyParam("login", "string", "Email ou nom d'utilisateur", required: true, example: "jean.dupont@example.com")]
    #[BodyParam("password", "string", "Mot de passe", required: true, example: "SecurePass123!")]
    #[BodyParam("remember", "boolean", "Se souvenir de moi (token longue durée)", required: false, example: false)]
    #[Response([
        'success' => true,
        'message' => 'Connexion réussie',
        'data' => [
            'user' => [
                'user_id' => '550e8400-e29b-41d4-a716-446655440000',
                'firstname' => 'Jean',
                'lastname' => 'DUPONT',
                'username' => 'jean.dupont',
                'email' => 'jean.dupont@example.com',
                'is_active' => true,
                'last_login_at' => '2024-01-15 14:30:00',
            ],
            'access_token' => '1|abcdef123456789...',
            'token_type' => 'Bearer'
        ]
    ], 200, "Connexion réussie")]
    #[Response([
        'success' => false,
        'message' => 'Identifiants incorrects.'
    ], 401, "Identifiants invalides")]
    #[Response([
        'success' => false,
        'message' => 'Votre compte a été désactivé.'
    ], 401, "Compte désactivé")]
    #[Response([
        'success' => false,
        'message' => 'Votre compte est temporairement verrouillé. Réessayez plus tard.'
    ], 423, "Compte verrouillé")]
    #[Response([
        'success' => false,
        'message' => 'Erreurs de validation',
        'errors' => [
            'login' => ['L\'email ou nom d\'utilisateur est obligatoire.'],
            'password' => ['Le mot de passe est obligatoire.']
        ]
    ], 422, "Données invalides")]
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

            // Charger les rôles et permissions pour la resource
            $user->load(['roles.permissions', 'permissions']);

            return response()->json([
                'success' => true,
                'message' => 'Connexion réussie',
                'data' => [
                    'user' => new UserResource($user),
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
     * 
     * Permet à un utilisateur authentifié de changer son mot de passe.
     * Nécessite le mot de passe actuel pour des raisons de sécurité.
     */
    #[Endpoint(
        title: "Changer le mot de passe",
        description: "Changer le mot de passe de l'utilisateur connecté. Révoque tous les autres tokens d'authentification."
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[BodyParam("current_password", "string", "Mot de passe actuel", required: true, example: "OldPass123!")]
    #[BodyParam("password", "string", "Nouveau mot de passe (min. 8 caractères, majuscules, minuscules, chiffres, symboles)", required: true, example: "NewSecurePass456#")]
    #[BodyParam("password_confirmation", "string", "Confirmation du nouveau mot de passe", required: true, example: "NewSecurePass456#")]
    #[Response([
        'success' => true,
        'message' => 'Mot de passe modifié avec succès'
    ], 200, "Changement réussi")]
    #[Response([
        'success' => false,
        'message' => 'Le mot de passe actuel est incorrect.'
    ], 400, "Mot de passe actuel invalide")]
    #[Response([
        'success' => false,
        'message' => 'Erreurs de validation',
        'errors' => [
            'password' => ['Le nouveau mot de passe doit être différent de l\'ancien.'],
            'password_confirmation' => ['La confirmation du mot de passe ne correspond pas.']
        ]
    ], 422, "Erreurs de validation")]
    #[Response([
        'message' => 'Unauthenticated.'
    ], 401, "Token manquant ou invalide")]
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
     * 
     * Déconnecte l'utilisateur en révoquant son token d'accès actuel.
     */
    #[Endpoint(
        title: "Déconnexion utilisateur",
        description: "Déconnecter l'utilisateur en révoquant son token d'accès actuel"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[Response([
        'success' => true,
        'message' => 'Déconnexion réussie'
    ], 200, "Déconnexion réussie")]
    #[Response([
        'message' => 'Unauthenticated.'
    ], 401, "Token manquant ou invalide")]
    #[Response([
        'success' => false,
        'message' => 'Erreur lors de la déconnexion',
        'error' => 'Message d\'erreur détaillé'
    ], 500, "Erreur serveur")]
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
     * 
     * Déconnecte l'utilisateur de tous ses appareils en révoquant tous ses tokens d'accès.
     */
    #[Endpoint(
        title: "Déconnexion globale",
        description: "Déconnecter l'utilisateur de tous ses appareils en révoquant tous ses tokens d'accès"
    )]
    #[Header("Authorization", "Bearer {token}", "Token d'authentification requis")]
    #[Response([
        'success' => true,
        'message' => 'Déconnexion de tous les appareils réussie'
    ], 200, "Déconnexion globale réussie")]
    #[Response([
        'message' => 'Unauthenticated.'
    ], 401, "Token manquant ou invalide")]
    #[Response([
        'success' => false,
        'message' => 'Erreur lors de la déconnexion globale',
        'error' => 'Message d\'erreur détaillé'
    ], 500, "Erreur serveur")]
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
     * 
     * Envoie un email contenant un lien de réinitialisation de mot de passe.
     * Le token généré expire après 24 heures.
     */
    #[Endpoint(
        title: "Mot de passe oublié",
        description: "Envoyer un lien de réinitialisation de mot de passe par email. Le lien expire après 24 heures."
    )]
    #[BodyParam("email", "string", "Adresse email du compte à réinitialiser", required: true, example: "jean.dupont@example.com")]
    #[Response([
        'success' => true,
        'message' => 'Lien de réinitialisation envoyé par email'
    ], 200, "Email envoyé avec succès")]
    #[Response([
        'success' => false,
        'message' => 'Aucun compte actif associé à cet email.'
    ], 404, "Email non trouvé ou compte inactif")]
    #[Response([
        'success' => false,
        'message' => 'Erreurs de validation',
        'errors' => [
            'email' => ['L\'email est obligatoire.', 'Aucun compte associé à cet email.']
        ]
    ], 422, "Email invalide")]
    #[Response([
        'success' => false,
        'message' => 'Erreur lors de l\'envoi du lien',
        'error' => 'Message d\'erreur détaillé'
    ], 500, "Erreur serveur")]
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
