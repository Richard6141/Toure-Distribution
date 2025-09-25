<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Documentation API - Plateforme de Gestion d'Entreprise Touré Distribution</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
                    body .content .php-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.3.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.3.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;,&quot;php&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authentification" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authentification">
                    <a href="#authentification">Authentification</a>
                </li>
                                    <ul id="tocify-subheader-authentification" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-register">
                                <a href="#authentification-POSTapi-auth-register">Inscription d'un utilisateur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-login">
                                <a href="#authentification-POSTapi-auth-login">Connexion utilisateur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-forgot-password">
                                <a href="#authentification-POSTapi-auth-forgot-password">Mot de passe oublié</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-reset-password">
                                <a href="#authentification-POSTapi-auth-reset-password">Réinitialiser le mot de passe</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-GETapi-auth-check-username--username-">
                                <a href="#authentification-GETapi-auth-check-username--username-">Vérifier disponibilité username</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-GETapi-auth-check-email--email-">
                                <a href="#authentification-GETapi-auth-check-email--email-">Vérifier disponibilité email</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-GETapi-auth-profile">
                                <a href="#authentification-GETapi-auth-profile">Profil utilisateur connecté</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-logout">
                                <a href="#authentification-POSTapi-auth-logout">Déconnexion utilisateur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-logout-all">
                                <a href="#authentification-POSTapi-auth-logout-all">Déconnexion globale</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentification-POSTapi-auth-change-password">
                                <a href="#authentification-POSTapi-auth-change-password">Changer le mot de passe</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET api/user</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-client-types-management" class="tocify-header">
                <li class="tocify-item level-1" data-unique="client-types-management">
                    <a href="#client-types-management">Client Types Management</a>
                </li>
                                    <ul id="tocify-subheader-client-types-management" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="client-types-management-GETapi-client-types">
                                <a href="#client-types-management-GETapi-client-types">Liste tous les types de clients</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-POSTapi-client-types">
                                <a href="#client-types-management-POSTapi-client-types">Créer un nouveau type de client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-GETapi-client-types--client_type_id-">
                                <a href="#client-types-management-GETapi-client-types--client_type_id-">Afficher un type de client spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-PUTapi-client-types--client_type_id-">
                                <a href="#client-types-management-PUTapi-client-types--client_type_id-">Mettre à jour un type de client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-PATCHapi-client-types--client_type_id-">
                                <a href="#client-types-management-PATCHapi-client-types--client_type_id-">Mettre à jour un type de client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-DELETEapi-client-types--client_type_id-">
                                <a href="#client-types-management-DELETEapi-client-types--client_type_id-">Supprimer un type de client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-GETapi-client-types-trashed-list">
                                <a href="#client-types-management-GETapi-client-types-trashed-list">Lister les types de clients supprimés</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="client-types-management-POSTapi-client-types--client_type_id--restore">
                                <a href="#client-types-management-POSTapi-client-types--client_type_id--restore">Restaurer un type de client supprimé (soft delete)</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-clients-management" class="tocify-header">
                <li class="tocify-item level-1" data-unique="clients-management">
                    <a href="#clients-management">Clients Management</a>
                </li>
                                    <ul id="tocify-subheader-clients-management" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="clients-management-GETapi-clients">
                                <a href="#clients-management-GETapi-clients">Liste tous les clients</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-POSTapi-clients">
                                <a href="#clients-management-POSTapi-clients">Créer un nouveau client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-GETapi-clients--client_id-">
                                <a href="#clients-management-GETapi-clients--client_id-">Afficher un client spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-PUTapi-clients--client_id-">
                                <a href="#clients-management-PUTapi-clients--client_id-">Mettre à jour un client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-PATCHapi-clients--client_id-">
                                <a href="#clients-management-PATCHapi-clients--client_id-">Mettre à jour un client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-DELETEapi-clients--client_id-">
                                <a href="#clients-management-DELETEapi-clients--client_id-">Supprimer un client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-GETapi-clients-trashed-list">
                                <a href="#clients-management-GETapi-clients-trashed-list">Lister les clients supprimés</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-POSTapi-clients--client_id--restore">
                                <a href="#clients-management-POSTapi-clients--client_id--restore">Restaurer un client supprimé</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-PATCHapi-clients--client_id--toggle-status">
                                <a href="#clients-management-PATCHapi-clients--client_id--toggle-status">Activer/Désactiver un client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-PATCHapi-clients--client_id--update-balance">
                                <a href="#clients-management-PATCHapi-clients--client_id--update-balance">Mettre à jour le solde d'un client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-POSTapi-clients-search">
                                <a href="#clients-management-POSTapi-clients-search">Rechercher des clients</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-GETapi-clients-statistics-overview">
                                <a href="#clients-management-GETapi-clients-statistics-overview">Statistiques des clients</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-entrepots" class="tocify-header">
                <li class="tocify-item level-1" data-unique="entrepots">
                    <a href="#entrepots">Entrepôts</a>
                </li>
                                    <ul id="tocify-subheader-entrepots" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="entrepots-GETapi-entrepots">
                                <a href="#entrepots-GETapi-entrepots">Liste des entrepôts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-POSTapi-entrepots">
                                <a href="#entrepots-POSTapi-entrepots">Créer un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-GETapi-entrepots--id-">
                                <a href="#entrepots-GETapi-entrepots--id-">Afficher un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-PUTapi-entrepots--id-">
                                <a href="#entrepots-PUTapi-entrepots--id-">Mettre à jour un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-PATCHapi-entrepots--id-">
                                <a href="#entrepots-PATCHapi-entrepots--id-">Mettre à jour un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-DELETEapi-entrepots--id-">
                                <a href="#entrepots-DELETEapi-entrepots--id-">Supprimer un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-PATCHapi-entrepots--id--assign-user">
                                <a href="#entrepots-PATCHapi-entrepots--id--assign-user">Attribuer un responsable à un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-PATCHapi-entrepots--id--unassign-user">
                                <a href="#entrepots-PATCHapi-entrepots--id--unassign-user">Désattribuer le responsable d'un entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="entrepots-PATCHapi-entrepots--id--change-user">
                                <a href="#entrepots-PATCHapi-entrepots--id--change-user">Changer le responsable d'un entrepôt</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-fournisseurs" class="tocify-header">
                <li class="tocify-item level-1" data-unique="fournisseurs">
                    <a href="#fournisseurs">Fournisseurs</a>
                </li>
                                    <ul id="tocify-subheader-fournisseurs" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="fournisseurs-GETapi-fournisseurs">
                                <a href="#fournisseurs-GETapi-fournisseurs">Liste des fournisseurs</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-POSTapi-fournisseurs">
                                <a href="#fournisseurs-POSTapi-fournisseurs">Créer un fournisseur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-GETapi-fournisseurs--id-">
                                <a href="#fournisseurs-GETapi-fournisseurs--id-">Afficher un fournisseur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-PUTapi-fournisseurs--id-">
                                <a href="#fournisseurs-PUTapi-fournisseurs--id-">Mettre à jour un fournisseur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-PATCHapi-fournisseurs--id-">
                                <a href="#fournisseurs-PATCHapi-fournisseurs--id-">Mettre à jour un fournisseur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-DELETEapi-fournisseurs--id-">
                                <a href="#fournisseurs-DELETEapi-fournisseurs--id-">Supprimer un fournisseur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-PATCHapi-fournisseurs--id--restore">
                                <a href="#fournisseurs-PATCHapi-fournisseurs--id--restore">Restaurer un fournisseur</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="fournisseurs-DELETEapi-fournisseurs--id--force">
                                <a href="#fournisseurs-DELETEapi-fournisseurs--id--force">Suppression définitive</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Dernière mise à jour: 25 September 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>API complète pour la gestion des activités d'une grande entreprise de distribution de produits.</p>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>Cette documentation fournit toutes les informations nécessaires pour travailler avec notre API de gestion d'entreprise.

&lt;aside&gt;
Au fur et à mesure que vous faites défiler la page, vous verrez des exemples de code pour utiliser l'API dans différents langages de programmation dans la zone sombre à droite (ou dans le contenu sur mobile). Vous pouvez changer de langage à l'aide des onglets en haut à droite (ou dans le menu de navigation en haut à gauche sur mobile).
&lt;/aside&gt;

## Authentification
Notre API utilise l'authentification par token Bearer. Vous devez d'abord vous inscrire ou vous connecter pour obtenir un token d'accès.

## Codes de réponse
- `200` - Succès
- `201` - Créé avec succès
- `400` - Erreur de requête
- `401` - Non autorisé
- `422` - Erreur de validation
- `500` - Erreur serveur</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer Bearer {YOUR_AUTH_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>Vous pouvez récupérer votre token en vous inscrivant via <code>POST /api/auth/register</code> ou en vous connectant via <code>POST /api/auth/login</code>. Utilisez le token dans le header Authorization avec le préfixe &quot;Bearer &quot;.</p>

        <h1 id="authentification">Authentification</h1>

    <p>Gestion des utilisateurs et authentification</p>

                                <h2 id="authentification-POSTapi-auth-register">Inscription d&#039;un utilisateur</h2>

<p>
</p>

<p>Créer un nouveau compte utilisateur avec validation complète des données et génération automatique d'un token d'authentification</p>

<span id="example-requests-POSTapi-auth-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"firstname\": \"Jean\",
    \"lastname\": \"DUPONT\",
    \"username\": \"jean.dupont\",
    \"email\": \"jean.dupont@example.com\",
    \"phonenumber\": \"+33612345678\",
    \"poste\": \"Développeur Full-Stack\",
    \"password\": \"SecurePass123!\",
    \"password_confirmation\": \"SecurePass123!\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "firstname": "Jean",
    "lastname": "DUPONT",
    "username": "jean.dupont",
    "email": "jean.dupont@example.com",
    "phonenumber": "+33612345678",
    "poste": "Développeur Full-Stack",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/register';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'firstname' =&gt; 'Jean',
            'lastname' =&gt; 'DUPONT',
            'username' =&gt; 'jean.dupont',
            'email' =&gt; 'jean.dupont@example.com',
            'phonenumber' =&gt; '+33612345678',
            'poste' =&gt; 'Développeur Full-Stack',
            'password' =&gt; 'SecurePass123!',
            'password_confirmation' =&gt; 'SecurePass123!',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-register">
            <blockquote>
            <p>Example response (201, Inscription réussie):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;code&quot;: 200,
    &quot;message&quot;: &quot;Inscription r&eacute;ussie&quot;,
    &quot;data&quot;: {
        &quot;user&quot;: {
            &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;firstname&quot;: &quot;Jean&quot;,
            &quot;lastname&quot;: &quot;DUPONT&quot;,
            &quot;username&quot;: &quot;jean.dupont&quot;,
            &quot;email&quot;: &quot;jean.dupont@example.com&quot;,
            &quot;is_active&quot;: true
        },
        &quot;access_token&quot;: &quot;1|abcdef123456789...&quot;,
        &quot;token_type&quot;: &quot;Bearer&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Erreurs de validation):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreurs de validation&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;Cet email est d&eacute;j&agrave; utilis&eacute;.&quot;
        ],
        &quot;username&quot;: [
            &quot;Ce nom d&#039;utilisateur est d&eacute;j&agrave; utilis&eacute;.&quot;
        ],
        &quot;password&quot;: [
            &quot;Le mot de passe doit contenir au moins 8 caract&egrave;res.&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Erreur serveur):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur lors de l&#039;inscription&quot;,
    &quot;error&quot;: &quot;Message d&#039;erreur d&eacute;taill&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-register" data-method="POST"
      data-path="api/auth/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-register"
                    onclick="tryItOut('POSTapi-auth-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-register"
                    onclick="cancelTryOut('POSTapi-auth-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>firstname</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="firstname"                data-endpoint="POSTapi-auth-register"
               value="Jean"
               data-component="body">
    <br>
<p>Prénom de l'utilisateur (lettres et espaces uniquement) Example: <code>Jean</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lastname</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lastname"                data-endpoint="POSTapi-auth-register"
               value="DUPONT"
               data-component="body">
    <br>
<p>Nom de famille (lettres et espaces uniquement) Example: <code>DUPONT</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-auth-register"
               value="jean.dupont"
               data-component="body">
    <br>
<p>Nom d'utilisateur unique (lettres, chiffres, points, tirets et underscores) Example: <code>jean.dupont</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-register"
               value="jean.dupont@example.com"
               data-component="body">
    <br>
<p>Adresse email valide et unique Example: <code>jean.dupont@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phonenumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phonenumber"                data-endpoint="POSTapi-auth-register"
               value="+33612345678"
               data-component="body">
    <br>
<p>Numéro de téléphone avec indicatif international (optionnel) Example: <code>+33612345678</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>poste</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="poste"                data-endpoint="POSTapi-auth-register"
               value="Développeur Full-Stack"
               data-component="body">
    <br>
<p>Poste/fonction de l'utilisateur (optionnel) Example: <code>Développeur Full-Stack</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-register"
               value="SecurePass123!"
               data-component="body">
    <br>
<p>Mot de passe (min. 8 caractères, majuscules, minuscules, chiffres, symboles) Example: <code>SecurePass123!</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-auth-register"
               value="SecurePass123!"
               data-component="body">
    <br>
<p>Confirmation du mot de passe (doit être identique) Example: <code>SecurePass123!</code></p>
        </div>
        </form>

                    <h2 id="authentification-POSTapi-auth-login">Connexion utilisateur</h2>

<p>
</p>

<p>Authentifier un utilisateur avec email/username et mot de passe. Le compte est verrouillé 15 minutes après 5 tentatives échouées.</p>

