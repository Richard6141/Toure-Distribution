<?php

use Knuckles\Scribe\Extracting\Strategies;
use Knuckles\Scribe\Config\Defaults;
use Knuckles\Scribe\Config\AuthIn;
use function Knuckles\Scribe\Config\{removeStrategies, configureStrategy};

// Only the most common configs are shown. See the https://scribe.knuckles.wtf/laravel/reference/config for all.

return [
    // The HTML <title> for the generated documentation.
    'title' => 'Documentation API - Plateforme de Gestion d\'Entreprise Touré Distribution',

    // A short description of your API. Will be included in the docs webpage, Postman collection and OpenAPI spec.
    'description' => 'API complète pour la gestion des activités d\'une grande entreprise de distribution de produits.',

    // Text to place in the "Introduction" section, right after the `description`. Markdown and HTML are supported.
    'intro_text' => <<<INTRO
        Cette documentation fournit toutes les informations nécessaires pour travailler avec notre API de gestion d'entreprise.

        <aside>
        Au fur et à mesure que vous faites défiler la page, vous verrez des exemples de code pour utiliser l'API dans différents langages de programmation dans la zone sombre à droite (ou dans le contenu sur mobile). Vous pouvez changer de langage à l'aide des onglets en haut à droite (ou dans le menu de navigation en haut à gauche sur mobile).
        </aside>

        ## Authentification
        Notre API utilise l'authentification par token Bearer. Vous devez d'abord vous inscrire ou vous connecter pour obtenir un token d'accès.

        ## Codes de réponse
        - `200` - Succès
        - `201` - Créé avec succès
        - `400` - Erreur de requête
        - `401` - Non autorisé
        - `422` - Erreur de validation
        - `500` - Erreur serveur
    INTRO,

    // The base URL displayed in the docs.
    'base_url' => config("app.url"),

    // Routes to include in the docs
    'routes' => [
        [
            'match' => [
                // Match only routes whose paths match this pattern
                'prefixes' => ['api/*'],
                'domains' => ['*'],
                // Supprimer la version car elle n'existe probablement pas encore
            ],

            // Include these routes even if they did not match the rules above.
            'include' => [
                // 'users.index', 'POST /new', '/auth/*'
            ],

            // Exclude these routes even if they matched the rules above.
            'exclude' => [
                'GET /health',
                'admin.*',
                'telescope/*',
                'horizon/*'
            ],
        ],
    ],

    // The type of documentation output to generate.
    'type' => 'laravel',

    // See https://scribe.knuckles.wtf/laravel/reference/config#theme for supported options
    'theme' => 'default',

    'static' => [
        // HTML documentation, assets and Postman collection will be generated to this folder.
        'output_path' => 'public/docs',
    ],

    'laravel' => [
        // Whether to automatically create a docs route for you to view your generated docs.
        'add_routes' => true,

        // URL path to use for the docs endpoint
        'docs_url' => '/docs',

        // Directory within `public` in which to store CSS and JS assets.
        'assets_directory' => null,

        // Middleware to attach to the docs endpoint
        'middleware' => [],
    ],

    'external' => [
        'html_attributes' => []
    ],

    'try_it_out' => [
        // Add a Try It Out button to your endpoints
        'enabled' => true,

        // The base URL to use in the API tester.
        'base_url' => null,

        // [Laravel Sanctum] Fetch a CSRF token before each request
        'use_csrf' => false,

        // The URL to fetch the CSRF token from
        'csrf_url' => '/sanctum/csrf-cookie',
    ],

    // Configuration de l'authentification corrigée
    'auth' => [
        // Set this to true if ANY endpoints in your API use authentication.
        'enabled' => true, // Changé à true car vous avez de l'authentification

        // Set this to true if your API should be authenticated by default.
        'default' => false, // Gardé false pour permettre les endpoints publics (register, etc.)

        // Where is the auth value meant to be sent in a request?
        'in' => 'bearer', // Changé pour utiliser Bearer token

        // The name of the auth parameter or header.
        'name' => 'Authorization', // Changé pour le header Authorization

        // The value of the parameter to be used by Scribe to authenticate response calls.
        'use_value' => env('SCRIBE_AUTH_KEY'),

        // Placeholder your users will see for the auth parameter in the example requests.
        'placeholder' => 'Bearer {YOUR_AUTH_TOKEN}', // Changé pour montrer le format Bearer

        // Any extra authentication-related info for your users.
        'extra_info' => 'Vous pouvez récupérer votre token en vous inscrivant via <code>POST /api/auth/register</code> ou en vous connectant via <code>POST /api/auth/login</code>. Utilisez le token dans le header Authorization avec le préfixe "Bearer ".',
    ],

    // Example requests for each endpoint will be shown in each of these languages.
    'example_languages' => [
        'bash',
        'javascript',
        'php', // Ajouté PHP pour plus d'exemples
    ],

    // Generate a Postman collection
    'postman' => [
        'enabled' => true,

        'overrides' => [
            'info.version' => '1.0.0', // Ajouté une version
            'info.description' => 'Collection Postman pour l\'API de gestion d\'entreprise Touré Distribution',
        ],
    ],

    // Generate an OpenAPI spec
    'openapi' => [
        'enabled' => true,

        'overrides' => [
            'info.version' => '1.0.0', // Ajouté une version
            'info.contact' => [
                'name' => 'Support API',
                'email' => 'support@touredistribution.com',
            ],
        ],

        // Additional generators to use when generating the OpenAPI spec.
        'generators' => [],
    ],

    'groups' => [
        // Endpoints which don't have a @group will be placed in this default group.
        'default' => 'Endpoints',

        // Ordre personnalisé des groupes
        'order' => [
            'Authentification',
            'Clients Management',
            'Payment Methods Management',
            'Invoices Management',
            'Payments Management',
            'Stock Movement Types',
            'Stock Movements',
            'Stock Movement Details',
            'Utilisateurs',
            'Produits',
            'Commandes',
            'Rapports',
            'Endpoints', // Default group à la fin
        ],
    ],

    // Custom logo path
    'logo' => false,

    // Customize the "Last updated" value
    'last_updated' => 'Dernière mise à jour: {date:j F Y}', // En français

    'examples' => [
        // Set this to any number to generate the same example values
        'faker_seed' => 1234,

        // With API resources and transformers
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'],
    ],

    // The strategies Scribe will use to extract information about your routes
    'strategies' => [
        'metadata' => [
            ...Defaults::METADATA_STRATEGIES,
        ],
        'headers' => [
            ...Defaults::HEADERS_STRATEGIES,
            Strategies\StaticData::withSettings(data: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]),
        ],
        'urlParameters' => [
            ...Defaults::URL_PARAMETERS_STRATEGIES,
        ],
        'queryParameters' => [
            ...Defaults::QUERY_PARAMETERS_STRATEGIES,
        ],
        'bodyParameters' => [
            ...Defaults::BODY_PARAMETERS_STRATEGIES,
        ],
        'responses' => configureStrategy(
            Defaults::RESPONSES_STRATEGIES,
            Strategies\Responses\ResponseCalls::withSettings(
                only: ['GET *'], // Seulement les GET pour éviter de modifier des données
                config: [
                    'app.debug' => false, // Désactiver le debug pour des réponses propres
                ]
            )
        ),
        'responseFields' => [
            ...Defaults::RESPONSE_FIELDS_STRATEGIES,
        ]
    ],

    // Database connections to transact
    'database_connections_to_transact' => [config('database.default')],

    'fractal' => [
        // If you are using a custom serializer with league/fractal
        'serializer' => null,
    ],
];