<span id="example-requests-POSTapi-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"login\": \"jean.dupont@example.com\",
    \"password\": \"SecurePass123!\",
    \"remember\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "login": "jean.dupont@example.com",
    "password": "SecurePass123!",
    "remember": false
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/login';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'login' =&gt; 'jean.dupont@example.com',
            'password' =&gt; 'SecurePass123!',
            'remember' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-login">
            <blockquote>
            <p>Example response (200, Connexion réussie):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Connexion r&eacute;ussie&quot;,
    &quot;data&quot;: {
        &quot;user&quot;: {
            &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;firstname&quot;: &quot;Jean&quot;,
            &quot;lastname&quot;: &quot;DUPONT&quot;,
            &quot;username&quot;: &quot;jean.dupont&quot;,
            &quot;email&quot;: &quot;jean.dupont@example.com&quot;,
            &quot;is_active&quot;: true,
            &quot;last_login_at&quot;: &quot;2024-01-15 14:30:00&quot;
        },
        &quot;access_token&quot;: &quot;1|abcdef123456789...&quot;,
        &quot;token_type&quot;: &quot;Bearer&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Identifiants invalides):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Identifiants incorrects.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Compte désactivé):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Votre compte a &eacute;t&eacute; d&eacute;sactiv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Données invalides):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreurs de validation&quot;,
    &quot;errors&quot;: {
        &quot;login&quot;: [
            &quot;L&#039;email ou nom d&#039;utilisateur est obligatoire.&quot;
        ],
        &quot;password&quot;: [
            &quot;Le mot de passe est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (423, Compte verrouillé):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Votre compte est temporairement verrouill&eacute;. R&eacute;essayez plus tard.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-login" data-method="POST"
      data-path="api/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-login"
                    onclick="tryItOut('POSTapi-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-login"
                    onclick="cancelTryOut('POSTapi-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>login</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="login"                data-endpoint="POSTapi-auth-login"
               value="jean.dupont@example.com"
               data-component="body">
    <br>
<p>Email ou nom d'utilisateur Example: <code>jean.dupont@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-login"
               value="SecurePass123!"
               data-component="body">
    <br>
<p>Mot de passe Example: <code>SecurePass123!</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>remember</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-auth-login" style="display: none">
            <input type="radio" name="remember"
                   value="true"
                   data-endpoint="POSTapi-auth-login"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-auth-login" style="display: none">
            <input type="radio" name="remember"
                   value="false"
                   data-endpoint="POSTapi-auth-login"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Se souvenir de moi (token longue durée) Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="authentification-POSTapi-auth-forgot-password">Mot de passe oublié</h2>

<p>
</p>

<p>Envoyer un lien de réinitialisation de mot de passe par email. Le lien expire après 24 heures.</p>

<span id="example-requests-POSTapi-auth-forgot-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/forgot-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"jean.dupont@example.com\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/forgot-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "jean.dupont@example.com"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/forgot-password';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'jean.dupont@example.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-forgot-password">
            <blockquote>
            <p>Example response (200, Email envoyé avec succès):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Lien de r&eacute;initialisation envoy&eacute; par email&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Email non trouvé ou compte inactif):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Aucun compte actif associ&eacute; &agrave; cet email.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Email invalide):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreurs de validation&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;L&#039;email est obligatoire.&quot;,
            &quot;Aucun compte associ&eacute; &agrave; cet email.&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Erreur serveur):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur lors de l&#039;envoi du lien&quot;,
    &quot;error&quot;: &quot;Message d&#039;erreur d&eacute;taill&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-forgot-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-forgot-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-forgot-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-forgot-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-forgot-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-forgot-password" data-method="POST"
      data-path="api/auth/forgot-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-forgot-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-forgot-password"
                    onclick="tryItOut('POSTapi-auth-forgot-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-forgot-password"
                    onclick="cancelTryOut('POSTapi-auth-forgot-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-forgot-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/forgot-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-forgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-forgot-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-forgot-password"
               value="jean.dupont@example.com"
               data-component="body">
    <br>
<p>Adresse email du compte à réinitialiser Example: <code>jean.dupont@example.com</code></p>
        </div>
        </form>

                    <h2 id="authentification-POSTapi-auth-reset-password">Réinitialiser le mot de passe</h2>

<p>
</p>

<p>Réinitialiser le mot de passe avec le token reçu par email</p>

<span id="example-requests-POSTapi-auth-reset-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/reset-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"john@example.com\",
    \"token\": \"abc123...\",
    \"password\": \"NewSecurePass123!\",
    \"password_confirmation\": \"NewSecurePass123!\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/reset-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "john@example.com",
    "token": "abc123...",
    "password": "NewSecurePass123!",
    "password_confirmation": "NewSecurePass123!"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/reset-password';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'john@example.com',
            'token' =&gt; 'abc123...',
            'password' =&gt; 'NewSecurePass123!',
            'password_confirmation' =&gt; 'NewSecurePass123!',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-reset-password">
</span>
<span id="execution-results-POSTapi-auth-reset-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-reset-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-reset-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-reset-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-reset-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-reset-password" data-method="POST"
      data-path="api/auth/reset-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-reset-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-reset-password"
                    onclick="tryItOut('POSTapi-auth-reset-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-reset-password"
                    onclick="cancelTryOut('POSTapi-auth-reset-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-reset-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/reset-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-reset-password"
               value="john@example.com"
               data-component="body">
    <br>
<p>Adresse email Example: <code>john@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="POSTapi-auth-reset-password"
               value="abc123..."
               data-component="body">
    <br>
<p>Token de réinitialisation Example: <code>abc123...</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-reset-password"
               value="NewSecurePass123!"
               data-component="body">
    <br>
<p>Nouveau mot de passe Example: <code>NewSecurePass123!</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-auth-reset-password"
               value="NewSecurePass123!"
               data-component="body">
    <br>
<p>Confirmation du mot de passe Example: <code>NewSecurePass123!</code></p>
        </div>
        </form>

                    <h2 id="authentification-GETapi-auth-check-username--username-">Vérifier disponibilité username</h2>

<p>
</p>

<p>Vérifier si un nom d'utilisateur est disponible pour l'inscription</p>

<span id="example-requests-GETapi-auth-check-username--username-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/auth/check-username/jean.dupont" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/check-username/jean.dupont"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/check-username/jean.dupont';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-check-username--username-">
            <blockquote>
            <p>Example response (200, Username disponible):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;available&quot;: true,
    &quot;message&quot;: &quot;Nom d&#039;utilisateur disponible&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (200, Username indisponible):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;available&quot;: false,
    &quot;message&quot;: &quot;Nom d&#039;utilisateur d&eacute;j&agrave; pris&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-check-username--username-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-check-username--username-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-check-username--username-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-check-username--username-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-check-username--username-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-check-username--username-" data-method="GET"
      data-path="api/auth/check-username/{username}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-check-username--username-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-check-username--username-"
                    onclick="tryItOut('GETapi-auth-check-username--username-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-check-username--username-"
                    onclick="cancelTryOut('GETapi-auth-check-username--username-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-check-username--username-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/check-username/{username}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-check-username--username-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-check-username--username-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="GETapi-auth-check-username--username-"
               value="jean.dupont"
               data-component="url">
    <br>
<p>Nom d'utilisateur à vérifier Example: <code>jean.dupont</code></p>
            </div>
                    </form>

                    <h2 id="authentification-GETapi-auth-check-email--email-">Vérifier disponibilité email</h2>

<p>
</p>

<p>Vérifier si un email est disponible pour l'inscription</p>

<span id="example-requests-GETapi-auth-check-email--email-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/auth/check-email/jean.dupont@example.com" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/check-email/jean.dupont@example.com"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/check-email/jean.dupont@example.com';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-check-email--email-">
            <blockquote>
            <p>Example response (200, Email disponible):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;available&quot;: true,
    &quot;message&quot;: &quot;Email disponible&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (200, Email indisponible):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;available&quot;: false,
    &quot;message&quot;: &quot;Email d&eacute;j&agrave; utilis&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-check-email--email-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-check-email--email-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-check-email--email-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-check-email--email-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-check-email--email-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-check-email--email-" data-method="GET"
      data-path="api/auth/check-email/{email}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-check-email--email-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-check-email--email-"
                    onclick="tryItOut('GETapi-auth-check-email--email-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-check-email--email-"
                    onclick="cancelTryOut('GETapi-auth-check-email--email-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-check-email--email-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/check-email/{email}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-check-email--email-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-check-email--email-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="GETapi-auth-check-email--email-"
               value="jean.dupont@example.com"
               data-component="url">
    <br>
<p>Adresse email à vérifier Example: <code>jean.dupont@example.com</code></p>
            </div>
                    </form>

                    <h2 id="authentification-GETapi-auth-profile">Profil utilisateur connecté</h2>

<p>
</p>

<p>Récupérer les informations complètes de l'utilisateur connecté</p>

<span id="example-requests-GETapi-auth-profile">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/auth/profile" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/profile"
);

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/profile';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-profile">
            <blockquote>
            <p>Example response (200, Profil récupéré avec succès):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;firstname&quot;: &quot;Jean&quot;,
        &quot;lastname&quot;: &quot;DUPONT&quot;,
        &quot;username&quot;: &quot;jean.dupont&quot;,
        &quot;email&quot;: &quot;jean.dupont@example.com&quot;,
        &quot;phonenumber&quot;: &quot;+33612345678&quot;,
        &quot;poste&quot;: &quot;D&eacute;veloppeur Full-Stack&quot;,
        &quot;is_active&quot;: true,
        &quot;email_verified&quot;: false,
        &quot;last_login_at&quot;: &quot;2024-01-15 14:30:00&quot;,
        &quot;created_at&quot;: &quot;2024-01-10 09:15:00&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Token manquant ou invalide):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-profile" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-profile"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-profile"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-profile" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-profile">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-profile" data-method="GET"
      data-path="api/auth/profile"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-profile', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-profile"
                    onclick="tryItOut('GETapi-auth-profile');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-profile"
                    onclick="cancelTryOut('GETapi-auth-profile');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-profile"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/profile</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-auth-profile"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-profile"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-profile"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="authentification-POSTapi-auth-logout">Déconnexion utilisateur</h2>

<p>
</p>

<p>Déconnecter l'utilisateur en révoquant son token d'accès actuel</p>

<span id="example-requests-POSTapi-auth-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/logout" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/logout"
);

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/logout';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-logout">
            <blockquote>
            <p>Example response (200, Déconnexion réussie):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;D&eacute;connexion r&eacute;ussie&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Token manquant ou invalide):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Erreur serveur):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur lors de la d&eacute;connexion&quot;,
    &quot;error&quot;: &quot;Message d&#039;erreur d&eacute;taill&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-logout" data-method="POST"
      data-path="api/auth/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-logout"
                    onclick="tryItOut('POSTapi-auth-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-logout"
                    onclick="cancelTryOut('POSTapi-auth-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="POSTapi-auth-logout"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="authentification-POSTapi-auth-logout-all">Déconnexion globale</h2>

<p>
</p>

<p>Déconnecter l'utilisateur de tous ses appareils en révoquant tous ses tokens d'accès</p>

<span id="example-requests-POSTapi-auth-logout-all">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/logout-all" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/logout-all"
);

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/logout-all';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-logout-all">
            <blockquote>
            <p>Example response (200, Déconnexion globale réussie):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;D&eacute;connexion de tous les appareils r&eacute;ussie&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Token manquant ou invalide):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Erreur serveur):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur lors de la d&eacute;connexion globale&quot;,
    &quot;error&quot;: &quot;Message d&#039;erreur d&eacute;taill&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-logout-all" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-logout-all"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-logout-all"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-logout-all" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-logout-all">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-logout-all" data-method="POST"
      data-path="api/auth/logout-all"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-logout-all', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-logout-all"
                    onclick="tryItOut('POSTapi-auth-logout-all');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-logout-all"
                    onclick="cancelTryOut('POSTapi-auth-logout-all');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-logout-all"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/logout-all</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="POSTapi-auth-logout-all"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-logout-all"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-logout-all"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="authentification-POSTapi-auth-change-password">Changer le mot de passe</h2>

<p>
</p>

<p>Changer le mot de passe de l'utilisateur connecté. Révoque tous les autres tokens d'authentification.</p>

<span id="example-requests-POSTapi-auth-change-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/change-password" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"current_password\": \"OldPass123!\",
    \"password\": \"NewSecurePass456#\",
    \"password_confirmation\": \"NewSecurePass456#\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/change-password"
);

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_password": "OldPass123!",
    "password": "NewSecurePass456#",
    "password_confirmation": "NewSecurePass456#"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/auth/change-password';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {token}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'current_password' =&gt; 'OldPass123!',
            'password' =&gt; 'NewSecurePass456#',
            'password_confirmation' =&gt; 'NewSecurePass456#',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-change-password">
            <blockquote>
            <p>Example response (200, Changement réussi):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Mot de passe modifi&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (400, Mot de passe actuel invalide):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Le mot de passe actuel est incorrect.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, Token manquant ou invalide):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Erreurs de validation):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreurs de validation&quot;,
    &quot;errors&quot;: {
        &quot;password&quot;: [
            &quot;Le nouveau mot de passe doit &ecirc;tre diff&eacute;rent de l&#039;ancien.&quot;
        ],
        &quot;password_confirmation&quot;: [
            &quot;La confirmation du mot de passe ne correspond pas.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-change-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-change-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-change-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-change-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-change-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-change-password" data-method="POST"
      data-path="api/auth/change-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-change-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-change-password"
                    onclick="tryItOut('POSTapi-auth-change-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-change-password"
                    onclick="cancelTryOut('POSTapi-auth-change-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-change-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/change-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="POSTapi-auth-change-password"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-change-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-change-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="current_password"                data-endpoint="POSTapi-auth-change-password"
               value="OldPass123!"
               data-component="body">
    <br>
<p>Mot de passe actuel Example: <code>OldPass123!</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-change-password"
               value="NewSecurePass456#"
               data-component="body">
    <br>
<p>Nouveau mot de passe (min. 8 caractères, majuscules, minuscules, chiffres, symboles) Example: <code>NewSecurePass456#</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-auth-change-password"
               value="NewSecurePass456#"
               data-component="body">
    <br>
<p>Confirmation du nouveau mot de passe Example: <code>NewSecurePass456#</code></p>
        </div>
        </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/user';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="client-types-management">Client Types Management</h1>

    <p>APIs pour gérer les types de clients</p>

                                <h2 id="client-types-management-GETapi-client-types">Liste tous les types de clients</h2>

<p>
</p>

<p>Récupère la liste de tous les types de clients avec pagination optionnelle.
Vous pouvez filtrer par label en utilisant le paramètre de recherche.</p>

<span id="example-requests-GETapi-client-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/client-types?page=1&amp;per_page=15&amp;search=Premium&amp;with_clients=" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"page\": 16,
    \"per_page\": 22,
    \"search\": \"g\",
    \"with_clients\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types"
);

const params = {
    "page": "1",
    "per_page": "15",
    "search": "Premium",
    "with_clients": "0",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "page": 16,
    "per_page": 22,
    "search": "g",
    "with_clients": false
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'search' =&gt; 'Premium',
            'with_clients' =&gt; '0',
        ],
        'json' =&gt; [
            'page' =&gt; 16,
            'per_page' =&gt; 22,
            'search' =&gt; 'g',
            'with_clients' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-client-types">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;label&quot;: &quot;Premium&quot;,
            &quot;description&quot;: &quot;Client premium avec avantages sp&eacute;ciaux&quot;,
            &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://localhost/api/client-types?page=1&quot;,
        &quot;last&quot;: &quot;http://localhost/api/client-types?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 1,
        &quot;total&quot;: 1
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Param&egrave;tres de requ&ecirc;te invalides&quot;,
    &quot;errors&quot;: {
        &quot;per_page&quot;: [
            &quot;Le nombre d&#039;&eacute;l&eacute;ments par page ne peut pas d&eacute;passer 100&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-client-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-client-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-client-types"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-client-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-client-types">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-client-types" data-method="GET"
      data-path="api/client-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-client-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-client-types"
                    onclick="tryItOut('GETapi-client-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-client-types"
                    onclick="cancelTryOut('GETapi-client-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-client-types"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/client-types</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-client-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-client-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-client-types"
               value="1"
               data-component="query">
    <br>
<p>Page à récupérer (pagination). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-client-types"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page (max: 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-client-types"
               value="Premium"
               data-component="query">
    <br>
<p>Rechercher par label. Example: <code>Premium</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_clients</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-client-types" style="display: none">
            <input type="radio" name="with_clients"
                   value="1"
                   data-endpoint="GETapi-client-types"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-client-types" style="display: none">
            <input type="radio" name="with_clients"
                   value="0"
                   data-endpoint="GETapi-client-types"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les clients associés. Example: <code>false</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-client-types"
               value="16"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-client-types"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-client-types"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>with_clients</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-client-types" style="display: none">
            <input type="radio" name="with_clients"
                   value="true"
                   data-endpoint="GETapi-client-types"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-client-types" style="display: none">
            <input type="radio" name="with_clients"
                   value="false"
                   data-endpoint="GETapi-client-types"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="client-types-management-POSTapi-client-types">Créer un nouveau type de client</h2>

<p>
</p>

<p>Crée un nouveau type de client avec les informations fournies.
L'UUID est généré automatiquement.</p>

<span id="example-requests-POSTapi-client-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/client-types" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"VIP\",
    \"description\": \"Client VIP avec services exclusifs\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "VIP",
    "description": "Client VIP avec services exclusifs"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'VIP',
            'description' =&gt; 'Client VIP avec services exclusifs',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-client-types">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;label&quot;: &quot;VIP&quot;,
        &quot;description&quot;: &quot;Client VIP avec services exclusifs&quot;,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;
    },
    &quot;message&quot;: &quot;Type de client cr&eacute;&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Donn&eacute;es de validation &eacute;chou&eacute;es&quot;,
    &quot;errors&quot;: {
        &quot;label&quot;: [
            &quot;Ce label existe d&eacute;j&agrave;&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-client-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-client-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-client-types"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-client-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-client-types">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-client-types" data-method="POST"
      data-path="api/client-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-client-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-client-types"
                    onclick="tryItOut('POSTapi-client-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-client-types"
                    onclick="cancelTryOut('POSTapi-client-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-client-types"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/client-types</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-client-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-client-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="POSTapi-client-types"
               value="VIP"
               data-component="body">
    <br>
<p>Le nom du type de client. Doit être unique. Example: <code>VIP</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-client-types"
               value="Client VIP avec services exclusifs"
               data-component="body">
    <br>
<p>optionnel Description du type de client. Example: <code>Client VIP avec services exclusifs</code></p>
        </div>
        </form>

                    <h2 id="client-types-management-GETapi-client-types--client_type_id-">Afficher un type de client spécifique</h2>

<p>
</p>

<p>Récupère les détails d'un type de client par son ID.</p>

<span id="example-requests-GETapi-client-types--client_type_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000?with_clients=" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"with_clients\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000"
);

const params = {
    "with_clients": "0",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "with_clients": true
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'with_clients' =&gt; '0',
        ],
        'json' =&gt; [
            'with_clients' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-client-types--client_type_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;label&quot;: &quot;Premium&quot;,
        &quot;description&quot;: &quot;Client premium avec avantages sp&eacute;ciaux&quot;,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Type de client non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-client-types--client_type_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-client-types--client_type_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-client-types--client_type_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-client-types--client_type_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-client-types--client_type_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-client-types--client_type_id-" data-method="GET"
      data-path="api/client-types/{client_type_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-client-types--client_type_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-client-types--client_type_id-"
                    onclick="tryItOut('GETapi-client-types--client_type_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-client-types--client_type_id-"
                    onclick="cancelTryOut('GETapi-client-types--client_type_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-client-types--client_type_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/client-types/{client_type_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="GETapi-client-types--client_type_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_clients</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-client-types--client_type_id-" style="display: none">
            <input type="radio" name="with_clients"
                   value="1"
                   data-endpoint="GETapi-client-types--client_type_id-"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-client-types--client_type_id-" style="display: none">
            <input type="radio" name="with_clients"
                   value="0"
                   data-endpoint="GETapi-client-types--client_type_id-"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les clients associés. Example: <code>false</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>with_clients</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-client-types--client_type_id-" style="display: none">
            <input type="radio" name="with_clients"
                   value="true"
                   data-endpoint="GETapi-client-types--client_type_id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-client-types--client_type_id-" style="display: none">
            <input type="radio" name="with_clients"
                   value="false"
                   data-endpoint="GETapi-client-types--client_type_id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="client-types-management-PUTapi-client-types--client_type_id-">Mettre à jour un type de client</h2>

<p>
</p>

<p>Met à jour les informations d'un type de client existant.
Seuls les champs fournis seront mis à jour.</p>

<span id="example-requests-PUTapi-client-types--client_type_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Premium Plus\",
    \"description\": \"Client premium avec avantages étendus\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Premium Plus",
    "description": "Client premium avec avantages étendus"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Premium Plus',
            'description' =&gt; 'Client premium avec avantages étendus',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-client-types--client_type_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;label&quot;: &quot;Premium Plus&quot;,
        &quot;description&quot;: &quot;Client premium avec avantages &eacute;tendus&quot;,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;
    },
    &quot;message&quot;: &quot;Type de client mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Type de client non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Donn&eacute;es de validation &eacute;chou&eacute;es&quot;,
    &quot;errors&quot;: {
        &quot;label&quot;: [
            &quot;Ce label existe d&eacute;j&agrave;&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-client-types--client_type_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-client-types--client_type_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-client-types--client_type_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-client-types--client_type_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-client-types--client_type_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-client-types--client_type_id-" data-method="PUT"
      data-path="api/client-types/{client_type_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-client-types--client_type_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-client-types--client_type_id-"
                    onclick="tryItOut('PUTapi-client-types--client_type_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-client-types--client_type_id-"
                    onclick="cancelTryOut('PUTapi-client-types--client_type_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-client-types--client_type_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/client-types/{client_type_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="PUTapi-client-types--client_type_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="PUTapi-client-types--client_type_id-"
               value="Premium Plus"
               data-component="body">
    <br>
<p>Le nom du type de client. Doit être unique. Example: <code>Premium Plus</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-client-types--client_type_id-"
               value="Client premium avec avantages étendus"
               data-component="body">
    <br>
<p>Description du type de client. Example: <code>Client premium avec avantages étendus</code></p>
        </div>
        </form>

                    <h2 id="client-types-management-PATCHapi-client-types--client_type_id-">Mettre à jour un type de client</h2>

<p>
</p>

<p>Met à jour les informations d'un type de client existant.
Seuls les champs fournis seront mis à jour.</p>

<span id="example-requests-PATCHapi-client-types--client_type_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Premium Plus\",
    \"description\": \"Client premium avec avantages étendus\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Premium Plus",
    "description": "Client premium avec avantages étendus"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Premium Plus',
            'description' =&gt; 'Client premium avec avantages étendus',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-client-types--client_type_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;label&quot;: &quot;Premium Plus&quot;,
        &quot;description&quot;: &quot;Client premium avec avantages &eacute;tendus&quot;,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;
    },
    &quot;message&quot;: &quot;Type de client mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Type de client non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Donn&eacute;es de validation &eacute;chou&eacute;es&quot;,
    &quot;errors&quot;: {
        &quot;label&quot;: [
            &quot;Ce label existe d&eacute;j&agrave;&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-client-types--client_type_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-client-types--client_type_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-client-types--client_type_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-client-types--client_type_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-client-types--client_type_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-client-types--client_type_id-" data-method="PATCH"
      data-path="api/client-types/{client_type_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-client-types--client_type_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-client-types--client_type_id-"
                    onclick="tryItOut('PATCHapi-client-types--client_type_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-client-types--client_type_id-"
                    onclick="cancelTryOut('PATCHapi-client-types--client_type_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-client-types--client_type_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/client-types/{client_type_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="PATCHapi-client-types--client_type_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="PATCHapi-client-types--client_type_id-"
               value="Premium Plus"
               data-component="body">
    <br>
<p>Le nom du type de client. Doit être unique. Example: <code>Premium Plus</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PATCHapi-client-types--client_type_id-"
               value="Client premium avec avantages étendus"
               data-component="body">
    <br>
<p>Description du type de client. Example: <code>Client premium avec avantages étendus</code></p>
        </div>
        </form>

                    <h2 id="client-types-management-DELETEapi-client-types--client_type_id-">Supprimer un type de client</h2>

<p>
</p>

<p>Supprime définitivement un type de client.
Attention : cette action est irréversible.</p>

<span id="example-requests-DELETEapi-client-types--client_type_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-client-types--client_type_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Type de client supprim&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Type de client non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (409):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Impossible de supprimer ce type de client car il est associ&eacute; &agrave; des clients existants&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-client-types--client_type_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-client-types--client_type_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-client-types--client_type_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-client-types--client_type_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-client-types--client_type_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-client-types--client_type_id-" data-method="DELETE"
      data-path="api/client-types/{client_type_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-client-types--client_type_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-client-types--client_type_id-"
                    onclick="tryItOut('DELETEapi-client-types--client_type_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-client-types--client_type_id-"
                    onclick="cancelTryOut('DELETEapi-client-types--client_type_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-client-types--client_type_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/client-types/{client_type_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-client-types--client_type_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="DELETEapi-client-types--client_type_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="client-types-management-GETapi-client-types-trashed-list">Lister les types de clients supprimés</h2>

<p>
</p>

<p>Récupère la liste des types de clients supprimés (soft delete).</p>

<span id="example-requests-GETapi-client-types-trashed-list">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/client-types/trashed/list?page=1&amp;per_page=15" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"page\": 16,
    \"per_page\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types/trashed/list"
);

const params = {
    "page": "1",
    "per_page": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "page": 16,
    "per_page": 22
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types/trashed/list';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
        ],
        'json' =&gt; [
            'page' =&gt; 16,
            'per_page' =&gt; 22,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-client-types-trashed-list">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;label&quot;: &quot;Ancien Premium&quot;,
            &quot;description&quot;: &quot;Type de client supprim&eacute;&quot;,
            &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;deleted_at&quot;: &quot;2024-01-15T12:00:00Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-client-types-trashed-list" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-client-types-trashed-list"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-client-types-trashed-list"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-client-types-trashed-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-client-types-trashed-list">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-client-types-trashed-list" data-method="GET"
      data-path="api/client-types/trashed/list"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-client-types-trashed-list', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-client-types-trashed-list"
                    onclick="tryItOut('GETapi-client-types-trashed-list');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-client-types-trashed-list"
                    onclick="cancelTryOut('GETapi-client-types-trashed-list');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-client-types-trashed-list"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/client-types/trashed/list</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-client-types-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-client-types-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-client-types-trashed-list"
               value="1"
               data-component="query">
    <br>
<p>Page à récupérer. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-client-types-trashed-list"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page. Example: <code>15</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-client-types-trashed-list"
               value="16"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-client-types-trashed-list"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
        </form>

                    <h2 id="client-types-management-POSTapi-client-types--client_type_id--restore">Restaurer un type de client supprimé (soft delete)</h2>

<p>
</p>

<p>Restaure un type de client qui a été supprimé avec soft delete.</p>

<span id="example-requests-POSTapi-client-types--client_type_id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000/restore"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/client-types/550e8400-e29b-41d4-a716-446655440000/restore';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-client-types--client_type_id--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;label&quot;: &quot;Premium&quot;,
        &quot;description&quot;: &quot;Client premium avec avantages sp&eacute;ciaux&quot;,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;,
        &quot;deleted_at&quot;: null
    },
    &quot;message&quot;: &quot;Type de client restaur&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Type de client non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-client-types--client_type_id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-client-types--client_type_id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-client-types--client_type_id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-client-types--client_type_id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-client-types--client_type_id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-client-types--client_type_id--restore" data-method="POST"
      data-path="api/client-types/{client_type_id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-client-types--client_type_id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-client-types--client_type_id--restore"
                    onclick="tryItOut('POSTapi-client-types--client_type_id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-client-types--client_type_id--restore"
                    onclick="cancelTryOut('POSTapi-client-types--client_type_id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-client-types--client_type_id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/client-types/{client_type_id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-client-types--client_type_id--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-client-types--client_type_id--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="POSTapi-client-types--client_type_id--restore"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                <h1 id="clients-management">Clients Management</h1>

    <p>APIs pour gérer les clients</p>

                                <h2 id="clients-management-GETapi-clients">Liste tous les clients</h2>

<p>
</p>

<p>Récupère la liste de tous les clients avec pagination et filtres optionnels.
Vous pouvez filtrer par nom, email, code, ville, statut et type de client.</p>

<span id="example-requests-GETapi-clients">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clients?page=1&amp;per_page=15&amp;search=John&amp;name=John+Doe&amp;email=john%40example.com&amp;code=CLI-ABC123&amp;city=Cotonou&amp;client_type_id=550e8400-e29b-41d4-a716-446655440000&amp;is_active=1&amp;with_client_type=1&amp;balance_filter=positive" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"page\": 16,
    \"per_page\": 22,
    \"search\": \"g\",
    \"name\": \"z\",
    \"email\": \"rempel.chadrick@example.org\",
    \"code\": \"l\",
    \"city\": \"j\",
    \"client_type_id\": \"c3b6b42e-3a0f-3935-b28d-cb767f8a2a0a\",
    \"is_active\": true,
    \"with_client_type\": true,
    \"balance_filter\": \"zero\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients"
);

const params = {
    "page": "1",
    "per_page": "15",
    "search": "John",
    "name": "John Doe",
    "email": "john@example.com",
    "code": "CLI-ABC123",
    "city": "Cotonou",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "is_active": "1",
    "with_client_type": "1",
    "balance_filter": "positive",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "page": 16,
    "per_page": 22,
    "search": "g",
    "name": "z",
    "email": "rempel.chadrick@example.org",
    "code": "l",
    "city": "j",
    "client_type_id": "c3b6b42e-3a0f-3935-b28d-cb767f8a2a0a",
    "is_active": true,
    "with_client_type": true,
    "balance_filter": "zero"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'search' =&gt; 'John',
            'name' =&gt; 'John Doe',
            'email' =&gt; 'john@example.com',
            'code' =&gt; 'CLI-ABC123',
            'city' =&gt; 'Cotonou',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'is_active' =&gt; '1',
            'with_client_type' =&gt; '1',
            'balance_filter' =&gt; 'positive',
        ],
        'json' =&gt; [
            'page' =&gt; 16,
            'per_page' =&gt; 22,
            'search' =&gt; 'g',
            'name' =&gt; 'z',
            'email' =&gt; 'rempel.chadrick@example.org',
            'code' =&gt; 'l',
            'city' =&gt; 'j',
            'client_type_id' =&gt; 'c3b6b42e-3a0f-3935-b28d-cb767f8a2a0a',
            'is_active' =&gt; true,
            'with_client_type' =&gt; true,
            'balance_filter' =&gt; 'zero',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-clients">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;code&quot;: &quot;CLI-ABC123&quot;,
            &quot;name_client&quot;: &quot;John Doe&quot;,
            &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
            &quot;adresse&quot;: &quot;123 Rue de la Paix&quot;,
            &quot;city&quot;: &quot;Cotonou&quot;,
            &quot;email&quot;: &quot;john.doe@example.com&quot;,
            &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
            &quot;credit_limit&quot;: &quot;500000.00&quot;,
            &quot;current_balance&quot;: &quot;150000.00&quot;,
            &quot;is_active&quot;: true,
            &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;formatted_credit_limit&quot;: &quot;500 000,00 FCFA&quot;,
            &quot;formatted_current_balance&quot;: &quot;150 000,00 FCFA&quot;,
            &quot;available_credit&quot;: &quot;350000.00&quot;,
            &quot;formatted_available_credit&quot;: &quot;350 000,00 FCFA&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clients" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clients"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clients"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clients" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clients">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clients" data-method="GET"
      data-path="api/clients"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clients', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clients"
                    onclick="tryItOut('GETapi-clients');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clients"
                    onclick="cancelTryOut('GETapi-clients');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clients"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clients</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clients"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clients"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-clients"
               value="1"
               data-component="query">
    <br>
<p>Page à récupérer (pagination). Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-clients"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page (max: 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-clients"
               value="John"
               data-component="query">
    <br>
<p>Recherche globale (nom, email, code). Example: <code>John</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="GETapi-clients"
               value="John Doe"
               data-component="query">
    <br>
<p>Rechercher par nom de client. Example: <code>John Doe</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="GETapi-clients"
               value="john@example.com"
               data-component="query">
    <br>
<p>Rechercher par email. Example: <code>john@example.com</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-clients"
               value="CLI-ABC123"
               data-component="query">
    <br>
<p>Rechercher par code client. Example: <code>CLI-ABC123</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="GETapi-clients"
               value="Cotonou"
               data-component="query">
    <br>
<p>Rechercher par ville. Example: <code>Cotonou</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="GETapi-clients"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="query">
    <br>
<p>Filtrer par type de client (UUID). Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="is_active"
                   value="1"
                   data-endpoint="GETapi-clients"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="is_active"
                   value="0"
                   data-endpoint="GETapi-clients"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filtrer par statut actif. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_client_type</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="with_client_type"
                   value="1"
                   data-endpoint="GETapi-clients"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="with_client_type"
                   value="0"
                   data-endpoint="GETapi-clients"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les informations du type de client. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>balance_filter</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="balance_filter"                data-endpoint="GETapi-clients"
               value="positive"
               data-component="query">
    <br>
<p>Filtrer par solde (positive, negative, zero). Example: <code>positive</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-clients"
               value="16"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-clients"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-clients"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="GETapi-clients"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>z</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="GETapi-clients"
               value="rempel.chadrick@example.org"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>rempel.chadrick@example.org</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-clients"
               value="l"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>l</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="GETapi-clients"
               value="j"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>j</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="GETapi-clients"
               value="c3b6b42e-3a0f-3935-b28d-cb767f8a2a0a"
               data-component="body">
    <br>
<p>Must be a valid UUID. The <code>client_type_id</code> of an existing record in the client_types table. Example: <code>c3b6b42e-3a0f-3935-b28d-cb767f8a2a0a</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="GETapi-clients"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="GETapi-clients"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>with_client_type</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="with_client_type"
                   value="true"
                   data-endpoint="GETapi-clients"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients" style="display: none">
            <input type="radio" name="with_client_type"
                   value="false"
                   data-endpoint="GETapi-clients"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>balance_filter</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="balance_filter"                data-endpoint="GETapi-clients"
               value="zero"
               data-component="body">
    <br>
<p>Example: <code>zero</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>positive</code></li> <li><code>negative</code></li> <li><code>zero</code></li></ul>
        </div>
        </form>

                    <h2 id="clients-management-POSTapi-clients">Créer un nouveau client</h2>

<p>
</p>

<p>Crée un nouveau client avec les informations fournies.
L'UUID et le code client sont générés automatiquement si non fournis.</p>

<span id="example-requests-POSTapi-clients">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clients" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name_client\": \"John Doe\",
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"adresse\": \"123 Rue de la Paix\",
    \"city\": \"Cotonou\",
    \"email\": \"john.doe@example.com\",
    \"phonenumber\": \"+229 12 34 56 78\",
    \"credit_limit\": 500000,
    \"current_balance\": 0,
    \"is_active\": true,
    \"code\": \"CLI-CUSTOM\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name_client": "John Doe",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "adresse": "123 Rue de la Paix",
    "city": "Cotonou",
    "email": "john.doe@example.com",
    "phonenumber": "+229 12 34 56 78",
    "credit_limit": 500000,
    "current_balance": 0,
    "is_active": true,
    "code": "CLI-CUSTOM"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name_client' =&gt; 'John Doe',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'adresse' =&gt; '123 Rue de la Paix',
            'city' =&gt; 'Cotonou',
            'email' =&gt; 'john.doe@example.com',
            'phonenumber' =&gt; '+229 12 34 56 78',
            'credit_limit' =&gt; 500000.0,
            'current_balance' =&gt; 0.0,
            'is_active' =&gt; true,
            'code' =&gt; 'CLI-CUSTOM',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-clients">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;code&quot;: &quot;CLI-ABC123&quot;,
        &quot;name_client&quot;: &quot;John Doe&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;123 Rue de la Paix&quot;,
        &quot;city&quot;: &quot;Cotonou&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
        &quot;credit_limit&quot;: &quot;500000.00&quot;,
        &quot;current_balance&quot;: &quot;0.00&quot;,
        &quot;is_active&quot;: true,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;
    },
    &quot;message&quot;: &quot;Client cr&eacute;&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Donn&eacute;es de validation &eacute;chou&eacute;es&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;Cette adresse email est d&eacute;j&agrave; utilis&eacute;e&quot;
        ],
        &quot;code&quot;: [
            &quot;Ce code client existe d&eacute;j&agrave;&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-clients" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clients"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clients"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clients" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clients">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clients" data-method="POST"
      data-path="api/clients"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clients', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clients"
                    onclick="tryItOut('POSTapi-clients');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clients"
                    onclick="cancelTryOut('POSTapi-clients');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clients"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clients</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clients"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clients"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name_client</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name_client"                data-endpoint="POSTapi-clients"
               value="John Doe"
               data-component="body">
    <br>
<p>Nom complet du client. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="POSTapi-clients"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="body">
    <br>
<p>optionnel UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="POSTapi-clients"
               value="123 Rue de la Paix"
               data-component="body">
    <br>
<p>optionnel Adresse du client. Example: <code>123 Rue de la Paix</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="POSTapi-clients"
               value="Cotonou"
               data-component="body">
    <br>
<p>optionnel Ville du client. Example: <code>Cotonou</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-clients"
               value="john.doe@example.com"
               data-component="body">
    <br>
<p>optionnel Email unique du client. Example: <code>john.doe@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phonenumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phonenumber"                data-endpoint="POSTapi-clients"
               value="+229 12 34 56 78"
               data-component="body">
    <br>
<p>optionnel Numéro de téléphone. Example: <code>+229 12 34 56 78</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_limit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_limit"                data-endpoint="POSTapi-clients"
               value="500000"
               data-component="body">
    <br>
<p>optionnel Limite de crédit (défaut: 0). Example: <code>500000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_balance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="current_balance"                data-endpoint="POSTapi-clients"
               value="0"
               data-component="body">
    <br>
<p>optionnel Solde actuel (défaut: 0). Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-clients" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-clients"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-clients" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-clients"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>optionnel Statut actif (défaut: true). Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-clients"
               value="CLI-CUSTOM"
               data-component="body">
    <br>
<p>optionnel Code client unique. Si non fourni, sera généré automatiquement. Example: <code>CLI-CUSTOM</code></p>
        </div>
        </form>

                    <h2 id="clients-management-GETapi-clients--client_id-">Afficher un client spécifique</h2>

<p>
</p>

<p>Récupère les détails d'un client par son ID.</p>

<span id="example-requests-GETapi-clients--client_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000?with_client_type=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"with_client_type\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000"
);

const params = {
    "with_client_type": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "with_client_type": false
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'with_client_type' =&gt; '1',
        ],
        'json' =&gt; [
            'with_client_type' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-clients--client_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;code&quot;: &quot;CLI-ABC123&quot;,
        &quot;name_client&quot;: &quot;John Doe&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;123 Rue de la Paix&quot;,
        &quot;city&quot;: &quot;Cotonou&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
        &quot;credit_limit&quot;: &quot;500000.00&quot;,
        &quot;current_balance&quot;: &quot;150000.00&quot;,
        &quot;is_active&quot;: true,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Client non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clients--client_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clients--client_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clients--client_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clients--client_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clients--client_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clients--client_id-" data-method="GET"
      data-path="api/clients/{client_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clients--client_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clients--client_id-"
                    onclick="tryItOut('GETapi-clients--client_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clients--client_id-"
                    onclick="cancelTryOut('GETapi-clients--client_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clients--client_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clients/{client_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="GETapi-clients--client_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_client_type</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients--client_id-" style="display: none">
            <input type="radio" name="with_client_type"
                   value="1"
                   data-endpoint="GETapi-clients--client_id-"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients--client_id-" style="display: none">
            <input type="radio" name="with_client_type"
                   value="0"
                   data-endpoint="GETapi-clients--client_id-"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les informations du type de client. Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>with_client_type</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients--client_id-" style="display: none">
            <input type="radio" name="with_client_type"
                   value="true"
                   data-endpoint="GETapi-clients--client_id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients--client_id-" style="display: none">
            <input type="radio" name="with_client_type"
                   value="false"
                   data-endpoint="GETapi-clients--client_id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="clients-management-PUTapi-clients--client_id-">Mettre à jour un client</h2>

<p>
</p>

<p>Met à jour les informations d'un client existant.
Seuls les champs fournis seront mis à jour.</p>

<span id="example-requests-PUTapi-clients--client_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"code\": \"CLI-UPDATED\",
    \"name_client\": \"Jane Doe\",
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"adresse\": \"456 Avenue des Palmiers\",
    \"city\": \"Porto-Novo\",
    \"email\": \"jane.doe@example.com\",
    \"phonenumber\": \"+229 87 65 43 21\",
    \"credit_limit\": 750000,
    \"current_balance\": 200000,
    \"is_active\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "code": "CLI-UPDATED",
    "name_client": "Jane Doe",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "adresse": "456 Avenue des Palmiers",
    "city": "Porto-Novo",
    "email": "jane.doe@example.com",
    "phonenumber": "+229 87 65 43 21",
    "credit_limit": 750000,
    "current_balance": 200000,
    "is_active": false
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'code' =&gt; 'CLI-UPDATED',
            'name_client' =&gt; 'Jane Doe',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'adresse' =&gt; '456 Avenue des Palmiers',
            'city' =&gt; 'Porto-Novo',
            'email' =&gt; 'jane.doe@example.com',
            'phonenumber' =&gt; '+229 87 65 43 21',
            'credit_limit' =&gt; 750000.0,
            'current_balance' =&gt; 200000.0,
            'is_active' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-clients--client_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;code&quot;: &quot;CLI-UPDATED&quot;,
        &quot;name_client&quot;: &quot;Jane Doe&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;456 Avenue des Palmiers&quot;,
        &quot;city&quot;: &quot;Porto-Novo&quot;,
        &quot;email&quot;: &quot;jane.doe@example.com&quot;,
        &quot;phonenumber&quot;: &quot;+229 87 65 43 21&quot;,
        &quot;credit_limit&quot;: &quot;750000.00&quot;,
        &quot;current_balance&quot;: &quot;200000.00&quot;,
        &quot;is_active&quot;: false,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;
    },
    &quot;message&quot;: &quot;Client mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-clients--client_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-clients--client_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-clients--client_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-clients--client_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-clients--client_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-clients--client_id-" data-method="PUT"
      data-path="api/clients/{client_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-clients--client_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-clients--client_id-"
                    onclick="tryItOut('PUTapi-clients--client_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-clients--client_id-"
                    onclick="cancelTryOut('PUTapi-clients--client_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-clients--client_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/clients/{client_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="PUTapi-clients--client_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="PUTapi-clients--client_id-"
               value="CLI-UPDATED"
               data-component="body">
    <br>
<p>Code client unique. Example: <code>CLI-UPDATED</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name_client</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name_client"                data-endpoint="PUTapi-clients--client_id-"
               value="Jane Doe"
               data-component="body">
    <br>
<p>Nom complet du client. Example: <code>Jane Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="PUTapi-clients--client_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="body">
    <br>
<p>UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="PUTapi-clients--client_id-"
               value="456 Avenue des Palmiers"
               data-component="body">
    <br>
<p>Adresse du client. Example: <code>456 Avenue des Palmiers</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="PUTapi-clients--client_id-"
               value="Porto-Novo"
               data-component="body">
    <br>
<p>Ville du client. Example: <code>Porto-Novo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PUTapi-clients--client_id-"
               value="jane.doe@example.com"
               data-component="body">
    <br>
<p>Email unique du client. Example: <code>jane.doe@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phonenumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phonenumber"                data-endpoint="PUTapi-clients--client_id-"
               value="+229 87 65 43 21"
               data-component="body">
    <br>
<p>Numéro de téléphone. Example: <code>+229 87 65 43 21</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_limit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_limit"                data-endpoint="PUTapi-clients--client_id-"
               value="750000"
               data-component="body">
    <br>
<p>Limite de crédit. Example: <code>750000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_balance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="current_balance"                data-endpoint="PUTapi-clients--client_id-"
               value="200000"
               data-component="body">
    <br>
<p>Solde actuel. Example: <code>200000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PUTapi-clients--client_id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PUTapi-clients--client_id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-clients--client_id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PUTapi-clients--client_id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif. Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="clients-management-PATCHapi-clients--client_id-">Mettre à jour un client</h2>

<p>
</p>

<p>Met à jour les informations d'un client existant.
Seuls les champs fournis seront mis à jour.</p>

<span id="example-requests-PATCHapi-clients--client_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"code\": \"CLI-UPDATED\",
    \"name_client\": \"Jane Doe\",
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"adresse\": \"456 Avenue des Palmiers\",
    \"city\": \"Porto-Novo\",
    \"email\": \"jane.doe@example.com\",
    \"phonenumber\": \"+229 87 65 43 21\",
    \"credit_limit\": 750000,
    \"current_balance\": 200000,
    \"is_active\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "code": "CLI-UPDATED",
    "name_client": "Jane Doe",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "adresse": "456 Avenue des Palmiers",
    "city": "Porto-Novo",
    "email": "jane.doe@example.com",
    "phonenumber": "+229 87 65 43 21",
    "credit_limit": 750000,
    "current_balance": 200000,
    "is_active": false
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'code' =&gt; 'CLI-UPDATED',
            'name_client' =&gt; 'Jane Doe',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'adresse' =&gt; '456 Avenue des Palmiers',
            'city' =&gt; 'Porto-Novo',
            'email' =&gt; 'jane.doe@example.com',
            'phonenumber' =&gt; '+229 87 65 43 21',
            'credit_limit' =&gt; 750000.0,
            'current_balance' =&gt; 200000.0,
            'is_active' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-clients--client_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;code&quot;: &quot;CLI-UPDATED&quot;,
        &quot;name_client&quot;: &quot;Jane Doe&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;456 Avenue des Palmiers&quot;,
        &quot;city&quot;: &quot;Porto-Novo&quot;,
        &quot;email&quot;: &quot;jane.doe@example.com&quot;,
        &quot;phonenumber&quot;: &quot;+229 87 65 43 21&quot;,
        &quot;credit_limit&quot;: &quot;750000.00&quot;,
        &quot;current_balance&quot;: &quot;200000.00&quot;,
        &quot;is_active&quot;: false,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;
    },
    &quot;message&quot;: &quot;Client mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-clients--client_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-clients--client_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-clients--client_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-clients--client_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-clients--client_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-clients--client_id-" data-method="PATCH"
      data-path="api/clients/{client_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-clients--client_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-clients--client_id-"
                    onclick="tryItOut('PATCHapi-clients--client_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-clients--client_id-"
                    onclick="cancelTryOut('PATCHapi-clients--client_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-clients--client_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/clients/{client_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="PATCHapi-clients--client_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="PATCHapi-clients--client_id-"
               value="CLI-UPDATED"
               data-component="body">
    <br>
<p>Code client unique. Example: <code>CLI-UPDATED</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name_client</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name_client"                data-endpoint="PATCHapi-clients--client_id-"
               value="Jane Doe"
               data-component="body">
    <br>
<p>Nom complet du client. Example: <code>Jane Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="PATCHapi-clients--client_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="body">
    <br>
<p>UUID du type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="PATCHapi-clients--client_id-"
               value="456 Avenue des Palmiers"
               data-component="body">
    <br>
<p>Adresse du client. Example: <code>456 Avenue des Palmiers</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="PATCHapi-clients--client_id-"
               value="Porto-Novo"
               data-component="body">
    <br>
<p>Ville du client. Example: <code>Porto-Novo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PATCHapi-clients--client_id-"
               value="jane.doe@example.com"
               data-component="body">
    <br>
<p>Email unique du client. Example: <code>jane.doe@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phonenumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phonenumber"                data-endpoint="PATCHapi-clients--client_id-"
               value="+229 87 65 43 21"
               data-component="body">
    <br>
<p>Numéro de téléphone. Example: <code>+229 87 65 43 21</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_limit</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_limit"                data-endpoint="PATCHapi-clients--client_id-"
               value="750000"
               data-component="body">
    <br>
<p>Limite de crédit. Example: <code>750000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_balance</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="current_balance"                data-endpoint="PATCHapi-clients--client_id-"
               value="200000"
               data-component="body">
    <br>
<p>Solde actuel. Example: <code>200000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PATCHapi-clients--client_id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PATCHapi-clients--client_id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PATCHapi-clients--client_id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PATCHapi-clients--client_id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif. Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="clients-management-DELETEapi-clients--client_id-">Supprimer un client</h2>

<p>
</p>

<p>Supprime un client (soft delete).
Le client sera marqué comme supprimé mais restera dans la base de données.</p>

<span id="example-requests-DELETEapi-clients--client_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-clients--client_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Client supprim&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Client non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-clients--client_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-clients--client_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-clients--client_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-clients--client_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-clients--client_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-clients--client_id-" data-method="DELETE"
      data-path="api/clients/{client_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-clients--client_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-clients--client_id-"
                    onclick="tryItOut('DELETEapi-clients--client_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-clients--client_id-"
                    onclick="cancelTryOut('DELETEapi-clients--client_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-clients--client_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/clients/{client_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="DELETEapi-clients--client_id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="clients-management-GETapi-clients-trashed-list">Lister les clients supprimés</h2>

<p>
</p>

<p>Récupère la liste des clients supprimés (soft delete).</p>

<span id="example-requests-GETapi-clients-trashed-list">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clients/trashed/list?page=1&amp;per_page=15&amp;with_client_type=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"page\": 16,
    \"per_page\": 22,
    \"with_client_type\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/trashed/list"
);

const params = {
    "page": "1",
    "per_page": "15",
    "with_client_type": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "page": 16,
    "per_page": 22,
    "with_client_type": false
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/trashed/list';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'with_client_type' =&gt; '1',
        ],
        'json' =&gt; [
            'page' =&gt; 16,
            'per_page' =&gt; 22,
            'with_client_type' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-clients-trashed-list">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;code&quot;: &quot;CLI-DEL123&quot;,
            &quot;name_client&quot;: &quot;Client Supprim&eacute;&quot;,
            &quot;email&quot;: &quot;deleted@example.com&quot;,
            &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;deleted_at&quot;: &quot;2024-01-15T12:00:00Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clients-trashed-list" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clients-trashed-list"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clients-trashed-list"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clients-trashed-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clients-trashed-list">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clients-trashed-list" data-method="GET"
      data-path="api/clients/trashed/list"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clients-trashed-list', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clients-trashed-list"
                    onclick="tryItOut('GETapi-clients-trashed-list');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clients-trashed-list"
                    onclick="cancelTryOut('GETapi-clients-trashed-list');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clients-trashed-list"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clients/trashed/list</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clients-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clients-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-clients-trashed-list"
               value="1"
               data-component="query">
    <br>
<p>Page à récupérer. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-clients-trashed-list"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page. Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_client_type</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients-trashed-list" style="display: none">
            <input type="radio" name="with_client_type"
                   value="1"
                   data-endpoint="GETapi-clients-trashed-list"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients-trashed-list" style="display: none">
            <input type="radio" name="with_client_type"
                   value="0"
                   data-endpoint="GETapi-clients-trashed-list"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les informations du type de client. Example: <code>true</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-clients-trashed-list"
               value="16"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-clients-trashed-list"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>with_client_type</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-clients-trashed-list" style="display: none">
            <input type="radio" name="with_client_type"
                   value="true"
                   data-endpoint="GETapi-clients-trashed-list"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-clients-trashed-list" style="display: none">
            <input type="radio" name="with_client_type"
                   value="false"
                   data-endpoint="GETapi-clients-trashed-list"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="clients-management-POSTapi-clients--client_id--restore">Restaurer un client supprimé</h2>

<p>
</p>

<p>Restaure un client qui a été supprimé avec soft delete.</p>

<span id="example-requests-POSTapi-clients--client_id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/restore"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/restore';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-clients--client_id--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;code&quot;: &quot;CLI-ABC123&quot;,
        &quot;name_client&quot;: &quot;John Doe&quot;,
        &quot;deleted_at&quot;: null
    },
    &quot;message&quot;: &quot;Client restaur&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-clients--client_id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clients--client_id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clients--client_id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clients--client_id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clients--client_id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clients--client_id--restore" data-method="POST"
      data-path="api/clients/{client_id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clients--client_id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clients--client_id--restore"
                    onclick="tryItOut('POSTapi-clients--client_id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clients--client_id--restore"
                    onclick="cancelTryOut('POSTapi-clients--client_id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clients--client_id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clients/{client_id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clients--client_id--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clients--client_id--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="POSTapi-clients--client_id--restore"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="clients-management-PATCHapi-clients--client_id--toggle-status">Activer/Désactiver un client</h2>

<p>
</p>

<p>Change le statut actif d'un client.</p>

<span id="example-requests-PATCHapi-clients--client_id--toggle-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/toggle-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"is_active\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/toggle-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "is_active": false
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/toggle-status';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'is_active' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-clients--client_id--toggle-status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;is_active&quot;: false
    },
    &quot;message&quot;: &quot;Statut du client mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-clients--client_id--toggle-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-clients--client_id--toggle-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-clients--client_id--toggle-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-clients--client_id--toggle-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-clients--client_id--toggle-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-clients--client_id--toggle-status" data-method="PATCH"
      data-path="api/clients/{client_id}/toggle-status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-clients--client_id--toggle-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-clients--client_id--toggle-status"
                    onclick="tryItOut('PATCHapi-clients--client_id--toggle-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-clients--client_id--toggle-status"
                    onclick="cancelTryOut('PATCHapi-clients--client_id--toggle-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-clients--client_id--toggle-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/clients/{client_id}/toggle-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-clients--client_id--toggle-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-clients--client_id--toggle-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="PATCHapi-clients--client_id--toggle-status"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
                <label data-endpoint="PATCHapi-clients--client_id--toggle-status" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PATCHapi-clients--client_id--toggle-status"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PATCHapi-clients--client_id--toggle-status" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PATCHapi-clients--client_id--toggle-status"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Nouveau statut actif. Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="clients-management-PATCHapi-clients--client_id--update-balance">Mettre à jour le solde d&#039;un client</h2>

<p>
</p>

<p>Ajoute ou soustrait un montant au solde actuel du client.</p>

<span id="example-requests-PATCHapi-clients--client_id--update-balance">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/update-balance" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"amount\": 50000,
    \"description\": \"Paiement facture\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/update-balance"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "amount": 50000,
    "description": "Paiement facture"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/550e8400-e29b-41d4-a716-446655440000/update-balance';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'amount' =&gt; 50000.0,
            'description' =&gt; 'Paiement facture',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-clients--client_id--update-balance">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;previous_balance&quot;: &quot;150000.00&quot;,
        &quot;new_balance&quot;: &quot;200000.00&quot;,
        &quot;amount_added&quot;: &quot;50000.00&quot;,
        &quot;available_credit&quot;: &quot;300000.00&quot;
    },
    &quot;message&quot;: &quot;Solde mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Le montant d&eacute;passerait la limite de cr&eacute;dit autoris&eacute;e&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-clients--client_id--update-balance" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-clients--client_id--update-balance"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-clients--client_id--update-balance"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-clients--client_id--update-balance" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-clients--client_id--update-balance">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-clients--client_id--update-balance" data-method="PATCH"
      data-path="api/clients/{client_id}/update-balance"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-clients--client_id--update-balance', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-clients--client_id--update-balance"
                    onclick="tryItOut('PATCHapi-clients--client_id--update-balance');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-clients--client_id--update-balance"
                    onclick="cancelTryOut('PATCHapi-clients--client_id--update-balance');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-clients--client_id--update-balance"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/clients/{client_id}/update-balance</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-clients--client_id--update-balance"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-clients--client_id--update-balance"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="PATCHapi-clients--client_id--update-balance"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'UUID du client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>amount</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="amount"                data-endpoint="PATCHapi-clients--client_id--update-balance"
               value="50000"
               data-component="body">
    <br>
<p>Montant à ajouter (positif) ou soustraire (négatif). Example: <code>50000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PATCHapi-clients--client_id--update-balance"
               value="Paiement facture"
               data-component="body">
    <br>
<p>optionnel Description de l'opération. Example: <code>Paiement facture</code></p>
        </div>
        </form>

                    <h2 id="clients-management-POSTapi-clients-search">Rechercher des clients</h2>

<p>
</p>

<p>Recherche avancée de clients avec de multiples critères.</p>

<span id="example-requests-POSTapi-clients-search">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clients/search" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"query\": \"John\",
    \"fields\": [
        \"name_client\",
        \"email\"
    ],
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"is_active\": true,
    \"credit_min\": 100000,
    \"credit_max\": 1000000,
    \"balance_min\": -50000,
    \"balance_max\": 500000,
    \"page\": 1,
    \"per_page\": 20
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/search"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "query": "John",
    "fields": [
        "name_client",
        "email"
    ],
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "is_active": true,
    "credit_min": 100000,
    "credit_max": 1000000,
    "balance_min": -50000,
    "balance_max": 500000,
    "page": 1,
    "per_page": 20
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/search';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'query' =&gt; 'John',
            'fields' =&gt; [
                'name_client',
                'email',
            ],
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'is_active' =&gt; true,
            'credit_min' =&gt; 100000.0,
            'credit_max' =&gt; 1000000.0,
            'balance_min' =&gt; -50000.0,
            'balance_max' =&gt; 500000.0,
            'page' =&gt; 1,
            'per_page' =&gt; 20,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-clients-search">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;client_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;code&quot;: &quot;CLI-ABC123&quot;,
            &quot;name_client&quot;: &quot;John Doe&quot;,
            &quot;email&quot;: &quot;john.doe@example.com&quot;,
            &quot;city&quot;: &quot;Cotonou&quot;,
            &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
            &quot;credit_limit&quot;: &quot;500000.00&quot;,
            &quot;current_balance&quot;: &quot;150000.00&quot;,
            &quot;is_active&quot;: true
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 1,
        &quot;per_page&quot;: 20,
        &quot;current_page&quot;: 1
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-clients-search" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clients-search"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clients-search"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clients-search" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clients-search">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clients-search" data-method="POST"
      data-path="api/clients/search"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clients-search', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clients-search"
                    onclick="tryItOut('POSTapi-clients-search');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clients-search"
                    onclick="cancelTryOut('POSTapi-clients-search');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clients-search"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clients/search</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clients-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clients-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>query</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="query"                data-endpoint="POSTapi-clients-search"
               value="John"
               data-component="body">
    <br>
<p>Terme de recherche. Example: <code>John</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fields</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="fields[0]"                data-endpoint="POSTapi-clients-search"
               data-component="body">
        <input type="text" style="display: none"
               name="fields[1]"                data-endpoint="POSTapi-clients-search"
               data-component="body">
    <br>
<p>optionnel Champs à rechercher (name_client, email, code, city, phonenumber).</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="POSTapi-clients-search"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="body">
    <br>
<p>optionnel Filtrer par type de client. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-clients-search" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-clients-search"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-clients-search" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-clients-search"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>optionnel Filtrer par statut. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_min</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_min"                data-endpoint="POSTapi-clients-search"
               value="100000"
               data-component="body">
    <br>
<p>optionnel Limite de crédit minimale. Example: <code>100000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>credit_max</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="credit_max"                data-endpoint="POSTapi-clients-search"
               value="1000000"
               data-component="body">
    <br>
<p>optionnel Limite de crédit maximale. Example: <code>1000000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>balance_min</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="balance_min"                data-endpoint="POSTapi-clients-search"
               value="-50000"
               data-component="body">
    <br>
<p>optionnel Solde minimal. Example: <code>-50000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>balance_max</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="balance_max"                data-endpoint="POSTapi-clients-search"
               value="500000"
               data-component="body">
    <br>
<p>optionnel Solde maximal. Example: <code>500000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="POSTapi-clients-search"
               value="1"
               data-component="body">
    <br>
<p>optionnel Page à récupérer. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="POSTapi-clients-search"
               value="20"
               data-component="body">
    <br>
<p>optionnel Éléments par page. Example: <code>20</code></p>
        </div>
        </form>

                    <h2 id="clients-management-GETapi-clients-statistics-overview">Statistiques des clients</h2>

<p>
</p>

<p>Récupère des statistiques générales sur les clients.</p>

<span id="example-requests-GETapi-clients-statistics-overview">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clients/statistics/overview" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clients/statistics/overview"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/clients/statistics/overview';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-clients-statistics-overview">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;total_clients&quot;: 150,
        &quot;active_clients&quot;: 120,
        &quot;inactive_clients&quot;: 30,
        &quot;deleted_clients&quot;: 5,
        &quot;clients_with_positive_balance&quot;: 80,
        &quot;clients_with_negative_balance&quot;: 25,
        &quot;clients_with_zero_balance&quot;: 45,
        &quot;total_credit_limit&quot;: &quot;75000000.00&quot;,
        &quot;total_current_balance&quot;: &quot;12500000.00&quot;,
        &quot;total_available_credit&quot;: &quot;62500000.00&quot;,
        &quot;average_credit_limit&quot;: &quot;500000.00&quot;,
        &quot;average_current_balance&quot;: &quot;83333.33&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clients-statistics-overview" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clients-statistics-overview"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clients-statistics-overview"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clients-statistics-overview" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clients-statistics-overview">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clients-statistics-overview" data-method="GET"
      data-path="api/clients/statistics/overview"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clients-statistics-overview', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clients-statistics-overview"
                    onclick="tryItOut('GETapi-clients-statistics-overview');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clients-statistics-overview"
                    onclick="cancelTryOut('GETapi-clients-statistics-overview');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clients-statistics-overview"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clients/statistics/overview</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clients-statistics-overview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clients-statistics-overview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="entrepots">Entrepôts</h1>

    <p>APIs pour la gestion des entrepôts et l'attribution des responsables</p>

                                <h2 id="entrepots-GETapi-entrepots">Liste des entrepôts</h2>

<p>
</p>

<p>Récupère la liste paginée des entrepôts avec possibilité de filtrage.</p>

<span id="example-requests-GETapi-entrepots">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/entrepots?page=1&amp;per_page=15&amp;search=Central&amp;is_active=1&amp;user_id=550e8400-e29b-41d4-a716-446655440001&amp;has_user=1&amp;sort_by=name&amp;sort_order=asc&amp;with_user=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots"
);

const params = {
    "page": "1",
    "per_page": "15",
    "search": "Central",
    "is_active": "1",
    "user_id": "550e8400-e29b-41d4-a716-446655440001",
    "has_user": "1",
    "sort_by": "name",
    "sort_order": "asc",
    "with_user": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'search' =&gt; 'Central',
            'is_active' =&gt; '1',
            'user_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
            'has_user' =&gt; '1',
            'sort_by' =&gt; 'name',
            'sort_order' =&gt; 'asc',
            'with_user' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-entrepots">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;code&quot;: &quot;ENT001&quot;,
            &quot;name&quot;: &quot;Entrep&ocirc;t Central&quot;,
            &quot;adresse&quot;: &quot;123 Rue de l&#039;Industrie&quot;,
            &quot;is_active&quot;: true,
            &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
            &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;user&quot;: {
                &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
                &quot;name&quot;: &quot;Jean Dupont&quot;,
                &quot;email&quot;: &quot;jean.dupont@example.com&quot;
            }
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://api.example.com/entrepots?page=1&quot;,
        &quot;last&quot;: &quot;http://api.example.com/entrepots?page=5&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://api.example.com/entrepots?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 5,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 75
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-entrepots" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-entrepots"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-entrepots"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-entrepots" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-entrepots">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-entrepots" data-method="GET"
      data-path="api/entrepots"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-entrepots', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-entrepots"
                    onclick="tryItOut('GETapi-entrepots');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-entrepots"
                    onclick="cancelTryOut('GETapi-entrepots');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-entrepots"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/entrepots</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-entrepots"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-entrepots"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-entrepots"
               value="1"
               data-component="query">
    <br>
<p>Numéro de la page. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-entrepots"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page (max 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-entrepots"
               value="Central"
               data-component="query">
    <br>
<p>Recherche par nom, code ou adresse. Example: <code>Central</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-entrepots" style="display: none">
            <input type="radio" name="is_active"
                   value="1"
                   data-endpoint="GETapi-entrepots"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-entrepots" style="display: none">
            <input type="radio" name="is_active"
                   value="0"
                   data-endpoint="GETapi-entrepots"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filtrer par statut actif (true/false). Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="GETapi-entrepots"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="query">
    <br>
<p>Filtrer par responsable (UUID). Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>has_user</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-entrepots" style="display: none">
            <input type="radio" name="has_user"
                   value="1"
                   data-endpoint="GETapi-entrepots"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-entrepots" style="display: none">
            <input type="radio" name="has_user"
                   value="0"
                   data-endpoint="GETapi-entrepots"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filtrer les entrepôts avec/sans responsable. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-entrepots"
               value="name"
               data-component="query">
    <br>
<p>Champ de tri (name, code, created_at). Example: <code>name</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_order"                data-endpoint="GETapi-entrepots"
               value="asc"
               data-component="query">
    <br>
<p>Ordre de tri (asc, desc). Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_user</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-entrepots" style="display: none">
            <input type="radio" name="with_user"
                   value="1"
                   data-endpoint="GETapi-entrepots"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-entrepots" style="display: none">
            <input type="radio" name="with_user"
                   value="0"
                   data-endpoint="GETapi-entrepots"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les informations du responsable. Example: <code>true</code></p>
            </div>
                </form>

                    <h2 id="entrepots-POSTapi-entrepots">Créer un entrepôt</h2>

<p>
</p>

<p>Crée un nouvel entrepôt dans le système. Le code est généré automatiquement.</p>

<span id="example-requests-POSTapi-entrepots">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/entrepots" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Entrepôt Central\",
    \"adresse\": \"123 Rue de l\'Industrie\",
    \"is_active\": true,
    \"user_id\": \"550e8400-e29b-41d4-a716-446655440001\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Entrepôt Central",
    "adresse": "123 Rue de l'Industrie",
    "is_active": true,
    "user_id": "550e8400-e29b-41d4-a716-446655440001"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Entrepôt Central',
            'adresse' =&gt; '123 Rue de l\'Industrie',
            'is_active' =&gt; true,
            'user_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-entrepots">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT-ABC123&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central&quot;,
    &quot;adresse&quot;: &quot;123 Rue de l&#039;Industrie&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;user&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;name&quot;: &quot;Jean Dupont&quot;,
        &quot;email&quot;: &quot;jean.dupont@example.com&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Le nom est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-entrepots" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-entrepots"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-entrepots"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-entrepots" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-entrepots">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-entrepots" data-method="POST"
      data-path="api/entrepots"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-entrepots', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-entrepots"
                    onclick="tryItOut('POSTapi-entrepots');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-entrepots"
                    onclick="cancelTryOut('POSTapi-entrepots');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-entrepots"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/entrepots</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-entrepots"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-entrepots"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-entrepots"
               value="Entrepôt Central"
               data-component="body">
    <br>
<p>Nom de l'entrepôt. Example: <code>Entrepôt Central</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="POSTapi-entrepots"
               value="123 Rue de l'Industrie"
               data-component="body">
    <br>
<p>Adresse de l'entrepôt. Example: <code>123 Rue de l'Industrie</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-entrepots" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-entrepots"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-entrepots" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-entrepots"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif (par défaut: true). Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="POSTapi-entrepots"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="body">
    <br>
<p>UUID du responsable (optionnel). Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
        </div>
        </form>

                    <h2 id="entrepots-GETapi-entrepots--id-">Afficher un entrepôt</h2>

<p>
</p>

<p>Récupère les détails d'un entrepôt spécifique.</p>

<span id="example-requests-GETapi-entrepots--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000?with_user=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000"
);

const params = {
    "with_user": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'with_user' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-entrepots--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT001&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central&quot;,
    &quot;adresse&quot;: &quot;123 Rue de l&#039;Industrie&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;user&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;name&quot;: &quot;Jean Dupont&quot;,
        &quot;email&quot;: &quot;jean.dupont@example.com&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-entrepots--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-entrepots--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-entrepots--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-entrepots--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-entrepots--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-entrepots--id-" data-method="GET"
      data-path="api/entrepots/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-entrepots--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-entrepots--id-"
                    onclick="tryItOut('GETapi-entrepots--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-entrepots--id-"
                    onclick="cancelTryOut('GETapi-entrepots--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-entrepots--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/entrepots/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-entrepots--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_user</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-entrepots--id-" style="display: none">
            <input type="radio" name="with_user"
                   value="1"
                   data-endpoint="GETapi-entrepots--id-"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-entrepots--id-" style="display: none">
            <input type="radio" name="with_user"
                   value="0"
                   data-endpoint="GETapi-entrepots--id-"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les informations du responsable. Example: <code>true</code></p>
            </div>
                </form>

                    <h2 id="entrepots-PUTapi-entrepots--id-">Mettre à jour un entrepôt</h2>

<p>
</p>

<p>Met à jour les informations d'un entrepôt existant. Le code ne peut pas être modifié.</p>

<span id="example-requests-PUTapi-entrepots--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Entrepôt Central\",
    \"adresse\": \"123 Rue de l\'Industrie\",
    \"is_active\": true,
    \"user_id\": \"550e8400-e29b-41d4-a716-446655440001\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Entrepôt Central",
    "adresse": "123 Rue de l'Industrie",
    "is_active": true,
    "user_id": "550e8400-e29b-41d4-a716-446655440001"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Entrepôt Central',
            'adresse' =&gt; '123 Rue de l\'Industrie',
            'is_active' =&gt; true,
            'user_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-entrepots--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT-ABC123&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central Mis &agrave; Jour&quot;,
    &quot;adresse&quot;: &quot;456 Nouvelle Adresse&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;user&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;name&quot;: &quot;Jean Dupont&quot;,
        &quot;email&quot;: &quot;jean.dupont@example.com&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-entrepots--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-entrepots--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-entrepots--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-entrepots--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-entrepots--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-entrepots--id-" data-method="PUT"
      data-path="api/entrepots/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-entrepots--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-entrepots--id-"
                    onclick="tryItOut('PUTapi-entrepots--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-entrepots--id-"
                    onclick="cancelTryOut('PUTapi-entrepots--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-entrepots--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/entrepots/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-entrepots--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-entrepots--id-"
               value="Entrepôt Central"
               data-component="body">
    <br>
<p>Nom de l'entrepôt. Example: <code>Entrepôt Central</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="PUTapi-entrepots--id-"
               value="123 Rue de l'Industrie"
               data-component="body">
    <br>
<p>Adresse de l'entrepôt. Example: <code>123 Rue de l'Industrie</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PUTapi-entrepots--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PUTapi-entrepots--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-entrepots--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PUTapi-entrepots--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="PUTapi-entrepots--id-"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="body">
    <br>
<p>UUID du responsable. Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
        </div>
        </form>

                    <h2 id="entrepots-PATCHapi-entrepots--id-">Mettre à jour un entrepôt</h2>

<p>
</p>

<p>Met à jour les informations d'un entrepôt existant. Le code ne peut pas être modifié.</p>

<span id="example-requests-PATCHapi-entrepots--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Entrepôt Central\",
    \"adresse\": \"123 Rue de l\'Industrie\",
    \"is_active\": true,
    \"user_id\": \"550e8400-e29b-41d4-a716-446655440001\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Entrepôt Central",
    "adresse": "123 Rue de l'Industrie",
    "is_active": true,
    "user_id": "550e8400-e29b-41d4-a716-446655440001"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Entrepôt Central',
            'adresse' =&gt; '123 Rue de l\'Industrie',
            'is_active' =&gt; true,
            'user_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-entrepots--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT-ABC123&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central Mis &agrave; Jour&quot;,
    &quot;adresse&quot;: &quot;456 Nouvelle Adresse&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;user&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;name&quot;: &quot;Jean Dupont&quot;,
        &quot;email&quot;: &quot;jean.dupont@example.com&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-entrepots--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-entrepots--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-entrepots--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-entrepots--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-entrepots--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-entrepots--id-" data-method="PATCH"
      data-path="api/entrepots/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-entrepots--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-entrepots--id-"
                    onclick="tryItOut('PATCHapi-entrepots--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-entrepots--id-"
                    onclick="cancelTryOut('PATCHapi-entrepots--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-entrepots--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/entrepots/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-entrepots--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-entrepots--id-"
               value="Entrepôt Central"
               data-component="body">
    <br>
<p>Nom de l'entrepôt. Example: <code>Entrepôt Central</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="PATCHapi-entrepots--id-"
               value="123 Rue de l'Industrie"
               data-component="body">
    <br>
<p>Adresse de l'entrepôt. Example: <code>123 Rue de l'Industrie</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PATCHapi-entrepots--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PATCHapi-entrepots--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PATCHapi-entrepots--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PATCHapi-entrepots--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="PATCHapi-entrepots--id-"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="body">
    <br>
<p>UUID du responsable. Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
        </div>
        </form>

                    <h2 id="entrepots-DELETEapi-entrepots--id-">Supprimer un entrepôt</h2>

<p>
</p>

<p>Supprime définitivement un entrepôt.</p>

<span id="example-requests-DELETEapi-entrepots--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-entrepots--id-">
            <blockquote>
            <p>Example response (204):</p>
        </blockquote>
                <pre>
<code>Empty response</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-entrepots--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-entrepots--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-entrepots--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-entrepots--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-entrepots--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-entrepots--id-" data-method="DELETE"
      data-path="api/entrepots/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-entrepots--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-entrepots--id-"
                    onclick="tryItOut('DELETEapi-entrepots--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-entrepots--id-"
                    onclick="cancelTryOut('DELETEapi-entrepots--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-entrepots--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/entrepots/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-entrepots--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-entrepots--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="entrepots-PATCHapi-entrepots--id--assign-user">Attribuer un responsable à un entrepôt</h2>

<p>
</p>

<p>Assigne un utilisateur comme responsable d'un entrepôt.</p>

<span id="example-requests-PATCHapi-entrepots--id--assign-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/assign-user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"user_id\": \"550e8400-e29b-41d4-a716-446655440001\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/assign-user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": "550e8400-e29b-41d4-a716-446655440001"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/assign-user';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'user_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-entrepots--id--assign-user">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT001&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central&quot;,
    &quot;adresse&quot;: &quot;123 Rue de l&#039;Industrie&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;user&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;name&quot;: &quot;Jean Dupont&quot;,
        &quot;email&quot;: &quot;jean.dupont@example.com&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Cet entrep&ocirc;t a d&eacute;j&agrave; un responsable attribu&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;,
    &quot;errors&quot;: {
        &quot;user_id&quot;: [
            &quot;L&#039;utilisateur s&eacute;lectionn&eacute; n&#039;existe pas.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-entrepots--id--assign-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-entrepots--id--assign-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-entrepots--id--assign-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-entrepots--id--assign-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-entrepots--id--assign-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-entrepots--id--assign-user" data-method="PATCH"
      data-path="api/entrepots/{id}/assign-user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-entrepots--id--assign-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-entrepots--id--assign-user"
                    onclick="tryItOut('PATCHapi-entrepots--id--assign-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-entrepots--id--assign-user"
                    onclick="cancelTryOut('PATCHapi-entrepots--id--assign-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-entrepots--id--assign-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/entrepots/{id}/assign-user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-entrepots--id--assign-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-entrepots--id--assign-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-entrepots--id--assign-user"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="PATCHapi-entrepots--id--assign-user"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="body">
    <br>
<p>UUID du responsable à attribuer. Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
        </div>
        </form>

                    <h2 id="entrepots-PATCHapi-entrepots--id--unassign-user">Désattribuer le responsable d&#039;un entrepôt</h2>

<p>
</p>

<p>Retire le responsable assigné à un entrepôt.</p>

<span id="example-requests-PATCHapi-entrepots--id--unassign-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/unassign-user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/unassign-user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/unassign-user';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-entrepots--id--unassign-user">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT001&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central&quot;,
    &quot;adresse&quot;: &quot;123 Rue de l&#039;Industrie&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: null,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;user&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Aucun responsable n&#039;est attribu&eacute; &agrave; cet entrep&ocirc;t.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-entrepots--id--unassign-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-entrepots--id--unassign-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-entrepots--id--unassign-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-entrepots--id--unassign-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-entrepots--id--unassign-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-entrepots--id--unassign-user" data-method="PATCH"
      data-path="api/entrepots/{id}/unassign-user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-entrepots--id--unassign-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-entrepots--id--unassign-user"
                    onclick="tryItOut('PATCHapi-entrepots--id--unassign-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-entrepots--id--unassign-user"
                    onclick="cancelTryOut('PATCHapi-entrepots--id--unassign-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-entrepots--id--unassign-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/entrepots/{id}/unassign-user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-entrepots--id--unassign-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-entrepots--id--unassign-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-entrepots--id--unassign-user"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="entrepots-PATCHapi-entrepots--id--change-user">Changer le responsable d&#039;un entrepôt</h2>

<p>
</p>

<p>Remplace le responsable actuel par un nouveau responsable.</p>

<span id="example-requests-PATCHapi-entrepots--id--change-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/change-user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"user_id\": \"550e8400-e29b-41d4-a716-446655440002\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/change-user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": "550e8400-e29b-41d4-a716-446655440002"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/entrepots/550e8400-e29b-41d4-a716-446655440000/change-user';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'user_id' =&gt; '550e8400-e29b-41d4-a716-446655440002',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-entrepots--id--change-user">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;ENT001&quot;,
    &quot;name&quot;: &quot;Entrep&ocirc;t Central&quot;,
    &quot;adresse&quot;: &quot;123 Rue de l&#039;Industrie&quot;,
    &quot;is_active&quot;: true,
    &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;user&quot;: {
        &quot;user_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
        &quot;name&quot;: &quot;Marie Martin&quot;,
        &quot;email&quot;: &quot;marie.martin@example.com&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Entrep&ocirc;t non trouv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;,
    &quot;errors&quot;: {
        &quot;user_id&quot;: [
            &quot;L&#039;utilisateur s&eacute;lectionn&eacute; n&#039;existe pas.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-entrepots--id--change-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-entrepots--id--change-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-entrepots--id--change-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-entrepots--id--change-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-entrepots--id--change-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-entrepots--id--change-user" data-method="PATCH"
      data-path="api/entrepots/{id}/change-user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-entrepots--id--change-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-entrepots--id--change-user"
                    onclick="tryItOut('PATCHapi-entrepots--id--change-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-entrepots--id--change-user"
                    onclick="cancelTryOut('PATCHapi-entrepots--id--change-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-entrepots--id--change-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/entrepots/{id}/change-user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-entrepots--id--change-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-entrepots--id--change-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-entrepots--id--change-user"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="PATCHapi-entrepots--id--change-user"
               value="550e8400-e29b-41d4-a716-446655440002"
               data-component="body">
    <br>
<p>UUID du nouveau responsable. Example: <code>550e8400-e29b-41d4-a716-446655440002</code></p>
        </div>
        </form>

                <h1 id="fournisseurs">Fournisseurs</h1>

    <p>APIs pour la gestion des fournisseurs</p>

                                <h2 id="fournisseurs-GETapi-fournisseurs">Liste des fournisseurs</h2>

<p>
</p>

<p>Récupère la liste paginée des fournisseurs avec possibilité de filtrage.</p>

<span id="example-requests-GETapi-fournisseurs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/fournisseurs?page=1&amp;per_page=15&amp;search=ACME&amp;city=Paris&amp;is_active=1&amp;sort_by=name&amp;sort_order=asc&amp;with_trashed=" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs"
);

const params = {
    "page": "1",
    "per_page": "15",
    "search": "ACME",
    "city": "Paris",
    "is_active": "1",
    "sort_by": "name",
    "sort_order": "asc",
    "with_trashed": "0",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'page' =&gt; '1',
            'per_page' =&gt; '15',
            'search' =&gt; 'ACME',
            'city' =&gt; 'Paris',
            'is_active' =&gt; '1',
            'sort_by' =&gt; 'name',
            'sort_order' =&gt; 'asc',
            'with_trashed' =&gt; '0',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-fournisseurs">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;fournisseur_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;code&quot;: &quot;FRN-ABC123&quot;,
            &quot;name&quot;: &quot;ACME Corporation&quot;,
            &quot;responsable&quot;: &quot;John Doe&quot;,
            &quot;adresse&quot;: &quot;123 Main Street&quot;,
            &quot;city&quot;: &quot;Paris&quot;,
            &quot;phone&quot;: &quot;+33123456789&quot;,
            &quot;email&quot;: &quot;contact@acme.com&quot;,
            &quot;payment_terms&quot;: &quot;30 jours&quot;,
            &quot;is_active&quot;: true,
            &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;deleted_at&quot;: null
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://api.example.com/fournisseurs?page=1&quot;,
        &quot;last&quot;: &quot;http://api.example.com/fournisseurs?page=10&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://api.example.com/fournisseurs?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 10,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 150
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-fournisseurs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-fournisseurs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-fournisseurs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-fournisseurs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-fournisseurs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-fournisseurs" data-method="GET"
      data-path="api/fournisseurs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-fournisseurs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-fournisseurs"
                    onclick="tryItOut('GETapi-fournisseurs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-fournisseurs"
                    onclick="cancelTryOut('GETapi-fournisseurs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-fournisseurs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/fournisseurs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-fournisseurs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-fournisseurs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-fournisseurs"
               value="1"
               data-component="query">
    <br>
<p>Numéro de la page. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-fournisseurs"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page (max 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-fournisseurs"
               value="ACME"
               data-component="query">
    <br>
<p>Recherche par nom, code ou email. Example: <code>ACME</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="GETapi-fournisseurs"
               value="Paris"
               data-component="query">
    <br>
<p>Filtrer par ville. Example: <code>Paris</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-fournisseurs" style="display: none">
            <input type="radio" name="is_active"
                   value="1"
                   data-endpoint="GETapi-fournisseurs"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-fournisseurs" style="display: none">
            <input type="radio" name="is_active"
                   value="0"
                   data-endpoint="GETapi-fournisseurs"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filtrer par statut actif (true/false). Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-fournisseurs"
               value="name"
               data-component="query">
    <br>
<p>Champ de tri (name, code, created_at). Example: <code>name</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_order"                data-endpoint="GETapi-fournisseurs"
               value="asc"
               data-component="query">
    <br>
<p>Ordre de tri (asc, desc). Example: <code>asc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_trashed</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-fournisseurs" style="display: none">
            <input type="radio" name="with_trashed"
                   value="1"
                   data-endpoint="GETapi-fournisseurs"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-fournisseurs" style="display: none">
            <input type="radio" name="with_trashed"
                   value="0"
                   data-endpoint="GETapi-fournisseurs"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure les fournisseurs supprimés. Example: <code>false</code></p>
            </div>
                </form>

                    <h2 id="fournisseurs-POSTapi-fournisseurs">Créer un fournisseur</h2>

<p>
</p>

<p>Crée un nouveau fournisseur dans le système.</p>

<span id="example-requests-POSTapi-fournisseurs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/fournisseurs" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"ACME Corporation\",
    \"responsable\": \"John Doe\",
    \"adresse\": \"123 Main Street\",
    \"city\": \"Paris\",
    \"phone\": \"+33123456789\",
    \"email\": \"contact@acme.com\",
    \"payment_terms\": \"30 jours\",
    \"is_active\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ACME Corporation",
    "responsable": "John Doe",
    "adresse": "123 Main Street",
    "city": "Paris",
    "phone": "+33123456789",
    "email": "contact@acme.com",
    "payment_terms": "30 jours",
    "is_active": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'ACME Corporation',
            'responsable' =&gt; 'John Doe',
            'adresse' =&gt; '123 Main Street',
            'city' =&gt; 'Paris',
            'phone' =&gt; '+33123456789',
            'email' =&gt; 'contact@acme.com',
            'payment_terms' =&gt; '30 jours',
            'is_active' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-fournisseurs">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;fournisseur_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;FRN-ABC123&quot;,
    &quot;name&quot;: &quot;ACME Corporation&quot;,
    &quot;responsable&quot;: &quot;John Doe&quot;,
    &quot;adresse&quot;: &quot;123 Main Street&quot;,
    &quot;city&quot;: &quot;Paris&quot;,
    &quot;phone&quot;: &quot;+33123456789&quot;,
    &quot;email&quot;: &quot;contact@acme.com&quot;,
    &quot;payment_terms&quot;: &quot;30 jours&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;deleted_at&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Le nom est obligatoire.&quot;
        ],
        &quot;email&quot;: [
            &quot;Cette adresse email est d&eacute;j&agrave; utilis&eacute;e.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-fournisseurs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-fournisseurs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-fournisseurs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-fournisseurs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-fournisseurs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-fournisseurs" data-method="POST"
      data-path="api/fournisseurs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-fournisseurs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-fournisseurs"
                    onclick="tryItOut('POSTapi-fournisseurs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-fournisseurs"
                    onclick="cancelTryOut('POSTapi-fournisseurs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-fournisseurs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/fournisseurs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-fournisseurs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-fournisseurs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-fournisseurs"
               value="ACME Corporation"
               data-component="body">
    <br>
<p>Nom du fournisseur. Example: <code>ACME Corporation</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>responsable</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="responsable"                data-endpoint="POSTapi-fournisseurs"
               value="John Doe"
               data-component="body">
    <br>
<p>Personne responsable. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="POSTapi-fournisseurs"
               value="123 Main Street"
               data-component="body">
    <br>
<p>Adresse du fournisseur. Example: <code>123 Main Street</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="POSTapi-fournisseurs"
               value="Paris"
               data-component="body">
    <br>
<p>Ville. Example: <code>Paris</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-fournisseurs"
               value="+33123456789"
               data-component="body">
    <br>
<p>Numéro de téléphone. Example: <code>+33123456789</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-fournisseurs"
               value="contact@acme.com"
               data-component="body">
    <br>
<p>Email (doit être unique). Example: <code>contact@acme.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_terms</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="payment_terms"                data-endpoint="POSTapi-fournisseurs"
               value="30 jours"
               data-component="body">
    <br>
<p>Conditions de paiement. Example: <code>30 jours</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-fournisseurs" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-fournisseurs"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-fournisseurs" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-fournisseurs"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif (par défaut: true). Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="fournisseurs-GETapi-fournisseurs--id-">Afficher un fournisseur</h2>

<p>
</p>

<p>Récupère les détails d'un fournisseur spécifique.</p>

<span id="example-requests-GETapi-fournisseurs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000?with_trashed=" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000"
);

const params = {
    "with_trashed": "0",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'with_trashed' =&gt; '0',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-fournisseurs--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;fournisseur_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;FRN-ABC123&quot;,
    &quot;name&quot;: &quot;ACME Corporation&quot;,
    &quot;responsable&quot;: &quot;John Doe&quot;,
    &quot;adresse&quot;: &quot;123 Main Street&quot;,
    &quot;city&quot;: &quot;Paris&quot;,
    &quot;phone&quot;: &quot;+33123456789&quot;,
    &quot;email&quot;: &quot;contact@acme.com&quot;,
    &quot;payment_terms&quot;: &quot;30 jours&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;deleted_at&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Fournisseur non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-fournisseurs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-fournisseurs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-fournisseurs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-fournisseurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-fournisseurs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-fournisseurs--id-" data-method="GET"
      data-path="api/fournisseurs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-fournisseurs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-fournisseurs--id-"
                    onclick="tryItOut('GETapi-fournisseurs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-fournisseurs--id-"
                    onclick="cancelTryOut('GETapi-fournisseurs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-fournisseurs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/fournisseurs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-fournisseurs--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du fournisseur. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>with_trashed</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-fournisseurs--id-" style="display: none">
            <input type="radio" name="with_trashed"
                   value="1"
                   data-endpoint="GETapi-fournisseurs--id-"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-fournisseurs--id-" style="display: none">
            <input type="radio" name="with_trashed"
                   value="0"
                   data-endpoint="GETapi-fournisseurs--id-"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Inclure même si supprimé. Example: <code>false</code></p>
            </div>
                </form>

                    <h2 id="fournisseurs-PUTapi-fournisseurs--id-">Mettre à jour un fournisseur</h2>

<p>
</p>

<p>Met à jour les informations d'un fournisseur existant.</p>

<span id="example-requests-PUTapi-fournisseurs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"ACME Corporation\",
    \"responsable\": \"John Doe\",
    \"adresse\": \"123 Main Street\",
    \"city\": \"Paris\",
    \"phone\": \"+33123456789\",
    \"email\": \"contact@acme.com\",
    \"payment_terms\": \"30 jours\",
    \"is_active\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ACME Corporation",
    "responsable": "John Doe",
    "adresse": "123 Main Street",
    "city": "Paris",
    "phone": "+33123456789",
    "email": "contact@acme.com",
    "payment_terms": "30 jours",
    "is_active": true
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'ACME Corporation',
            'responsable' =&gt; 'John Doe',
            'adresse' =&gt; '123 Main Street',
            'city' =&gt; 'Paris',
            'phone' =&gt; '+33123456789',
            'email' =&gt; 'contact@acme.com',
            'payment_terms' =&gt; '30 jours',
            'is_active' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-fournisseurs--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;fournisseur_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;FRN-ABC123&quot;,
    &quot;name&quot;: &quot;ACME Corporation Updated&quot;,
    &quot;responsable&quot;: &quot;Jane Doe&quot;,
    &quot;adresse&quot;: &quot;456 New Street&quot;,
    &quot;city&quot;: &quot;Lyon&quot;,
    &quot;phone&quot;: &quot;+33987654321&quot;,
    &quot;email&quot;: &quot;contact@acme.com&quot;,
    &quot;payment_terms&quot;: &quot;45 jours&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;deleted_at&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Fournisseur non trouv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;Cette adresse email est d&eacute;j&agrave; utilis&eacute;e.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-fournisseurs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-fournisseurs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-fournisseurs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-fournisseurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-fournisseurs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-fournisseurs--id-" data-method="PUT"
      data-path="api/fournisseurs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-fournisseurs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-fournisseurs--id-"
                    onclick="tryItOut('PUTapi-fournisseurs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-fournisseurs--id-"
                    onclick="cancelTryOut('PUTapi-fournisseurs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-fournisseurs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/fournisseurs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-fournisseurs--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du fournisseur. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-fournisseurs--id-"
               value="ACME Corporation"
               data-component="body">
    <br>
<p>Nom du fournisseur. Example: <code>ACME Corporation</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>responsable</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="responsable"                data-endpoint="PUTapi-fournisseurs--id-"
               value="John Doe"
               data-component="body">
    <br>
<p>Personne responsable. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="PUTapi-fournisseurs--id-"
               value="123 Main Street"
               data-component="body">
    <br>
<p>Adresse du fournisseur. Example: <code>123 Main Street</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="PUTapi-fournisseurs--id-"
               value="Paris"
               data-component="body">
    <br>
<p>Ville. Example: <code>Paris</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PUTapi-fournisseurs--id-"
               value="+33123456789"
               data-component="body">
    <br>
<p>Numéro de téléphone. Example: <code>+33123456789</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PUTapi-fournisseurs--id-"
               value="contact@acme.com"
               data-component="body">
    <br>
<p>Email (doit être unique). Example: <code>contact@acme.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_terms</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="payment_terms"                data-endpoint="PUTapi-fournisseurs--id-"
               value="30 jours"
               data-component="body">
    <br>
<p>Conditions de paiement. Example: <code>30 jours</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PUTapi-fournisseurs--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PUTapi-fournisseurs--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-fournisseurs--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PUTapi-fournisseurs--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif. Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="fournisseurs-PATCHapi-fournisseurs--id-">Mettre à jour un fournisseur</h2>

<p>
</p>

<p>Met à jour les informations d'un fournisseur existant.</p>

<span id="example-requests-PATCHapi-fournisseurs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"ACME Corporation\",
    \"responsable\": \"John Doe\",
    \"adresse\": \"123 Main Street\",
    \"city\": \"Paris\",
    \"phone\": \"+33123456789\",
    \"email\": \"contact@acme.com\",
    \"payment_terms\": \"30 jours\",
    \"is_active\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "ACME Corporation",
    "responsable": "John Doe",
    "adresse": "123 Main Street",
    "city": "Paris",
    "phone": "+33123456789",
    "email": "contact@acme.com",
    "payment_terms": "30 jours",
    "is_active": true
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'ACME Corporation',
            'responsable' =&gt; 'John Doe',
            'adresse' =&gt; '123 Main Street',
            'city' =&gt; 'Paris',
            'phone' =&gt; '+33123456789',
            'email' =&gt; 'contact@acme.com',
            'payment_terms' =&gt; '30 jours',
            'is_active' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-fournisseurs--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;fournisseur_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;FRN-ABC123&quot;,
    &quot;name&quot;: &quot;ACME Corporation Updated&quot;,
    &quot;responsable&quot;: &quot;Jane Doe&quot;,
    &quot;adresse&quot;: &quot;456 New Street&quot;,
    &quot;city&quot;: &quot;Lyon&quot;,
    &quot;phone&quot;: &quot;+33987654321&quot;,
    &quot;email&quot;: &quot;contact@acme.com&quot;,
    &quot;payment_terms&quot;: &quot;45 jours&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;deleted_at&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Fournisseur non trouv&eacute;.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es fournies ne sont pas valides.&quot;,
    &quot;errors&quot;: {
        &quot;email&quot;: [
            &quot;Cette adresse email est d&eacute;j&agrave; utilis&eacute;e.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-fournisseurs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-fournisseurs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-fournisseurs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-fournisseurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-fournisseurs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-fournisseurs--id-" data-method="PATCH"
      data-path="api/fournisseurs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-fournisseurs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-fournisseurs--id-"
                    onclick="tryItOut('PATCHapi-fournisseurs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-fournisseurs--id-"
                    onclick="cancelTryOut('PATCHapi-fournisseurs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-fournisseurs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/fournisseurs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du fournisseur. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="ACME Corporation"
               data-component="body">
    <br>
<p>Nom du fournisseur. Example: <code>ACME Corporation</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>responsable</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="responsable"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="John Doe"
               data-component="body">
    <br>
<p>Personne responsable. Example: <code>John Doe</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adresse</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="adresse"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="123 Main Street"
               data-component="body">
    <br>
<p>Adresse du fournisseur. Example: <code>123 Main Street</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="Paris"
               data-component="body">
    <br>
<p>Ville. Example: <code>Paris</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="+33123456789"
               data-component="body">
    <br>
<p>Numéro de téléphone. Example: <code>+33123456789</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="contact@acme.com"
               data-component="body">
    <br>
<p>Email (doit être unique). Example: <code>contact@acme.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>payment_terms</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="payment_terms"                data-endpoint="PATCHapi-fournisseurs--id-"
               value="30 jours"
               data-component="body">
    <br>
<p>Conditions de paiement. Example: <code>30 jours</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PATCHapi-fournisseurs--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PATCHapi-fournisseurs--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PATCHapi-fournisseurs--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PATCHapi-fournisseurs--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif. Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="fournisseurs-DELETEapi-fournisseurs--id-">Supprimer un fournisseur</h2>

<p>
</p>

<p>Supprime définitivement un fournisseur (soft delete).</p>

<span id="example-requests-DELETEapi-fournisseurs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-fournisseurs--id-">
            <blockquote>
            <p>Example response (204):</p>
        </blockquote>
                <pre>
<code>Empty response</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Fournisseur non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-fournisseurs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-fournisseurs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-fournisseurs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-fournisseurs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-fournisseurs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-fournisseurs--id-" data-method="DELETE"
      data-path="api/fournisseurs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-fournisseurs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-fournisseurs--id-"
                    onclick="tryItOut('DELETEapi-fournisseurs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-fournisseurs--id-"
                    onclick="cancelTryOut('DELETEapi-fournisseurs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-fournisseurs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/fournisseurs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-fournisseurs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-fournisseurs--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du fournisseur. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="fournisseurs-PATCHapi-fournisseurs--id--restore">Restaurer un fournisseur</h2>

<p>
</p>

<p>Restaure un fournisseur précédemment supprimé.</p>

<span id="example-requests-PATCHapi-fournisseurs--id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000/restore"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000/restore';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-fournisseurs--id--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;fournisseur_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
    &quot;code&quot;: &quot;FRN-ABC123&quot;,
    &quot;name&quot;: &quot;ACME Corporation&quot;,
    &quot;responsable&quot;: &quot;John Doe&quot;,
    &quot;adresse&quot;: &quot;123 Main Street&quot;,
    &quot;city&quot;: &quot;Paris&quot;,
    &quot;phone&quot;: &quot;+33123456789&quot;,
    &quot;email&quot;: &quot;contact@acme.com&quot;,
    &quot;payment_terms&quot;: &quot;30 jours&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2023-01-02T00:00:00.000000Z&quot;,
    &quot;deleted_at&quot;: null
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Fournisseur non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-fournisseurs--id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-fournisseurs--id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-fournisseurs--id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-fournisseurs--id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-fournisseurs--id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-fournisseurs--id--restore" data-method="PATCH"
      data-path="api/fournisseurs/{id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-fournisseurs--id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-fournisseurs--id--restore"
                    onclick="tryItOut('PATCHapi-fournisseurs--id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-fournisseurs--id--restore"
                    onclick="cancelTryOut('PATCHapi-fournisseurs--id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-fournisseurs--id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/fournisseurs/{id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-fournisseurs--id--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-fournisseurs--id--restore"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-fournisseurs--id--restore"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du fournisseur. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="fournisseurs-DELETEapi-fournisseurs--id--force">Suppression définitive</h2>

<p>
</p>

<p>Supprime définitivement un fournisseur de la base de données.</p>

<span id="example-requests-DELETEapi-fournisseurs--id--force">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000/force" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000/force"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/fournisseurs/550e8400-e29b-41d4-a716-446655440000/force';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-DELETEapi-fournisseurs--id--force">
            <blockquote>
            <p>Example response (204):</p>
        </blockquote>
                <pre>
<code>Empty response</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Fournisseur non trouv&eacute;.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-fournisseurs--id--force" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-fournisseurs--id--force"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-fournisseurs--id--force"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-fournisseurs--id--force" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-fournisseurs--id--force">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-fournisseurs--id--force" data-method="DELETE"
      data-path="api/fournisseurs/{id}/force"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-fournisseurs--id--force', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-fournisseurs--id--force"
                    onclick="tryItOut('DELETEapi-fournisseurs--id--force');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-fournisseurs--id--force"
                    onclick="cancelTryOut('DELETEapi-fournisseurs--id--force');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-fournisseurs--id--force"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/fournisseurs/{id}/force</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-fournisseurs--id--force"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-fournisseurs--id--force"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-fournisseurs--id--force"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du fournisseur. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                            </div>
            </div>
</div>
</body>
</html>
