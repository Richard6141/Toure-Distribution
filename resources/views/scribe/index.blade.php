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
                    <ul id="tocify-header-stock-movement-types" class="tocify-header">
                <li class="tocify-item level-1" data-unique="stock-movement-types">
                    <a href="#stock-movement-types">Stock Movement Types</a>
                </li>
                                    <ul id="tocify-subheader-stock-movement-types" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="stock-movement-types-GETapi-stock-movement-types">
                                <a href="#stock-movement-types-GETapi-stock-movement-types">Récupère la liste des types de mouvements de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-POSTapi-stock-movement-types">
                                <a href="#stock-movement-types-POSTapi-stock-movement-types">Crée un nouveau type de mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-GETapi-stock-movement-types--id-">
                                <a href="#stock-movement-types-GETapi-stock-movement-types--id-">Récupère un type de mouvement de stock spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-PUTapi-stock-movement-types--id-">
                                <a href="#stock-movement-types-PUTapi-stock-movement-types--id-">Met à jour un type de mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-PATCHapi-stock-movement-types--id-">
                                <a href="#stock-movement-types-PATCHapi-stock-movement-types--id-">Met à jour un type de mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-DELETEapi-stock-movement-types--id-">
                                <a href="#stock-movement-types-DELETEapi-stock-movement-types--id-">Supprime un type de mouvement de stock (soft delete)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-GETapi-stock-movement-types-trashed-list">
                                <a href="#stock-movement-types-GETapi-stock-movement-types-trashed-list">Récupère la liste des types de mouvements de stock supprimés</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-types-POSTapi-stock-movement-types--id--restore">
                                <a href="#stock-movement-types-POSTapi-stock-movement-types--id--restore">Restaure un type de mouvement de stock supprimé</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-stock-movements" class="tocify-header">
                <li class="tocify-item level-1" data-unique="stock-movements">
                    <a href="#stock-movements">Stock Movements</a>
                </li>
                                    <ul id="tocify-subheader-stock-movements" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="stock-movements-GETapi-stock-movements">
                                <a href="#stock-movements-GETapi-stock-movements">Récupère la liste des mouvements de stock avec leurs détails</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movements-POSTapi-stock-movements">
                                <a href="#stock-movements-POSTapi-stock-movements">Crée un nouveau mouvement de stock avec ses détails</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movements-PATCHapi-stock-movements--id--update-status">
                                <a href="#stock-movements-PATCHapi-stock-movements--id--update-status">Met à jour le statut d'un mouvement de stock</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-stock-movement-details" class="tocify-header">
                <li class="tocify-item level-1" data-unique="stock-movement-details">
                    <a href="#stock-movement-details">Stock Movement Details</a>
                </li>
                                    <ul id="tocify-subheader-stock-movement-details" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="stock-movement-details-GETapi-stock-movement-details">
                                <a href="#stock-movement-details-GETapi-stock-movement-details">Récupère la liste des détails de mouvements de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-details-POSTapi-stock-movement-details">
                                <a href="#stock-movement-details-POSTapi-stock-movement-details">Crée un nouveau détail de mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-details-GETapi-stock-movement-details-stock-movement--stockMovementId-">
                                <a href="#stock-movement-details-GETapi-stock-movement-details-stock-movement--stockMovementId-">Récupère tous les détails d'un mouvement de stock spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stock-movement-details-GETapi-stock-movement-details-product--productId-">
                                <a href="#stock-movement-details-GETapi-stock-movement-details-product--productId-">Récupère tous les détails de mouvements pour un produit spécifique</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-produits" class="tocify-header">
                <li class="tocify-item level-1" data-unique="produits">
                    <a href="#produits">Produits</a>
                </li>
                                    <ul id="tocify-subheader-produits" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="produits-GETapi-products">
                                <a href="#produits-GETapi-products">Lister tous les produits</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-POSTapi-products">
                                <a href="#produits-POSTapi-products">Créer un nouveau produit</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-GETapi-products--id-">
                                <a href="#produits-GETapi-products--id-">Afficher un produit par ID</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-PUTapi-products--id-">
                                <a href="#produits-PUTapi-products--id-">Mettre à jour un produit</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-DELETEapi-products--id-">
                                <a href="#produits-DELETEapi-products--id-">Supprimer un produit (soft delete)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-GETapi-products-category--categoryId-">
                                <a href="#produits-GETapi-products-category--categoryId-">Lister les produits par catégorie</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-GETapi-products--id--restore">
                                <a href="#produits-GETapi-products--id--restore">Restaurer un produit supprimé</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="produits-DELETEapi-products--id--force">
                                <a href="#produits-DELETEapi-products--id--force">Supprimer définitivement un produit</a>
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
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-stock-movements--id-">
                                <a href="#endpoints-GETapi-stock-movements--id-">Afficher un mouvement de stock spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-stock-movements--id-">
                                <a href="#endpoints-PUTapi-stock-movements--id-">Mettre à jour un mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PATCHapi-stock-movements--id-">
                                <a href="#endpoints-PATCHapi-stock-movements--id-">Mettre à jour un mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-stock-movements--id-">
                                <a href="#endpoints-DELETEapi-stock-movements--id-">Supprimer un mouvement de stock (soft delete)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-stock-movements-trashed-list">
                                <a href="#endpoints-GETapi-stock-movements-trashed-list">Lister les mouvements de stock supprimés</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-stock-movements--id--restore">
                                <a href="#endpoints-POSTapi-stock-movements--id--restore">Restaurer un mouvement de stock supprimé</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-stock-movement-details--id-">
                                <a href="#endpoints-GETapi-stock-movement-details--id-">Afficher un détail de mouvement de stock spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-stock-movement-details--id-">
                                <a href="#endpoints-PUTapi-stock-movement-details--id-">Mettre à jour un détail de mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PATCHapi-stock-movement-details--id-">
                                <a href="#endpoints-PATCHapi-stock-movement-details--id-">Mettre à jour un détail de mouvement de stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-stock-movement-details--id-">
                                <a href="#endpoints-DELETEapi-stock-movement-details--id-">Supprimer un détail de mouvement de stock (soft delete)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-stock-movement-details-trashed-list">
                                <a href="#endpoints-GETapi-stock-movement-details-trashed-list">Lister les détails de mouvements de stock supprimés</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-stock-movement-details--id--restore">
                                <a href="#endpoints-POSTapi-stock-movement-details--id--restore">Restaurer un détail de mouvement de stock supprimé</a>
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
                                                    <li class="tocify-item level-2" data-unique="clients-management-GETapi-clients-trashed-list">
                                <a href="#clients-management-GETapi-clients-trashed-list">Lister les clients supprimés</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-GETapi-clients-statistics-overview">
                                <a href="#clients-management-GETapi-clients-statistics-overview">Statistiques des clients</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-POSTapi-clients-search">
                                <a href="#clients-management-POSTapi-clients-search">Rechercher des clients</a>
                            </li>
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
                                                                                <li class="tocify-item level-2" data-unique="clients-management-POSTapi-clients--client_id--restore">
                                <a href="#clients-management-POSTapi-clients--client_id--restore">Restaurer un client supprimé</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-PATCHapi-clients--client_id--toggle-status">
                                <a href="#clients-management-PATCHapi-clients--client_id--toggle-status">Activer/Désactiver un client</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-management-PATCHapi-clients--client_id--update-balance">
                                <a href="#clients-management-PATCHapi-clients--client_id--update-balance">Mettre à jour le solde d'un client</a>
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
                    <ul id="tocify-header-gestion-des-stocks" class="tocify-header">
                <li class="tocify-item level-1" data-unique="gestion-des-stocks">
                    <a href="#gestion-des-stocks">Gestion des Stocks</a>
                </li>
                                    <ul id="tocify-subheader-gestion-des-stocks" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="gestion-des-stocks-GETapi-stocks">
                                <a href="#gestion-des-stocks-GETapi-stocks">Lister tous les stocks</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-POSTapi-stocks">
                                <a href="#gestion-des-stocks-POSTapi-stocks">Créer un nouveau stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-GETapi-stocks--id-">
                                <a href="#gestion-des-stocks-GETapi-stocks--id-">Afficher un stock spécifique</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-PUTapi-stocks--id-">
                                <a href="#gestion-des-stocks-PUTapi-stocks--id-">Mettre à jour un stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-DELETEapi-stocks--id-">
                                <a href="#gestion-des-stocks-DELETEapi-stocks--id-">Supprimer un stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-POSTapi-stocks--id--adjust">
                                <a href="#gestion-des-stocks-POSTapi-stocks--id--adjust">Ajuster la quantité en stock</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-POSTapi-stocks--id--reserve">
                                <a href="#gestion-des-stocks-POSTapi-stocks--id--reserve">Réserver une quantité</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-POSTapi-stocks--id--release">
                                <a href="#gestion-des-stocks-POSTapi-stocks--id--release">Libérer une réservation</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-GETapi-stocks-product--productId-">
                                <a href="#gestion-des-stocks-GETapi-stocks-product--productId-">Stocks par produit</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-GETapi-stocks-entrepot--entrepotId-">
                                <a href="#gestion-des-stocks-GETapi-stocks-entrepot--entrepotId-">Stocks par entrepôt</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-GETapi-stocks--id--restore">
                                <a href="#gestion-des-stocks-GETapi-stocks--id--restore">Restaurer un stock supprimé</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="gestion-des-stocks-DELETEapi-stocks--id--force">
                                <a href="#gestion-des-stocks-DELETEapi-stocks--id--force">Suppression définitive d'un stock</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-product-categories" class="tocify-header">
                <li class="tocify-item level-1" data-unique="product-categories">
                    <a href="#product-categories">Product Categories</a>
                </li>
                                    <ul id="tocify-subheader-product-categories" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="product-categories-GETapi-product-categories">
                                <a href="#product-categories-GETapi-product-categories">Afficher toutes les catégories de produits</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="product-categories-POSTapi-product-categories">
                                <a href="#product-categories-POSTapi-product-categories">Créer une nouvelle catégorie de produit</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="product-categories-GETapi-product-categories--id-">
                                <a href="#product-categories-GETapi-product-categories--id-">Afficher une catégorie de produit</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="product-categories-PUTapi-product-categories--id-">
                                <a href="#product-categories-PUTapi-product-categories--id-">Mettre à jour une catégorie de produit</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="product-categories-DELETEapi-product-categories--id-">
                                <a href="#product-categories-DELETEapi-product-categories--id-">Supprimer une catégorie de produit</a>
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
        <li>Dernière mise à jour: 9 October 2025</li>
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

                <h1 id="stock-movement-types">Stock Movement Types</h1>

    

                                <h2 id="stock-movement-types-GETapi-stock-movement-types">Récupère la liste des types de mouvements de stock</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-types?direction=in&amp;search=R%C3%A9ception&amp;sort_by=created_at&amp;sort_order=desc&amp;per_page=15" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types"
);

const params = {
    "direction": "in",
    "search": "Réception",
    "sort_by": "created_at",
    "sort_order": "desc",
    "per_page": "15",
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
$url = 'http://localhost/api/stock-movement-types';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'direction' =&gt; 'in',
            'search' =&gt; 'Réception',
            'sort_by' =&gt; 'created_at',
            'sort_order' =&gt; 'desc',
            'per_page' =&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-stock-movement-types">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
                &quot;name&quot;: &quot;R&eacute;ception&quot;,
                &quot;direction&quot;: &quot;in&quot;,
                &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;stock_movements_count&quot;: 5
            }
        ],
        &quot;current_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    },
    &quot;message&quot;: &quot;Types de mouvements de stock r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur lors de la r&eacute;cup&eacute;ration des types de mouvements de stock&quot;,
    &quot;error&quot;: &quot;Message d&#039;erreur&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-types"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-types">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-types" data-method="GET"
      data-path="api/stock-movement-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-types"
                    onclick="tryItOut('GETapi-stock-movement-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-types"
                    onclick="cancelTryOut('GETapi-stock-movement-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-types"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-types</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-types"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="direction"                data-endpoint="GETapi-stock-movement-types"
               value="in"
               data-component="query">
    <br>
<p>Filtrer par direction (in, out, transfer). Example: <code>in</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-stock-movement-types"
               value="Réception"
               data-component="query">
    <br>
<p>Rechercher par nom. Example: <code>Réception</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-stock-movement-types"
               value="created_at"
               data-component="query">
    <br>
<p>Champ de tri. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_order"                data-endpoint="GETapi-stock-movement-types"
               value="desc"
               data-component="query">
    <br>
<p>Ordre de tri (asc, desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-stock-movement-types"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page. Example: <code>15</code></p>
            </div>
                </form>

                    <h2 id="stock-movement-types-POSTapi-stock-movement-types">Crée un nouveau type de mouvement de stock</h2>

<p>
</p>



<span id="example-requests-POSTapi-stock-movement-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stock-movement-types" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Réception\",
    \"direction\": \"in\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Réception",
    "direction": "in"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movement-types';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Réception',
            'direction' =&gt; 'in',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stock-movement-types">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
        &quot;name&quot;: &quot;R&eacute;ception&quot;,
        &quot;direction&quot;: &quot;in&quot;,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;
    },
    &quot;message&quot;: &quot;Type de mouvement de stock cr&eacute;&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Le nom du type de mouvement est obligatoire.&quot;
        ],
        &quot;direction&quot;: [
            &quot;La direction est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stock-movement-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stock-movement-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stock-movement-types"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stock-movement-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stock-movement-types">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stock-movement-types" data-method="POST"
      data-path="api/stock-movement-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stock-movement-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stock-movement-types"
                    onclick="tryItOut('POSTapi-stock-movement-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stock-movement-types"
                    onclick="cancelTryOut('POSTapi-stock-movement-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stock-movement-types"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stock-movement-types</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stock-movement-types"
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
                              name="Accept"                data-endpoint="POSTapi-stock-movement-types"
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
                              name="name"                data-endpoint="POSTapi-stock-movement-types"
               value="Réception"
               data-component="body">
    <br>
<p>Nom du type de mouvement. Example: <code>Réception</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="direction"                data-endpoint="POSTapi-stock-movement-types"
               value="in"
               data-component="body">
    <br>
<p>Direction du mouvement (in, out, transfer). Example: <code>in</code></p>
        </div>
        </form>

                    <h2 id="stock-movement-types-GETapi-stock-movement-types--id-">Récupère un type de mouvement de stock spécifique</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-types--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-types/uuid" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types/uuid"
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
$url = 'http://localhost/api/stock-movement-types/uuid';
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

<span id="example-responses-GETapi-stock-movement-types--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
        &quot;name&quot;: &quot;R&eacute;ception&quot;,
        &quot;direction&quot;: &quot;in&quot;,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;stock_movements_count&quot;: 5
    },
    &quot;message&quot;: &quot;Type de mouvement de stock r&eacute;cup&eacute;r&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Type de mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-types--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-types--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-types--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-types--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-types--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-types--id-" data-method="GET"
      data-path="api/stock-movement-types/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-types--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-types--id-"
                    onclick="tryItOut('GETapi-stock-movement-types--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-types--id-"
                    onclick="cancelTryOut('GETapi-stock-movement-types--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-types--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-types/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-types--id-"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-types--id-"
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
                              name="id"                data-endpoint="GETapi-stock-movement-types--id-"
               value="uuid"
               data-component="url">
    <br>
<p>ID du type de mouvement de stock. Example: <code>uuid</code></p>
            </div>
                    </form>

                    <h2 id="stock-movement-types-PUTapi-stock-movement-types--id-">Met à jour un type de mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PUTapi-stock-movement-types--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/stock-movement-types/uuid" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Réception\",
    \"direction\": \"in\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types/uuid"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Réception",
    "direction": "in"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movement-types/uuid';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Réception',
            'direction' =&gt; 'in',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-stock-movement-types--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
        &quot;name&quot;: &quot;R&eacute;ception&quot;,
        &quot;direction&quot;: &quot;in&quot;,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;
    },
    &quot;message&quot;: &quot;Type de mouvement de stock mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Type de mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Le nom du type de mouvement est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-stock-movement-types--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-stock-movement-types--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-stock-movement-types--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-stock-movement-types--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-stock-movement-types--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-stock-movement-types--id-" data-method="PUT"
      data-path="api/stock-movement-types/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-stock-movement-types--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-stock-movement-types--id-"
                    onclick="tryItOut('PUTapi-stock-movement-types--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-stock-movement-types--id-"
                    onclick="cancelTryOut('PUTapi-stock-movement-types--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-stock-movement-types--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/stock-movement-types/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-stock-movement-types--id-"
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
                              name="Accept"                data-endpoint="PUTapi-stock-movement-types--id-"
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
                              name="id"                data-endpoint="PUTapi-stock-movement-types--id-"
               value="uuid"
               data-component="url">
    <br>
<p>ID du type de mouvement de stock. Example: <code>uuid</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-stock-movement-types--id-"
               value="Réception"
               data-component="body">
    <br>
<p>Nom du type de mouvement. Example: <code>Réception</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="direction"                data-endpoint="PUTapi-stock-movement-types--id-"
               value="in"
               data-component="body">
    <br>
<p>Direction du mouvement (in, out, transfer). Example: <code>in</code></p>
        </div>
        </form>

                    <h2 id="stock-movement-types-PATCHapi-stock-movement-types--id-">Met à jour un type de mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PATCHapi-stock-movement-types--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/stock-movement-types/uuid" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Réception\",
    \"direction\": \"in\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types/uuid"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Réception",
    "direction": "in"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movement-types/uuid';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'Réception',
            'direction' =&gt; 'in',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-stock-movement-types--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
        &quot;name&quot;: &quot;R&eacute;ception&quot;,
        &quot;direction&quot;: &quot;in&quot;,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;
    },
    &quot;message&quot;: &quot;Type de mouvement de stock mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Type de mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Le nom du type de mouvement est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-stock-movement-types--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-stock-movement-types--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-stock-movement-types--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-stock-movement-types--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-stock-movement-types--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-stock-movement-types--id-" data-method="PATCH"
      data-path="api/stock-movement-types/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-stock-movement-types--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-stock-movement-types--id-"
                    onclick="tryItOut('PATCHapi-stock-movement-types--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-stock-movement-types--id-"
                    onclick="cancelTryOut('PATCHapi-stock-movement-types--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-stock-movement-types--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/stock-movement-types/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-stock-movement-types--id-"
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
                              name="Accept"                data-endpoint="PATCHapi-stock-movement-types--id-"
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
                              name="id"                data-endpoint="PATCHapi-stock-movement-types--id-"
               value="uuid"
               data-component="url">
    <br>
<p>ID du type de mouvement de stock. Example: <code>uuid</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-stock-movement-types--id-"
               value="Réception"
               data-component="body">
    <br>
<p>Nom du type de mouvement. Example: <code>Réception</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="direction"                data-endpoint="PATCHapi-stock-movement-types--id-"
               value="in"
               data-component="body">
    <br>
<p>Direction du mouvement (in, out, transfer). Example: <code>in</code></p>
        </div>
        </form>

                    <h2 id="stock-movement-types-DELETEapi-stock-movement-types--id-">Supprime un type de mouvement de stock (soft delete)</h2>

<p>
</p>



<span id="example-requests-DELETEapi-stock-movement-types--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/stock-movement-types/uuid" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types/uuid"
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
$url = 'http://localhost/api/stock-movement-types/uuid';
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

<span id="example-responses-DELETEapi-stock-movement-types--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Type de mouvement de stock supprim&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Type de mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-stock-movement-types--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-stock-movement-types--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-stock-movement-types--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-stock-movement-types--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-stock-movement-types--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-stock-movement-types--id-" data-method="DELETE"
      data-path="api/stock-movement-types/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-stock-movement-types--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-stock-movement-types--id-"
                    onclick="tryItOut('DELETEapi-stock-movement-types--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-stock-movement-types--id-"
                    onclick="cancelTryOut('DELETEapi-stock-movement-types--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-stock-movement-types--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/stock-movement-types/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-stock-movement-types--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-stock-movement-types--id-"
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
                              name="id"                data-endpoint="DELETEapi-stock-movement-types--id-"
               value="uuid"
               data-component="url">
    <br>
<p>ID du type de mouvement de stock. Example: <code>uuid</code></p>
            </div>
                    </form>

                    <h2 id="stock-movement-types-GETapi-stock-movement-types-trashed-list">Récupère la liste des types de mouvements de stock supprimés</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-types-trashed-list">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-types/trashed/list" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types/trashed/list"
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
$url = 'http://localhost/api/stock-movement-types/trashed/list';
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

<span id="example-responses-GETapi-stock-movement-types-trashed-list">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
                &quot;name&quot;: &quot;R&eacute;ception&quot;,
                &quot;direction&quot;: &quot;in&quot;,
                &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;deleted_at&quot;: &quot;2024-01-01 12:00:00&quot;
            }
        ],
        &quot;current_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    },
    &quot;message&quot;: &quot;Types de mouvements de stock supprim&eacute;s r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-types-trashed-list" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-types-trashed-list"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-types-trashed-list"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-types-trashed-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-types-trashed-list">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-types-trashed-list" data-method="GET"
      data-path="api/stock-movement-types/trashed/list"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-types-trashed-list', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-types-trashed-list"
                    onclick="tryItOut('GETapi-stock-movement-types-trashed-list');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-types-trashed-list"
                    onclick="cancelTryOut('GETapi-stock-movement-types-trashed-list');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-types-trashed-list"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-types/trashed/list</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-types-trashed-list"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-types-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="stock-movement-types-POSTapi-stock-movement-types--id--restore">Restaure un type de mouvement de stock supprimé</h2>

<p>
</p>



<span id="example-requests-POSTapi-stock-movement-types--id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stock-movement-types/uuid/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-types/uuid/restore"
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
$url = 'http://localhost/api/stock-movement-types/uuid/restore';
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

<span id="example-responses-POSTapi-stock-movement-types--id--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
        &quot;name&quot;: &quot;R&eacute;ception&quot;,
        &quot;direction&quot;: &quot;in&quot;,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;
    },
    &quot;message&quot;: &quot;Type de mouvement de stock restaur&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Ce type de mouvement de stock n&#039;est pas supprim&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Type de mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stock-movement-types--id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stock-movement-types--id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stock-movement-types--id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stock-movement-types--id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stock-movement-types--id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stock-movement-types--id--restore" data-method="POST"
      data-path="api/stock-movement-types/{id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stock-movement-types--id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stock-movement-types--id--restore"
                    onclick="tryItOut('POSTapi-stock-movement-types--id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stock-movement-types--id--restore"
                    onclick="cancelTryOut('POSTapi-stock-movement-types--id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stock-movement-types--id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stock-movement-types/{id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stock-movement-types--id--restore"
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
                              name="Accept"                data-endpoint="POSTapi-stock-movement-types--id--restore"
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
                              name="id"                data-endpoint="POSTapi-stock-movement-types--id--restore"
               value="uuid"
               data-component="url">
    <br>
<p>ID du type de mouvement de stock. Example: <code>uuid</code></p>
            </div>
                    </form>

                <h1 id="stock-movements">Stock Movements</h1>

    

                                <h2 id="stock-movements-GETapi-stock-movements">Récupère la liste des mouvements de stock avec leurs détails</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movements?movement_type_id=uuid&amp;statut=pending&amp;entrepot_from_id=uuid&amp;entrepot_to_id=uuid&amp;client_id=uuid&amp;fournisseur_id=uuid&amp;search=MV-2024-001&amp;date_from=2024-01-01&amp;date_to=2024-12-31&amp;sort_by=created_at&amp;sort_order=desc&amp;per_page=15" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements"
);

const params = {
    "movement_type_id": "uuid",
    "statut": "pending",
    "entrepot_from_id": "uuid",
    "entrepot_to_id": "uuid",
    "client_id": "uuid",
    "fournisseur_id": "uuid",
    "search": "MV-2024-001",
    "date_from": "2024-01-01",
    "date_to": "2024-12-31",
    "sort_by": "created_at",
    "sort_order": "desc",
    "per_page": "15",
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
$url = 'http://localhost/api/stock-movements';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'movement_type_id' =&gt; 'uuid',
            'statut' =&gt; 'pending',
            'entrepot_from_id' =&gt; 'uuid',
            'entrepot_to_id' =&gt; 'uuid',
            'client_id' =&gt; 'uuid',
            'fournisseur_id' =&gt; 'uuid',
            'search' =&gt; 'MV-2024-001',
            'date_from' =&gt; '2024-01-01',
            'date_to' =&gt; '2024-12-31',
            'sort_by' =&gt; 'created_at',
            'sort_order' =&gt; 'desc',
            'per_page' =&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-stock-movements">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;stock_movement_id&quot;: &quot;uuid&quot;,
                &quot;reference&quot;: &quot;MV-2024-001&quot;,
                &quot;movement_type_id&quot;: &quot;uuid&quot;,
                &quot;entrepot_from_id&quot;: &quot;uuid&quot;,
                &quot;entrepot_to_id&quot;: &quot;uuid&quot;,
                &quot;fournisseur_id&quot;: &quot;uuid&quot;,
                &quot;client_id&quot;: &quot;uuid&quot;,
                &quot;statut&quot;: &quot;pending&quot;,
                &quot;note&quot;: &quot;Note optionnelle&quot;,
                &quot;user_id&quot;: &quot;uuid&quot;,
                &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;movement_type&quot;: {
                    &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
                    &quot;name&quot;: &quot;R&eacute;ception&quot;,
                    &quot;direction&quot;: &quot;in&quot;
                },
                &quot;details_count&quot;: 2,
                &quot;details&quot;: [
                    {
                        &quot;stock_movement_detail_id&quot;: &quot;uuid&quot;,
                        &quot;product_id&quot;: &quot;uuid&quot;,
                        &quot;quantity&quot;: 10,
                        &quot;product&quot;: {
                            &quot;product_id&quot;: &quot;uuid&quot;,
                            &quot;name&quot;: &quot;Produit A&quot;,
                            &quot;sku&quot;: &quot;PROD-A-001&quot;
                        }
                    }
                ]
            }
        ],
        &quot;current_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    },
    &quot;message&quot;: &quot;Mouvements de stock r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movements" data-method="GET"
      data-path="api/stock-movements"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movements"
                    onclick="tryItOut('GETapi-stock-movements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movements"
                    onclick="cancelTryOut('GETapi-stock-movements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movements"
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
                              name="Accept"                data-endpoint="GETapi-stock-movements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>movement_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="movement_type_id"                data-endpoint="GETapi-stock-movements"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par type de mouvement. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>statut</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="statut"                data-endpoint="GETapi-stock-movements"
               value="pending"
               data-component="query">
    <br>
<p>Filtrer par statut (pending, completed, cancelled). Example: <code>pending</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>entrepot_from_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_from_id"                data-endpoint="GETapi-stock-movements"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par entrepôt source. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>entrepot_to_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_to_id"                data-endpoint="GETapi-stock-movements"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par entrepôt destination. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="GETapi-stock-movements"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par client. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>fournisseur_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="fournisseur_id"                data-endpoint="GETapi-stock-movements"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par fournisseur. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-stock-movements"
               value="MV-2024-001"
               data-component="query">
    <br>
<p>Rechercher par référence. Example: <code>MV-2024-001</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-stock-movements"
               value="2024-01-01"
               data-component="query">
    <br>
<p>date Filtrer par date de début. Example: <code>2024-01-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-stock-movements"
               value="2024-12-31"
               data-component="query">
    <br>
<p>date Filtrer par date de fin. Example: <code>2024-12-31</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-stock-movements"
               value="created_at"
               data-component="query">
    <br>
<p>Champ de tri. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_order"                data-endpoint="GETapi-stock-movements"
               value="desc"
               data-component="query">
    <br>
<p>Ordre de tri (asc, desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-stock-movements"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page. Example: <code>15</code></p>
            </div>
                </form>

                    <h2 id="stock-movements-POSTapi-stock-movements">Crée un nouveau mouvement de stock avec ses détails</h2>

<p>
</p>



<span id="example-requests-POSTapi-stock-movements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stock-movements" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"reference\": \"MV-2024-001\",
    \"movement_type_id\": \"uuid\",
    \"entrepot_from_id\": \"uuid\",
    \"entrepot_to_id\": \"uuid\",
    \"fournisseur_id\": \"uuid\",
    \"client_id\": \"uuid\",
    \"statut\": \"pending\",
    \"note\": \"Note sur le mouvement\",
    \"user_id\": \"uuid\",
    \"details\": [
        {
            \"product_id\": \"uuid\",
            \"quantity\": 10
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "reference": "MV-2024-001",
    "movement_type_id": "uuid",
    "entrepot_from_id": "uuid",
    "entrepot_to_id": "uuid",
    "fournisseur_id": "uuid",
    "client_id": "uuid",
    "statut": "pending",
    "note": "Note sur le mouvement",
    "user_id": "uuid",
    "details": [
        {
            "product_id": "uuid",
            "quantity": 10
        }
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movements';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; \Symfony\Component\VarExporter\Internal\Hydrator::hydrate(
            $o = [
                clone (\Symfony\Component\VarExporter\Internal\Registry::$prototypes['stdClass'] ?? \Symfony\Component\VarExporter\Internal\Registry::p('stdClass')),
            ],
            null,
            [
                'stdClass' =&gt; [
                    'product_id' =&gt; [
                        'uuid',
                    ],
                    'quantity' =&gt; [
                        10,
                    ],
                ],
            ],
            [
                'reference' =&gt; 'MV-2024-001',
                'movement_type_id' =&gt; 'uuid',
                'entrepot_from_id' =&gt; 'uuid',
                'entrepot_to_id' =&gt; 'uuid',
                'fournisseur_id' =&gt; 'uuid',
                'client_id' =&gt; 'uuid',
                'statut' =&gt; 'pending',
                'note' =&gt; 'Note sur le mouvement',
                'user_id' =&gt; 'uuid',
                'details' =&gt; [
                    $o[0],
                ],
            ],
            []
        ),
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stock-movements">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_id&quot;: &quot;uuid&quot;,
        &quot;reference&quot;: &quot;MV-2024-001&quot;,
        &quot;movement_type_id&quot;: &quot;uuid&quot;,
        &quot;entrepot_from_id&quot;: &quot;uuid&quot;,
        &quot;entrepot_to_id&quot;: &quot;uuid&quot;,
        &quot;fournisseur_id&quot;: &quot;uuid&quot;,
        &quot;client_id&quot;: &quot;uuid&quot;,
        &quot;statut&quot;: &quot;pending&quot;,
        &quot;note&quot;: &quot;Note sur le mouvement&quot;,
        &quot;user_id&quot;: &quot;uuid&quot;,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;movement_type&quot;: {
            &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
            &quot;name&quot;: &quot;R&eacute;ception&quot;,
            &quot;direction&quot;: &quot;in&quot;
        },
        &quot;details&quot;: [
            {
                &quot;stock_movement_detail_id&quot;: &quot;uuid&quot;,
                &quot;product_id&quot;: &quot;uuid&quot;,
                &quot;quantity&quot;: 10,
                &quot;product&quot;: {
                    &quot;product_id&quot;: &quot;uuid&quot;,
                    &quot;name&quot;: &quot;Produit A&quot;,
                    &quot;sku&quot;: &quot;PROD-A-001&quot;
                }
            }
        ]
    },
    &quot;message&quot;: &quot;Mouvement de stock cr&eacute;&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;reference&quot;: [
            &quot;La r&eacute;f&eacute;rence est obligatoire.&quot;
        ],
        &quot;movement_type_id&quot;: [
            &quot;Le type de mouvement est obligatoire.&quot;
        ],
        &quot;details&quot;: [
            &quot;Les d&eacute;tails du mouvement sont obligatoires.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stock-movements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stock-movements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stock-movements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stock-movements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stock-movements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stock-movements" data-method="POST"
      data-path="api/stock-movements"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stock-movements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stock-movements"
                    onclick="tryItOut('POSTapi-stock-movements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stock-movements"
                    onclick="cancelTryOut('POSTapi-stock-movements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stock-movements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stock-movements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stock-movements"
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
                              name="Accept"                data-endpoint="POSTapi-stock-movements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reference</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="reference"                data-endpoint="POSTapi-stock-movements"
               value="MV-2024-001"
               data-component="body">
    <br>
<p>Référence unique du mouvement. Example: <code>MV-2024-001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>movement_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="movement_type_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID du type de mouvement. Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>entrepot_from_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_from_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID de l'entrepôt source (optionnel pour les transferts). Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>entrepot_to_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_to_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID de l'entrepôt destination (optionnel pour les réceptions). Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fournisseur_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="fournisseur_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID du fournisseur (optionnel). Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID du client (optionnel). Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>statut</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="statut"                data-endpoint="POSTapi-stock-movements"
               value="pending"
               data-component="body">
    <br>
<p>Statut du mouvement (pending, completed, cancelled). Example: <code>pending</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>note</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="note"                data-endpoint="POSTapi-stock-movements"
               value="Note sur le mouvement"
               data-component="body">
    <br>
<p>Note optionnelle. Example: <code>Note sur le mouvement</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="user_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID de l'utilisateur. Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>details</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
<br>
<p>Détails du mouvement (minimum 1).</p>
            </summary>
                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>*</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="details.*.product_id"                data-endpoint="POSTapi-stock-movements"
               value="uuid"
               data-component="body">
    <br>
<p>ID du produit. Example: <code>uuid</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="details.*.quantity"                data-endpoint="POSTapi-stock-movements"
               value="10"
               data-component="body">
    <br>
<p>Quantité (minimum 1). Example: <code>10</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
        </form>

                    <h2 id="stock-movements-PATCHapi-stock-movements--id--update-status">Met à jour le statut d&#039;un mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PATCHapi-stock-movements--id--update-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/stock-movements/uuid/update-status" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"statut\": \"completed\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/uuid/update-status"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "statut": "completed"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movements/uuid/update-status';
$response = $client-&gt;patch(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'statut' =&gt; 'completed',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PATCHapi-stock-movements--id--update-status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_id&quot;: &quot;uuid&quot;,
        &quot;reference&quot;: &quot;MV-2024-001&quot;,
        &quot;statut&quot;: &quot;completed&quot;,
        &quot;movement_type&quot;: {
            &quot;stock_movement_type_id&quot;: &quot;uuid&quot;,
            &quot;name&quot;: &quot;R&eacute;ception&quot;,
            &quot;direction&quot;: &quot;in&quot;
        },
        &quot;details&quot;: []
    },
    &quot;message&quot;: &quot;Statut du mouvement de stock mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;statut&quot;: [
            &quot;Le statut est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-stock-movements--id--update-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-stock-movements--id--update-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-stock-movements--id--update-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-stock-movements--id--update-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-stock-movements--id--update-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-stock-movements--id--update-status" data-method="PATCH"
      data-path="api/stock-movements/{id}/update-status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-stock-movements--id--update-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-stock-movements--id--update-status"
                    onclick="tryItOut('PATCHapi-stock-movements--id--update-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-stock-movements--id--update-status"
                    onclick="cancelTryOut('PATCHapi-stock-movements--id--update-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-stock-movements--id--update-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/stock-movements/{id}/update-status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-stock-movements--id--update-status"
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
                              name="Accept"                data-endpoint="PATCHapi-stock-movements--id--update-status"
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
                              name="id"                data-endpoint="PATCHapi-stock-movements--id--update-status"
               value="uuid"
               data-component="url">
    <br>
<p>ID du mouvement de stock. Example: <code>uuid</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>statut</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="statut"                data-endpoint="PATCHapi-stock-movements--id--update-status"
               value="completed"
               data-component="body">
    <br>
<p>Nouveau statut (pending, completed, cancelled). Example: <code>completed</code></p>
        </div>
        </form>

                <h1 id="stock-movement-details">Stock Movement Details</h1>

    

                                <h2 id="stock-movement-details-GETapi-stock-movement-details">Récupère la liste des détails de mouvements de stock</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-details">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-details?stock_movement_id=uuid&amp;product_id=uuid&amp;quantity_min=1&amp;quantity_max=100&amp;sort_by=created_at&amp;sort_order=desc&amp;per_page=15" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details"
);

const params = {
    "stock_movement_id": "uuid",
    "product_id": "uuid",
    "quantity_min": "1",
    "quantity_max": "100",
    "sort_by": "created_at",
    "sort_order": "desc",
    "per_page": "15",
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
$url = 'http://localhost/api/stock-movement-details';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'stock_movement_id' =&gt; 'uuid',
            'product_id' =&gt; 'uuid',
            'quantity_min' =&gt; '1',
            'quantity_max' =&gt; '100',
            'sort_by' =&gt; 'created_at',
            'sort_order' =&gt; 'desc',
            'per_page' =&gt; '15',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-stock-movement-details">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;stock_movement_detail_id&quot;: &quot;uuid&quot;,
                &quot;stock_movement_id&quot;: &quot;uuid&quot;,
                &quot;product_id&quot;: &quot;uuid&quot;,
                &quot;quantity&quot;: 10,
                &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;stock_movement&quot;: {
                    &quot;stock_movement_id&quot;: &quot;uuid&quot;,
                    &quot;reference&quot;: &quot;MV-2024-001&quot;,
                    &quot;movement_type&quot;: {
                        &quot;name&quot;: &quot;R&eacute;ception&quot;,
                        &quot;direction&quot;: &quot;in&quot;
                    }
                },
                &quot;product&quot;: {
                    &quot;product_id&quot;: &quot;uuid&quot;,
                    &quot;name&quot;: &quot;Produit A&quot;,
                    &quot;sku&quot;: &quot;PROD-A-001&quot;
                }
            }
        ],
        &quot;current_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    },
    &quot;message&quot;: &quot;D&eacute;tails de mouvements de stock r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-details" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-details"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-details"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-details" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-details">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-details" data-method="GET"
      data-path="api/stock-movement-details"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-details', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-details"
                    onclick="tryItOut('GETapi-stock-movement-details');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-details"
                    onclick="cancelTryOut('GETapi-stock-movement-details');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-details"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-details</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-details"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-details"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_movement_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="stock_movement_id"                data-endpoint="GETapi-stock-movement-details"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par mouvement de stock. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="GETapi-stock-movement-details"
               value="uuid"
               data-component="query">
    <br>
<p>Filtrer par produit. Example: <code>uuid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>quantity_min</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity_min"                data-endpoint="GETapi-stock-movement-details"
               value="1"
               data-component="query">
    <br>
<p>Filtrer par quantité minimale. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>quantity_max</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity_max"                data-endpoint="GETapi-stock-movement-details"
               value="100"
               data-component="query">
    <br>
<p>Filtrer par quantité maximale. Example: <code>100</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-stock-movement-details"
               value="created_at"
               data-component="query">
    <br>
<p>Champ de tri. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_order</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_order"                data-endpoint="GETapi-stock-movement-details"
               value="desc"
               data-component="query">
    <br>
<p>Ordre de tri (asc, desc). Example: <code>desc</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-stock-movement-details"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page. Example: <code>15</code></p>
            </div>
                </form>

                    <h2 id="stock-movement-details-POSTapi-stock-movement-details">Crée un nouveau détail de mouvement de stock</h2>

<p>
</p>



<span id="example-requests-POSTapi-stock-movement-details">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stock-movement-details" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"stock_movement_id\": \"uuid\",
    \"product_id\": \"uuid\",
    \"quantity\": 10
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "stock_movement_id": "uuid",
    "product_id": "uuid",
    "quantity": 10
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movement-details';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'stock_movement_id' =&gt; 'uuid',
            'product_id' =&gt; 'uuid',
            'quantity' =&gt; 10,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stock-movement-details">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_movement_detail_id&quot;: &quot;uuid&quot;,
        &quot;stock_movement_id&quot;: &quot;uuid&quot;,
        &quot;product_id&quot;: &quot;uuid&quot;,
        &quot;quantity&quot;: 10,
        &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
        &quot;stock_movement&quot;: {
            &quot;stock_movement_id&quot;: &quot;uuid&quot;,
            &quot;reference&quot;: &quot;MV-2024-001&quot;,
            &quot;movement_type&quot;: {
                &quot;name&quot;: &quot;R&eacute;ception&quot;,
                &quot;direction&quot;: &quot;in&quot;
            }
        },
        &quot;product&quot;: {
            &quot;product_id&quot;: &quot;uuid&quot;,
            &quot;name&quot;: &quot;Produit A&quot;,
            &quot;sku&quot;: &quot;PROD-A-001&quot;
        }
    },
    &quot;message&quot;: &quot;D&eacute;tail de mouvement de stock cr&eacute;&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;stock_movement_id&quot;: [
            &quot;Le mouvement de stock est obligatoire.&quot;
        ],
        &quot;product_id&quot;: [
            &quot;Le produit est obligatoire.&quot;
        ],
        &quot;quantity&quot;: [
            &quot;La quantit&eacute; est obligatoire.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stock-movement-details" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stock-movement-details"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stock-movement-details"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stock-movement-details" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stock-movement-details">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stock-movement-details" data-method="POST"
      data-path="api/stock-movement-details"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stock-movement-details', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stock-movement-details"
                    onclick="tryItOut('POSTapi-stock-movement-details');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stock-movement-details"
                    onclick="cancelTryOut('POSTapi-stock-movement-details');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stock-movement-details"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stock-movement-details</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stock-movement-details"
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
                              name="Accept"                data-endpoint="POSTapi-stock-movement-details"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>stock_movement_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_movement_id"                data-endpoint="POSTapi-stock-movement-details"
               value="uuid"
               data-component="body">
    <br>
<p>ID du mouvement de stock. Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="POSTapi-stock-movement-details"
               value="uuid"
               data-component="body">
    <br>
<p>ID du produit. Example: <code>uuid</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-stock-movement-details"
               value="10"
               data-component="body">
    <br>
<p>Quantité (minimum 1). Example: <code>10</code></p>
        </div>
        </form>

                    <h2 id="stock-movement-details-GETapi-stock-movement-details-stock-movement--stockMovementId-">Récupère tous les détails d&#039;un mouvement de stock spécifique</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-details-stock-movement--stockMovementId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-details/stock-movement/uuid" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/stock-movement/uuid"
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
$url = 'http://localhost/api/stock-movement-details/stock-movement/uuid';
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

<span id="example-responses-GETapi-stock-movement-details-stock-movement--stockMovementId-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;stock_movement_detail_id&quot;: &quot;uuid&quot;,
                &quot;stock_movement_id&quot;: &quot;uuid&quot;,
                &quot;product_id&quot;: &quot;uuid&quot;,
                &quot;quantity&quot;: 10,
                &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;product&quot;: {
                    &quot;product_id&quot;: &quot;uuid&quot;,
                    &quot;name&quot;: &quot;Produit A&quot;,
                    &quot;sku&quot;: &quot;PROD-A-001&quot;
                }
            }
        ],
        &quot;current_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    },
    &quot;message&quot;: &quot;D&eacute;tails du mouvement de stock r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-details-stock-movement--stockMovementId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-details-stock-movement--stockMovementId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-details-stock-movement--stockMovementId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-details-stock-movement--stockMovementId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-details-stock-movement--stockMovementId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-details-stock-movement--stockMovementId-" data-method="GET"
      data-path="api/stock-movement-details/stock-movement/{stockMovementId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-details-stock-movement--stockMovementId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-details-stock-movement--stockMovementId-"
                    onclick="tryItOut('GETapi-stock-movement-details-stock-movement--stockMovementId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-details-stock-movement--stockMovementId-"
                    onclick="cancelTryOut('GETapi-stock-movement-details-stock-movement--stockMovementId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-details-stock-movement--stockMovementId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-details/stock-movement/{stockMovementId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-details-stock-movement--stockMovementId-"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-details-stock-movement--stockMovementId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stockMovementId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stockMovementId"                data-endpoint="GETapi-stock-movement-details-stock-movement--stockMovementId-"
               value="uuid"
               data-component="url">
    <br>
<p>ID du mouvement de stock. Example: <code>uuid</code></p>
            </div>
                    </form>

                    <h2 id="stock-movement-details-GETapi-stock-movement-details-product--productId-">Récupère tous les détails de mouvements pour un produit spécifique</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-details-product--productId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-details/product/uuid" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/product/uuid"
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
$url = 'http://localhost/api/stock-movement-details/product/uuid';
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

<span id="example-responses-GETapi-stock-movement-details-product--productId-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;data&quot;: [
            {
                &quot;stock_movement_detail_id&quot;: &quot;uuid&quot;,
                &quot;stock_movement_id&quot;: &quot;uuid&quot;,
                &quot;product_id&quot;: &quot;uuid&quot;,
                &quot;quantity&quot;: 10,
                &quot;created_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;updated_at&quot;: &quot;2024-01-01 10:00:00&quot;,
                &quot;stock_movement&quot;: {
                    &quot;stock_movement_id&quot;: &quot;uuid&quot;,
                    &quot;reference&quot;: &quot;MV-2024-001&quot;,
                    &quot;movement_type&quot;: {
                        &quot;name&quot;: &quot;R&eacute;ception&quot;,
                        &quot;direction&quot;: &quot;in&quot;
                    }
                }
            }
        ],
        &quot;current_page&quot;: 1,
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    },
    &quot;message&quot;: &quot;D&eacute;tails de mouvements du produit r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Produit non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-details-product--productId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-details-product--productId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-details-product--productId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-details-product--productId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-details-product--productId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-details-product--productId-" data-method="GET"
      data-path="api/stock-movement-details/product/{productId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-details-product--productId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-details-product--productId-"
                    onclick="tryItOut('GETapi-stock-movement-details-product--productId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-details-product--productId-"
                    onclick="cancelTryOut('GETapi-stock-movement-details-product--productId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-details-product--productId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-details/product/{productId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-details-product--productId-"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-details-product--productId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>productId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="productId"                data-endpoint="GETapi-stock-movement-details-product--productId-"
               value="uuid"
               data-component="url">
    <br>
<p>ID du produit. Example: <code>uuid</code></p>
            </div>
                    </form>

                <h1 id="produits">Produits</h1>

    

                                <h2 id="produits-GETapi-products">Lister tous les produits</h2>

<p>
</p>



<span id="example-requests-GETapi-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/products" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products"
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
$url = 'http://localhost/api/products';
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

<span id="example-responses-GETapi-products">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;product_id&quot;: &quot;uuid&quot;,
            &quot;code&quot;: &quot;PRO-ABC123&quot;,
            &quot;name&quot;: &quot;Produit Exemple&quot;,
            &quot;description&quot;: &quot;Description du produit&quot;,
            &quot;unit_price&quot;: 1500.5,
            &quot;cost&quot;: 1200,
            &quot;minimum_cost&quot;: 1000,
            &quot;min_stock_level&quot;: 10,
            &quot;is_active&quot;: true,
            &quot;picture&quot;: &quot;image.jpg&quot;,
            &quot;product_category_id&quot;: &quot;uuid&quot;,
            &quot;category&quot;: {
                &quot;product_category_id&quot;: &quot;uuid&quot;,
                &quot;label&quot;: &quot;Cat&eacute;gorie Exemple&quot;
            }
        }
    ],
    &quot;message&quot;: &quot;Liste des produits&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products" data-method="GET"
      data-path="api/products"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products"
                    onclick="tryItOut('GETapi-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products"
                    onclick="cancelTryOut('GETapi-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products"
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
                              name="Accept"                data-endpoint="GETapi-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="produits-POSTapi-products">Créer un nouveau produit</h2>

<p>
</p>



<span id="example-requests-POSTapi-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/products" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"architecto\",
    \"description\": \"Eius et animi quos velit et.\",
    \"product_category_id\": \"architecto\",
    \"unit_price\": \"architecto\",
    \"cost\": \"architecto\",
    \"minimum_cost\": \"architecto\",
    \"min_stock_level\": 16,
    \"is_active\": false,
    \"picture\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "architecto",
    "description": "Eius et animi quos velit et.",
    "product_category_id": "architecto",
    "unit_price": "architecto",
    "cost": "architecto",
    "minimum_cost": "architecto",
    "min_stock_level": 16,
    "is_active": false,
    "picture": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/products';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'name' =&gt; 'architecto',
            'description' =&gt; 'Eius et animi quos velit et.',
            'product_category_id' =&gt; 'architecto',
            'unit_price' =&gt; 'architecto',
            'cost' =&gt; 'architecto',
            'minimum_cost' =&gt; 'architecto',
            'min_stock_level' =&gt; 16,
            'is_active' =&gt; false,
            'picture' =&gt; 'architecto',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-products">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;product_id&quot;: &quot;uuid&quot;,
        &quot;code&quot;: &quot;PRO-ABC123&quot;,
        &quot;name&quot;: &quot;Produit Exemple&quot;,
        &quot;description&quot;: &quot;Description du produit&quot;,
        &quot;unit_price&quot;: 1500.5,
        &quot;cost&quot;: 1200,
        &quot;minimum_cost&quot;: 1000,
        &quot;min_stock_level&quot;: 10,
        &quot;is_active&quot;: true,
        &quot;picture&quot;: &quot;image.jpg&quot;,
        &quot;product_category_id&quot;: &quot;uuid&quot;,
        &quot;category&quot;: {
            &quot;product_category_id&quot;: &quot;uuid&quot;,
            &quot;label&quot;: &quot;Cat&eacute;gorie Exemple&quot;
        }
    },
    &quot;message&quot;: &quot;Produit cr&eacute;&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Les donn&eacute;es sont invalides&quot;,
    &quot;errors&quot;: {
        &quot;name&quot;: [
            &quot;Le nom du produit est obligatoire&quot;,
            &quot;Ce nom existe d&eacute;j&agrave;&quot;
        ],
        &quot;product_category_id&quot;: [
            &quot;La cat&eacute;gorie est obligatoire&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-products" data-method="POST"
      data-path="api/products"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-products"
                    onclick="tryItOut('POSTapi-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-products"
                    onclick="cancelTryOut('POSTapi-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-products"
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
                              name="Accept"                data-endpoint="POSTapi-products"
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
                              name="name"                data-endpoint="POSTapi-products"
               value="architecto"
               data-component="body">
    <br>
<p>Nom du produit. Exemple: &quot;Produit Exemple&quot; Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-products"
               value="Eius et animi quos velit et."
               data-component="body">
    <br>
<p>Description du produit. Exemple: &quot;Description du produit&quot; Example: <code>Eius et animi quos velit et.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_category_id</code></b>&nbsp;&nbsp;
<small>uuid</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_category_id"                data-endpoint="POSTapi-products"
               value="architecto"
               data-component="body">
    <br>
<p>ID de la catégorie. Exemple: &quot;uuid&quot; Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>unit_price</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="unit_price"                data-endpoint="POSTapi-products"
               value="architecto"
               data-component="body">
    <br>
<p>Prix unitaire. Exemple: 1500.50 Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>cost</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="cost"                data-endpoint="POSTapi-products"
               value="architecto"
               data-component="body">
    <br>
<p>Coût du produit. Exemple: 1200 Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>minimum_cost</code></b>&nbsp;&nbsp;
<small>numeric</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="minimum_cost"                data-endpoint="POSTapi-products"
               value="architecto"
               data-component="body">
    <br>
<p>Coût minimum. Exemple: 1000 Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>min_stock_level</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="min_stock_level"                data-endpoint="POSTapi-products"
               value="16"
               data-component="body">
    <br>
<p>Quantité minimale en stock. Exemple: 10 Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-products" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-products"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-products" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-products"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Produit actif ou non. Exemple: true Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>picture</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="picture"                data-endpoint="POSTapi-products"
               value="architecto"
               data-component="body">
    <br>
<p>URL ou nom de l'image. Exemple: &quot;image.jpg&quot; Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="produits-GETapi-products--id-">Afficher un produit par ID</h2>

<p>
</p>



<span id="example-requests-GETapi-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/products/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products/architecto"
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
$url = 'http://localhost/api/products/architecto';
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

<span id="example-responses-GETapi-products--id-">
            <blockquote>
            <p>Example response (404):</p>
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
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Product] architecto&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products--id-" data-method="GET"
      data-path="api/products/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products--id-"
                    onclick="tryItOut('GETapi-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products--id-"
                    onclick="cancelTryOut('GETapi-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products--id-"
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
                              name="Accept"                data-endpoint="GETapi-products--id-"
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
                              name="id"                data-endpoint="GETapi-products--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="produits-PUTapi-products--id-">Mettre à jour un produit</h2>

<p>
</p>



<span id="example-requests-PUTapi-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/products/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"description\": \"Eius et animi quos velit et.\",
    \"product_category_id\": \"21c4122b-d554-3723-966c-6d723ea5293f\",
    \"unit_price\": 37,
    \"cost\": 9,
    \"minimum_cost\": 52,
    \"min_stock_level\": 8,
    \"is_active\": true,
    \"picture\": \"k\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "description": "Eius et animi quos velit et.",
    "product_category_id": "21c4122b-d554-3723-966c-6d723ea5293f",
    "unit_price": 37,
    "cost": 9,
    "minimum_cost": 52,
    "min_stock_level": 8,
    "is_active": true,
    "picture": "k"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/products/architecto';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'description' =&gt; 'Eius et animi quos velit et.',
            'product_category_id' =&gt; '21c4122b-d554-3723-966c-6d723ea5293f',
            'unit_price' =&gt; 37,
            'cost' =&gt; 9,
            'minimum_cost' =&gt; 52,
            'min_stock_level' =&gt; 8,
            'is_active' =&gt; true,
            'picture' =&gt; 'k',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-products--id-">
</span>
<span id="execution-results-PUTapi-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-products--id-" data-method="PUT"
      data-path="api/products/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-products--id-"
                    onclick="tryItOut('PUTapi-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-products--id-"
                    onclick="cancelTryOut('PUTapi-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-products--id-"
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
                              name="Accept"                data-endpoint="PUTapi-products--id-"
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
                              name="id"                data-endpoint="PUTapi-products--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-products--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-products--id-"
               value="Eius et animi quos velit et."
               data-component="body">
    <br>
<p>Example: <code>Eius et animi quos velit et.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_category_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_category_id"                data-endpoint="PUTapi-products--id-"
               value="21c4122b-d554-3723-966c-6d723ea5293f"
               data-component="body">
    <br>
<p>Must be a valid UUID. The <code>product_category_id</code> of an existing record in the product_categories table. Example: <code>21c4122b-d554-3723-966c-6d723ea5293f</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>unit_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="unit_price"                data-endpoint="PUTapi-products--id-"
               value="37"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>37</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>cost</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="cost"                data-endpoint="PUTapi-products--id-"
               value="9"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>9</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>minimum_cost</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="minimum_cost"                data-endpoint="PUTapi-products--id-"
               value="52"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>52</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>min_stock_level</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="min_stock_level"                data-endpoint="PUTapi-products--id-"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PUTapi-products--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PUTapi-products--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-products--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PUTapi-products--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>picture</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="picture"                data-endpoint="PUTapi-products--id-"
               value="k"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>k</code></p>
        </div>
        </form>

                    <h2 id="produits-DELETEapi-products--id-">Supprimer un produit (soft delete)</h2>

<p>
</p>



<span id="example-requests-DELETEapi-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/products/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products/architecto"
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
$url = 'http://localhost/api/products/architecto';
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

<span id="example-responses-DELETEapi-products--id-">
</span>
<span id="execution-results-DELETEapi-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-products--id-" data-method="DELETE"
      data-path="api/products/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-products--id-"
                    onclick="tryItOut('DELETEapi-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-products--id-"
                    onclick="cancelTryOut('DELETEapi-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-products--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-products--id-"
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
                              name="id"                data-endpoint="DELETEapi-products--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="produits-GETapi-products-category--categoryId-">Lister les produits par catégorie</h2>

<p>
</p>



<span id="example-requests-GETapi-products-category--categoryId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/products/category/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products/category/architecto"
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
$url = 'http://localhost/api/products/category/architecto';
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

<span id="example-responses-GETapi-products-category--categoryId-">
            <blockquote>
            <p>Example response (200):</p>
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
    &quot;data&quot;: [],
    &quot;message&quot;: &quot;Produits de la cat&eacute;gorie&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products-category--categoryId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products-category--categoryId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products-category--categoryId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products-category--categoryId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products-category--categoryId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products-category--categoryId-" data-method="GET"
      data-path="api/products/category/{categoryId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products-category--categoryId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products-category--categoryId-"
                    onclick="tryItOut('GETapi-products-category--categoryId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products-category--categoryId-"
                    onclick="cancelTryOut('GETapi-products-category--categoryId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products-category--categoryId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products/category/{categoryId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products-category--categoryId-"
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
                              name="Accept"                data-endpoint="GETapi-products-category--categoryId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>categoryId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="categoryId"                data-endpoint="GETapi-products-category--categoryId-"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="produits-GETapi-products--id--restore">Restaurer un produit supprimé</h2>

<p>
</p>



<span id="example-requests-GETapi-products--id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/products/architecto/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products/architecto/restore"
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
$url = 'http://localhost/api/products/architecto/restore';
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

<span id="example-responses-GETapi-products--id--restore">
            <blockquote>
            <p>Example response (404):</p>
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
    &quot;message&quot;: &quot;No query results for model [App\\Models\\Product] architecto&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products--id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products--id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products--id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products--id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products--id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products--id--restore" data-method="GET"
      data-path="api/products/{id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products--id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products--id--restore"
                    onclick="tryItOut('GETapi-products--id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products--id--restore"
                    onclick="cancelTryOut('GETapi-products--id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products--id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products/{id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products--id--restore"
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
                              name="Accept"                data-endpoint="GETapi-products--id--restore"
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
                              name="id"                data-endpoint="GETapi-products--id--restore"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="produits-DELETEapi-products--id--force">Supprimer définitivement un produit</h2>

<p>
</p>



<span id="example-requests-DELETEapi-products--id--force">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/products/architecto/force" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/products/architecto/force"
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
$url = 'http://localhost/api/products/architecto/force';
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

<span id="example-responses-DELETEapi-products--id--force">
</span>
<span id="execution-results-DELETEapi-products--id--force" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-products--id--force"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-products--id--force"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-products--id--force" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-products--id--force">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-products--id--force" data-method="DELETE"
      data-path="api/products/{id}/force"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-products--id--force', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-products--id--force"
                    onclick="tryItOut('DELETEapi-products--id--force');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-products--id--force"
                    onclick="cancelTryOut('DELETEapi-products--id--force');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-products--id--force"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/products/{id}/force</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-products--id--force"
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
                              name="Accept"                data-endpoint="DELETEapi-products--id--force"
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
                              name="id"                data-endpoint="DELETEapi-products--id--force"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>architecto</code></p>
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

                    <h2 id="endpoints-GETapi-stock-movements--id-">Afficher un mouvement de stock spécifique</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movements/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/architecto"
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
$url = 'http://localhost/api/stock-movements/architecto';
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

<span id="example-responses-GETapi-stock-movements--id-">
            <blockquote>
            <p>Example response (404):</p>
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
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movements--id-" data-method="GET"
      data-path="api/stock-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movements--id-"
                    onclick="tryItOut('GETapi-stock-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movements--id-"
                    onclick="cancelTryOut('GETapi-stock-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movements--id-"
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
                              name="Accept"                data-endpoint="GETapi-stock-movements--id-"
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
                              name="id"                data-endpoint="GETapi-stock-movements--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-stock-movements--id-">Mettre à jour un mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PUTapi-stock-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/stock-movements/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movements/architecto';
$response = $client-&gt;put(
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

<span id="example-responses-PUTapi-stock-movements--id-">
</span>
<span id="execution-results-PUTapi-stock-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-stock-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-stock-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-stock-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-stock-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-stock-movements--id-" data-method="PUT"
      data-path="api/stock-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-stock-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-stock-movements--id-"
                    onclick="tryItOut('PUTapi-stock-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-stock-movements--id-"
                    onclick="cancelTryOut('PUTapi-stock-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-stock-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/stock-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-stock-movements--id-"
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
                              name="Accept"                data-endpoint="PUTapi-stock-movements--id-"
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
                              name="id"                data-endpoint="PUTapi-stock-movements--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PATCHapi-stock-movements--id-">Mettre à jour un mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PATCHapi-stock-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/stock-movements/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/architecto"
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
$url = 'http://localhost/api/stock-movements/architecto';
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

<span id="example-responses-PATCHapi-stock-movements--id-">
</span>
<span id="execution-results-PATCHapi-stock-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-stock-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-stock-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-stock-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-stock-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-stock-movements--id-" data-method="PATCH"
      data-path="api/stock-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-stock-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-stock-movements--id-"
                    onclick="tryItOut('PATCHapi-stock-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-stock-movements--id-"
                    onclick="cancelTryOut('PATCHapi-stock-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-stock-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/stock-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-stock-movements--id-"
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
                              name="Accept"                data-endpoint="PATCHapi-stock-movements--id-"
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
                              name="id"                data-endpoint="PATCHapi-stock-movements--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-DELETEapi-stock-movements--id-">Supprimer un mouvement de stock (soft delete)</h2>

<p>
</p>



<span id="example-requests-DELETEapi-stock-movements--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/stock-movements/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/architecto"
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
$url = 'http://localhost/api/stock-movements/architecto';
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

<span id="example-responses-DELETEapi-stock-movements--id-">
</span>
<span id="execution-results-DELETEapi-stock-movements--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-stock-movements--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-stock-movements--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-stock-movements--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-stock-movements--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-stock-movements--id-" data-method="DELETE"
      data-path="api/stock-movements/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-stock-movements--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-stock-movements--id-"
                    onclick="tryItOut('DELETEapi-stock-movements--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-stock-movements--id-"
                    onclick="cancelTryOut('DELETEapi-stock-movements--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-stock-movements--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/stock-movements/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-stock-movements--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-stock-movements--id-"
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
                              name="id"                data-endpoint="DELETEapi-stock-movements--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-stock-movements-trashed-list">Lister les mouvements de stock supprimés</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movements-trashed-list">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movements/trashed/list" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/trashed/list"
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
$url = 'http://localhost/api/stock-movements/trashed/list';
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

<span id="example-responses-GETapi-stock-movements-trashed-list">
            <blockquote>
            <p>Example response (200):</p>
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
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;current_page&quot;: 1,
        &quot;data&quot;: [],
        &quot;first_page_url&quot;: &quot;http://localhost/api/stock-movements/trashed/list?page=1&quot;,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;last_page_url&quot;: &quot;http://localhost/api/stock-movements/trashed/list?page=1&quot;,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;page&quot;: null,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/stock-movements/trashed/list?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;page&quot;: 1,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;page&quot;: null,
                &quot;active&quot;: false
            }
        ],
        &quot;next_page_url&quot;: null,
        &quot;path&quot;: &quot;http://localhost/api/stock-movements/trashed/list&quot;,
        &quot;per_page&quot;: 15,
        &quot;prev_page_url&quot;: null,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    },
    &quot;message&quot;: &quot;Mouvements de stock supprim&eacute;s r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movements-trashed-list" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movements-trashed-list"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movements-trashed-list"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movements-trashed-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movements-trashed-list">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movements-trashed-list" data-method="GET"
      data-path="api/stock-movements/trashed/list"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movements-trashed-list', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movements-trashed-list"
                    onclick="tryItOut('GETapi-stock-movements-trashed-list');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movements-trashed-list"
                    onclick="cancelTryOut('GETapi-stock-movements-trashed-list');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movements-trashed-list"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movements/trashed/list</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movements-trashed-list"
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
                              name="Accept"                data-endpoint="GETapi-stock-movements-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-stock-movements--id--restore">Restaurer un mouvement de stock supprimé</h2>

<p>
</p>



<span id="example-requests-POSTapi-stock-movements--id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stock-movements/architecto/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movements/architecto/restore"
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
$url = 'http://localhost/api/stock-movements/architecto/restore';
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

<span id="example-responses-POSTapi-stock-movements--id--restore">
</span>
<span id="execution-results-POSTapi-stock-movements--id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stock-movements--id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stock-movements--id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stock-movements--id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stock-movements--id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stock-movements--id--restore" data-method="POST"
      data-path="api/stock-movements/{id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stock-movements--id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stock-movements--id--restore"
                    onclick="tryItOut('POSTapi-stock-movements--id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stock-movements--id--restore"
                    onclick="cancelTryOut('POSTapi-stock-movements--id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stock-movements--id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stock-movements/{id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stock-movements--id--restore"
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
                              name="Accept"                data-endpoint="POSTapi-stock-movements--id--restore"
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
                              name="id"                data-endpoint="POSTapi-stock-movements--id--restore"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-stock-movement-details--id-">Afficher un détail de mouvement de stock spécifique</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-details--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-details/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/architecto"
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
$url = 'http://localhost/api/stock-movement-details/architecto';
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

<span id="example-responses-GETapi-stock-movement-details--id-">
            <blockquote>
            <p>Example response (404):</p>
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
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;D&eacute;tail de mouvement de stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-details--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-details--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-details--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-details--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-details--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-details--id-" data-method="GET"
      data-path="api/stock-movement-details/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-details--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-details--id-"
                    onclick="tryItOut('GETapi-stock-movement-details--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-details--id-"
                    onclick="cancelTryOut('GETapi-stock-movement-details--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-details--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-details/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-details--id-"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-details--id-"
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
                              name="id"                data-endpoint="GETapi-stock-movement-details--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement detail. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-stock-movement-details--id-">Mettre à jour un détail de mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PUTapi-stock-movement-details--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/stock-movement-details/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stock-movement-details/architecto';
$response = $client-&gt;put(
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

<span id="example-responses-PUTapi-stock-movement-details--id-">
</span>
<span id="execution-results-PUTapi-stock-movement-details--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-stock-movement-details--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-stock-movement-details--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-stock-movement-details--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-stock-movement-details--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-stock-movement-details--id-" data-method="PUT"
      data-path="api/stock-movement-details/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-stock-movement-details--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-stock-movement-details--id-"
                    onclick="tryItOut('PUTapi-stock-movement-details--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-stock-movement-details--id-"
                    onclick="cancelTryOut('PUTapi-stock-movement-details--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-stock-movement-details--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/stock-movement-details/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-stock-movement-details--id-"
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
                              name="Accept"                data-endpoint="PUTapi-stock-movement-details--id-"
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
                              name="id"                data-endpoint="PUTapi-stock-movement-details--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement detail. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PATCHapi-stock-movement-details--id-">Mettre à jour un détail de mouvement de stock</h2>

<p>
</p>



<span id="example-requests-PATCHapi-stock-movement-details--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://localhost/api/stock-movement-details/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/architecto"
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
$url = 'http://localhost/api/stock-movement-details/architecto';
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

<span id="example-responses-PATCHapi-stock-movement-details--id-">
</span>
<span id="execution-results-PATCHapi-stock-movement-details--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-stock-movement-details--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-stock-movement-details--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-stock-movement-details--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-stock-movement-details--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-stock-movement-details--id-" data-method="PATCH"
      data-path="api/stock-movement-details/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-stock-movement-details--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-stock-movement-details--id-"
                    onclick="tryItOut('PATCHapi-stock-movement-details--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-stock-movement-details--id-"
                    onclick="cancelTryOut('PATCHapi-stock-movement-details--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-stock-movement-details--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/stock-movement-details/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-stock-movement-details--id-"
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
                              name="Accept"                data-endpoint="PATCHapi-stock-movement-details--id-"
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
                              name="id"                data-endpoint="PATCHapi-stock-movement-details--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement detail. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-DELETEapi-stock-movement-details--id-">Supprimer un détail de mouvement de stock (soft delete)</h2>

<p>
</p>



<span id="example-requests-DELETEapi-stock-movement-details--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/stock-movement-details/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/architecto"
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
$url = 'http://localhost/api/stock-movement-details/architecto';
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

<span id="example-responses-DELETEapi-stock-movement-details--id-">
</span>
<span id="execution-results-DELETEapi-stock-movement-details--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-stock-movement-details--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-stock-movement-details--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-stock-movement-details--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-stock-movement-details--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-stock-movement-details--id-" data-method="DELETE"
      data-path="api/stock-movement-details/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-stock-movement-details--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-stock-movement-details--id-"
                    onclick="tryItOut('DELETEapi-stock-movement-details--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-stock-movement-details--id-"
                    onclick="cancelTryOut('DELETEapi-stock-movement-details--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-stock-movement-details--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/stock-movement-details/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-stock-movement-details--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-stock-movement-details--id-"
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
                              name="id"                data-endpoint="DELETEapi-stock-movement-details--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement detail. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-stock-movement-details-trashed-list">Lister les détails de mouvements de stock supprimés</h2>

<p>
</p>



<span id="example-requests-GETapi-stock-movement-details-trashed-list">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stock-movement-details/trashed/list" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/trashed/list"
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
$url = 'http://localhost/api/stock-movement-details/trashed/list';
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

<span id="example-responses-GETapi-stock-movement-details-trashed-list">
            <blockquote>
            <p>Example response (200):</p>
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
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;current_page&quot;: 1,
        &quot;data&quot;: [],
        &quot;first_page_url&quot;: &quot;http://localhost/api/stock-movement-details/trashed/list?page=1&quot;,
        &quot;from&quot;: null,
        &quot;last_page&quot;: 1,
        &quot;last_page_url&quot;: &quot;http://localhost/api/stock-movement-details/trashed/list?page=1&quot;,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;page&quot;: null,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/stock-movement-details/trashed/list?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;page&quot;: 1,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;page&quot;: null,
                &quot;active&quot;: false
            }
        ],
        &quot;next_page_url&quot;: null,
        &quot;path&quot;: &quot;http://localhost/api/stock-movement-details/trashed/list&quot;,
        &quot;per_page&quot;: 15,
        &quot;prev_page_url&quot;: null,
        &quot;to&quot;: null,
        &quot;total&quot;: 0
    },
    &quot;message&quot;: &quot;D&eacute;tails de mouvements de stock supprim&eacute;s r&eacute;cup&eacute;r&eacute;s avec succ&egrave;s&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stock-movement-details-trashed-list" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stock-movement-details-trashed-list"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stock-movement-details-trashed-list"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stock-movement-details-trashed-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stock-movement-details-trashed-list">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stock-movement-details-trashed-list" data-method="GET"
      data-path="api/stock-movement-details/trashed/list"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stock-movement-details-trashed-list', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stock-movement-details-trashed-list"
                    onclick="tryItOut('GETapi-stock-movement-details-trashed-list');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stock-movement-details-trashed-list"
                    onclick="cancelTryOut('GETapi-stock-movement-details-trashed-list');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stock-movement-details-trashed-list"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stock-movement-details/trashed/list</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stock-movement-details-trashed-list"
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
                              name="Accept"                data-endpoint="GETapi-stock-movement-details-trashed-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-stock-movement-details--id--restore">Restaurer un détail de mouvement de stock supprimé</h2>

<p>
</p>



<span id="example-requests-POSTapi-stock-movement-details--id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stock-movement-details/architecto/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stock-movement-details/architecto/restore"
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
$url = 'http://localhost/api/stock-movement-details/architecto/restore';
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

<span id="example-responses-POSTapi-stock-movement-details--id--restore">
</span>
<span id="execution-results-POSTapi-stock-movement-details--id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stock-movement-details--id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stock-movement-details--id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stock-movement-details--id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stock-movement-details--id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stock-movement-details--id--restore" data-method="POST"
      data-path="api/stock-movement-details/{id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stock-movement-details--id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stock-movement-details--id--restore"
                    onclick="tryItOut('POSTapi-stock-movement-details--id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stock-movement-details--id--restore"
                    onclick="cancelTryOut('POSTapi-stock-movement-details--id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stock-movement-details--id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stock-movement-details/{id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stock-movement-details--id--restore"
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
                              name="Accept"                data-endpoint="POSTapi-stock-movement-details--id--restore"
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
                              name="id"                data-endpoint="POSTapi-stock-movement-details--id--restore"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock movement detail. Example: <code>architecto</code></p>
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
    \"with_clients\": true
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
    "with_clients": true
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
            'with_clients' =&gt; true,
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
<p>Example: <code>true</code></p>
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
    \"icon\": \"eye\",
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
    "icon": "eye",
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
            'icon' =&gt; 'eye',
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
        &quot;icon&quot;: &quot;eye&quot;,
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
            <b style="line-height: 2;"><code>icon</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="icon"                data-endpoint="POSTapi-client-types"
               value="eye"
               data-component="body">
    <br>
<p>optionnel Le nom de l'icon. Doit être unique. Example: <code>eye</code></p>
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
        &quot;average_current_balance&quot;: &quot;83333.33&quot;,
        &quot;average_base_reduction&quot;: &quot;5.25&quot;
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
        \"email\",
        \"ifu\"
    ],
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"is_active\": true,
    \"credit_min\": 100000,
    \"credit_max\": 1000000,
    \"balance_min\": -50000,
    \"balance_max\": 500000,
    \"reduction_min\": 0,
    \"reduction_max\": 20,
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
        "email",
        "ifu"
    ],
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "is_active": true,
    "credit_min": 100000,
    "credit_max": 1000000,
    "balance_min": -50000,
    "balance_max": 500000,
    "reduction_min": 0,
    "reduction_max": 20,
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
                'ifu',
            ],
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'is_active' =&gt; true,
            'credit_min' =&gt; 100000.0,
            'credit_max' =&gt; 1000000.0,
            'balance_min' =&gt; -50000.0,
            'balance_max' =&gt; 500000.0,
            'reduction_min' =&gt; 0.0,
            'reduction_max' =&gt; 20.0,
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
            &quot;name_representant&quot;: &quot;Jane Smith&quot;,
            &quot;marketteur&quot;: &quot;Marie Dupont&quot;,
            &quot;email&quot;: &quot;john.doe@example.com&quot;,
            &quot;ifu&quot;: &quot;1234567890123&quot;,
            &quot;city&quot;: &quot;Cotonou&quot;,
            &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
            &quot;credit_limit&quot;: &quot;500000.00&quot;,
            &quot;current_balance&quot;: &quot;150000.00&quot;,
            &quot;base_reduction&quot;: &quot;5.00&quot;,
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
<p>optionnel Champs à rechercher (name_client, email, code, city, phonenumber, ifu, name_representant, marketteur).</p>
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
            <b style="line-height: 2;"><code>reduction_min</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="reduction_min"                data-endpoint="POSTapi-clients-search"
               value="0"
               data-component="body">
    <br>
<p>optionnel Réduction de base minimale (%). Example: <code>0</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reduction_max</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="reduction_max"                data-endpoint="POSTapi-clients-search"
               value="20"
               data-component="body">
    <br>
<p>optionnel Réduction de base maximale (%). Example: <code>20</code></p>
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

                    <h2 id="clients-management-GETapi-clients">Liste tous les clients</h2>

<p>
</p>

<p>Récupère la liste de tous les clients avec pagination et filtres optionnels.
Vous pouvez filtrer par nom, email, code, ville, IFU, marketteur, statut et type de client.</p>

<span id="example-requests-GETapi-clients">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clients?page=1&amp;per_page=15&amp;search=John&amp;name=John+Doe&amp;email=john%40example.com&amp;code=CLI-ABC123&amp;city=Cotonou&amp;ifu=1234567890123&amp;marketteur=Marie+Dupont&amp;client_type_id=550e8400-e29b-41d4-a716-446655440000&amp;is_active=1&amp;with_client_type=1&amp;balance_filter=positive" \
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
    \"ifu\": \"n\",
    \"marketteur\": \"i\",
    \"client_type_id\": \"51c7cf5e-fac2-3ac6-8ef8-61e6050503af\",
    \"is_active\": false,
    \"with_client_type\": true,
    \"balance_filter\": \"negative\"
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
    "ifu": "1234567890123",
    "marketteur": "Marie Dupont",
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
    "ifu": "n",
    "marketteur": "i",
    "client_type_id": "51c7cf5e-fac2-3ac6-8ef8-61e6050503af",
    "is_active": false,
    "with_client_type": true,
    "balance_filter": "negative"
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
            'ifu' =&gt; '1234567890123',
            'marketteur' =&gt; 'Marie Dupont',
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
            'ifu' =&gt; 'n',
            'marketteur' =&gt; 'i',
            'client_type_id' =&gt; '51c7cf5e-fac2-3ac6-8ef8-61e6050503af',
            'is_active' =&gt; false,
            'with_client_type' =&gt; true,
            'balance_filter' =&gt; 'negative',
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
            &quot;name_representant&quot;: &quot;Jane Smith&quot;,
            &quot;marketteur&quot;: &quot;Marie Dupont&quot;,
            &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
            &quot;adresse&quot;: &quot;123 Rue de la Paix&quot;,
            &quot;city&quot;: &quot;Cotonou&quot;,
            &quot;email&quot;: &quot;john.doe@example.com&quot;,
            &quot;ifu&quot;: &quot;1234567890123&quot;,
            &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
            &quot;credit_limit&quot;: &quot;500000.00&quot;,
            &quot;current_balance&quot;: &quot;150000.00&quot;,
            &quot;base_reduction&quot;: &quot;5.00&quot;,
            &quot;is_active&quot;: true,
            &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;updated_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
            &quot;formatted_credit_limit&quot;: &quot;500 000,00 FCFA&quot;,
            &quot;formatted_current_balance&quot;: &quot;150 000,00 FCFA&quot;,
            &quot;available_credit&quot;: &quot;350000.00&quot;,
            &quot;formatted_available_credit&quot;: &quot;350 000,00 FCFA&quot;,
            &quot;formatted_base_reduction&quot;: &quot;5,00 %&quot;
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
<p>Recherche globale (nom, email, code, IFU, représentant, marketteur). Example: <code>John</code></p>
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
                <b style="line-height: 2;"><code>ifu</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="ifu"                data-endpoint="GETapi-clients"
               value="1234567890123"
               data-component="query">
    <br>
<p>Rechercher par numéro IFU. Example: <code>1234567890123</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>marketteur</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="marketteur"                data-endpoint="GETapi-clients"
               value="Marie Dupont"
               data-component="query">
    <br>
<p>Rechercher par marketteur. Example: <code>Marie Dupont</code></p>
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
            <b style="line-height: 2;"><code>ifu</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="ifu"                data-endpoint="GETapi-clients"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>marketteur</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="marketteur"                data-endpoint="GETapi-clients"
               value="i"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>i</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="client_type_id"                data-endpoint="GETapi-clients"
               value="51c7cf5e-fac2-3ac6-8ef8-61e6050503af"
               data-component="body">
    <br>
<p>Must be a valid UUID. The <code>client_type_id</code> of an existing record in the client_types table. Example: <code>51c7cf5e-fac2-3ac6-8ef8-61e6050503af</code></p>
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
<p>Example: <code>false</code></p>
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
               value="negative"
               data-component="body">
    <br>
<p>Example: <code>negative</code></p>
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
    \"name_representant\": \"Jane Smith\",
    \"marketteur\": \"Marie Dupont\",
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"adresse\": \"123 Rue de la Paix\",
    \"city\": \"Cotonou\",
    \"email\": \"john.doe@example.com\",
    \"ifu\": \"1234567890123\",
    \"phonenumber\": \"+229 12 34 56 78\",
    \"credit_limit\": 500000,
    \"current_balance\": 0,
    \"base_reduction\": 5,
    \"is_active\": true
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
    "name_representant": "Jane Smith",
    "marketteur": "Marie Dupont",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "adresse": "123 Rue de la Paix",
    "city": "Cotonou",
    "email": "john.doe@example.com",
    "ifu": "1234567890123",
    "phonenumber": "+229 12 34 56 78",
    "credit_limit": 500000,
    "current_balance": 0,
    "base_reduction": 5,
    "is_active": true
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
            'name_representant' =&gt; 'Jane Smith',
            'marketteur' =&gt; 'Marie Dupont',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'adresse' =&gt; '123 Rue de la Paix',
            'city' =&gt; 'Cotonou',
            'email' =&gt; 'john.doe@example.com',
            'ifu' =&gt; '1234567890123',
            'phonenumber' =&gt; '+229 12 34 56 78',
            'credit_limit' =&gt; 500000.0,
            'current_balance' =&gt; 0.0,
            'base_reduction' =&gt; 5.0,
            'is_active' =&gt; true,
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
        &quot;code&quot;: &quot;CLI00001&quot;,
        &quot;name_client&quot;: &quot;John Doe&quot;,
        &quot;name_representant&quot;: &quot;Jane Smith&quot;,
        &quot;marketteur&quot;: &quot;Marie Dupont&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;123 Rue de la Paix&quot;,
        &quot;city&quot;: &quot;Cotonou&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;ifu&quot;: &quot;1234567890123&quot;,
        &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
        &quot;credit_limit&quot;: &quot;500000.00&quot;,
        &quot;current_balance&quot;: &quot;0.00&quot;,
        &quot;base_reduction&quot;: &quot;5.00&quot;,
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
        &quot;ifu&quot;: [
            &quot;Ce num&eacute;ro IFU est d&eacute;j&agrave; utilis&eacute;&quot;
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
            <b style="line-height: 2;"><code>name_representant</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name_representant"                data-endpoint="POSTapi-clients"
               value="Jane Smith"
               data-component="body">
    <br>
<p>optionnel Nom du représentant du client. Example: <code>Jane Smith</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>marketteur</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="marketteur"                data-endpoint="POSTapi-clients"
               value="Marie Dupont"
               data-component="body">
    <br>
<p>optionnel Nom du marketteur associé au client. Example: <code>Marie Dupont</code></p>
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
            <b style="line-height: 2;"><code>ifu</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="ifu"                data-endpoint="POSTapi-clients"
               value="1234567890123"
               data-component="body">
    <br>
<p>optionnel Numéro IFU (Identifiant Fiscal Unique). Example: <code>1234567890123</code></p>
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
            <b style="line-height: 2;"><code>base_reduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="base_reduction"                data-endpoint="POSTapi-clients"
               value="5"
               data-component="body">
    <br>
<p>optionnel Réduction de base en pourcentage (0-100, défaut: 0). Example: <code>5</code></p>
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
    \"with_client_type\": true
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
    "with_client_type": true
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
            'with_client_type' =&gt; true,
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
        &quot;code&quot;: &quot;CLI00001&quot;,
        &quot;name_client&quot;: &quot;John Doe&quot;,
        &quot;name_representant&quot;: &quot;Jane Smith&quot;,
        &quot;marketteur&quot;: &quot;Marie Dupont&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;123 Rue de la Paix&quot;,
        &quot;city&quot;: &quot;Cotonou&quot;,
        &quot;email&quot;: &quot;john.doe@example.com&quot;,
        &quot;ifu&quot;: &quot;1234567890123&quot;,
        &quot;phonenumber&quot;: &quot;+229 12 34 56 78&quot;,
        &quot;credit_limit&quot;: &quot;500000.00&quot;,
        &quot;current_balance&quot;: &quot;150000.00&quot;,
        &quot;base_reduction&quot;: &quot;5.00&quot;,
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
<p>Example: <code>true</code></p>
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
    \"name_representant\": \"John Smith\",
    \"marketteur\": \"Pierre Martin\",
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"adresse\": \"456 Avenue des Palmiers\",
    \"city\": \"Porto-Novo\",
    \"email\": \"jane.doe@example.com\",
    \"ifu\": \"9876543210987\",
    \"phonenumber\": \"+229 87 65 43 21\",
    \"credit_limit\": 750000,
    \"current_balance\": 200000,
    \"base_reduction\": 10,
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
    "name_representant": "John Smith",
    "marketteur": "Pierre Martin",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "adresse": "456 Avenue des Palmiers",
    "city": "Porto-Novo",
    "email": "jane.doe@example.com",
    "ifu": "9876543210987",
    "phonenumber": "+229 87 65 43 21",
    "credit_limit": 750000,
    "current_balance": 200000,
    "base_reduction": 10,
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
            'name_representant' =&gt; 'John Smith',
            'marketteur' =&gt; 'Pierre Martin',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'adresse' =&gt; '456 Avenue des Palmiers',
            'city' =&gt; 'Porto-Novo',
            'email' =&gt; 'jane.doe@example.com',
            'ifu' =&gt; '9876543210987',
            'phonenumber' =&gt; '+229 87 65 43 21',
            'credit_limit' =&gt; 750000.0,
            'current_balance' =&gt; 200000.0,
            'base_reduction' =&gt; 10.0,
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
        &quot;name_representant&quot;: &quot;John Smith&quot;,
        &quot;marketteur&quot;: &quot;Pierre Martin&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;456 Avenue des Palmiers&quot;,
        &quot;city&quot;: &quot;Porto-Novo&quot;,
        &quot;email&quot;: &quot;jane.doe@example.com&quot;,
        &quot;ifu&quot;: &quot;9876543210987&quot;,
        &quot;phonenumber&quot;: &quot;+229 87 65 43 21&quot;,
        &quot;credit_limit&quot;: &quot;750000.00&quot;,
        &quot;current_balance&quot;: &quot;200000.00&quot;,
        &quot;base_reduction&quot;: &quot;10.00&quot;,
        &quot;is_active&quot;: false,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;
    },
    &quot;message&quot;: &quot;Client mis &agrave; jour avec succ&egrave;s&quot;
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
        &quot;ifu&quot;: [
            &quot;Ce num&eacute;ro IFU est d&eacute;j&agrave; utilis&eacute;&quot;
        ]
    }
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
            <b style="line-height: 2;"><code>name_representant</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name_representant"                data-endpoint="PUTapi-clients--client_id-"
               value="John Smith"
               data-component="body">
    <br>
<p>Nom du représentant du client. Example: <code>John Smith</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>marketteur</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="marketteur"                data-endpoint="PUTapi-clients--client_id-"
               value="Pierre Martin"
               data-component="body">
    <br>
<p>Nom du marketteur associé. Example: <code>Pierre Martin</code></p>
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
            <b style="line-height: 2;"><code>ifu</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="ifu"                data-endpoint="PUTapi-clients--client_id-"
               value="9876543210987"
               data-component="body">
    <br>
<p>Numéro IFU unique. Example: <code>9876543210987</code></p>
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
            <b style="line-height: 2;"><code>base_reduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="base_reduction"                data-endpoint="PUTapi-clients--client_id-"
               value="10"
               data-component="body">
    <br>
<p>Réduction de base en pourcentage (0-100). Example: <code>10</code></p>
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
    \"name_representant\": \"John Smith\",
    \"marketteur\": \"Pierre Martin\",
    \"client_type_id\": \"550e8400-e29b-41d4-a716-446655440000\",
    \"adresse\": \"456 Avenue des Palmiers\",
    \"city\": \"Porto-Novo\",
    \"email\": \"jane.doe@example.com\",
    \"ifu\": \"9876543210987\",
    \"phonenumber\": \"+229 87 65 43 21\",
    \"credit_limit\": 750000,
    \"current_balance\": 200000,
    \"base_reduction\": 10,
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
    "name_representant": "John Smith",
    "marketteur": "Pierre Martin",
    "client_type_id": "550e8400-e29b-41d4-a716-446655440000",
    "adresse": "456 Avenue des Palmiers",
    "city": "Porto-Novo",
    "email": "jane.doe@example.com",
    "ifu": "9876543210987",
    "phonenumber": "+229 87 65 43 21",
    "credit_limit": 750000,
    "current_balance": 200000,
    "base_reduction": 10,
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
            'name_representant' =&gt; 'John Smith',
            'marketteur' =&gt; 'Pierre Martin',
            'client_type_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'adresse' =&gt; '456 Avenue des Palmiers',
            'city' =&gt; 'Porto-Novo',
            'email' =&gt; 'jane.doe@example.com',
            'ifu' =&gt; '9876543210987',
            'phonenumber' =&gt; '+229 87 65 43 21',
            'credit_limit' =&gt; 750000.0,
            'current_balance' =&gt; 200000.0,
            'base_reduction' =&gt; 10.0,
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
        &quot;name_representant&quot;: &quot;John Smith&quot;,
        &quot;marketteur&quot;: &quot;Pierre Martin&quot;,
        &quot;client_type_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;adresse&quot;: &quot;456 Avenue des Palmiers&quot;,
        &quot;city&quot;: &quot;Porto-Novo&quot;,
        &quot;email&quot;: &quot;jane.doe@example.com&quot;,
        &quot;ifu&quot;: &quot;9876543210987&quot;,
        &quot;phonenumber&quot;: &quot;+229 87 65 43 21&quot;,
        &quot;credit_limit&quot;: &quot;750000.00&quot;,
        &quot;current_balance&quot;: &quot;200000.00&quot;,
        &quot;base_reduction&quot;: &quot;10.00&quot;,
        &quot;is_active&quot;: false,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:00:00Z&quot;
    },
    &quot;message&quot;: &quot;Client mis &agrave; jour avec succ&egrave;s&quot;
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
        &quot;ifu&quot;: [
            &quot;Ce num&eacute;ro IFU est d&eacute;j&agrave; utilis&eacute;&quot;
        ]
    }
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
            <b style="line-height: 2;"><code>name_representant</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name_representant"                data-endpoint="PATCHapi-clients--client_id-"
               value="John Smith"
               data-component="body">
    <br>
<p>Nom du représentant du client. Example: <code>John Smith</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>marketteur</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="marketteur"                data-endpoint="PATCHapi-clients--client_id-"
               value="Pierre Martin"
               data-component="body">
    <br>
<p>Nom du marketteur associé. Example: <code>Pierre Martin</code></p>
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
            <b style="line-height: 2;"><code>ifu</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="ifu"                data-endpoint="PATCHapi-clients--client_id-"
               value="9876543210987"
               data-component="body">
    <br>
<p>Numéro IFU unique. Example: <code>9876543210987</code></p>
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
            <b style="line-height: 2;"><code>base_reduction</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="base_reduction"                data-endpoint="PATCHapi-clients--client_id-"
               value="10"
               data-component="body">
    <br>
<p>Réduction de base en pourcentage (0-100). Example: <code>10</code></p>
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
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Ce client n&#039;est pas supprim&eacute;&quot;
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
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Client non trouv&eacute;&quot;
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
        &quot;available_credit&quot;: &quot;300000.00&quot;,
        &quot;description&quot;: &quot;Paiement facture&quot;
    },
    &quot;message&quot;: &quot;Solde mis &agrave; jour avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Le montant d&eacute;passerait la limite de cr&eacute;dit autoris&eacute;e&quot;,
    &quot;data&quot;: {
        &quot;current_balance&quot;: &quot;150000.00&quot;,
        &quot;credit_limit&quot;: &quot;500000.00&quot;,
        &quot;available_credit&quot;: &quot;350000.00&quot;,
        &quot;requested_amount&quot;: &quot;400000.00&quot;
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

                <h1 id="gestion-des-stocks">Gestion des Stocks</h1>

    <p>APIs pour la gestion des stocks de produits dans les entrepôts</p>

                                <h2 id="gestion-des-stocks-GETapi-stocks">Lister tous les stocks</h2>

<p>
</p>

<p>Récupère la liste de tous les stocks avec pagination et filtres optionnels</p>

<span id="example-requests-GETapi-stocks">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stocks?page=1&amp;per_page=15&amp;product_id=550e8400-e29b-41d4-a716-446655440000&amp;entrepot_id=550e8400-e29b-41d4-a716-446655440001&amp;quantite_min=10&amp;quantite_max=100" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"page\": 16,
    \"per_page\": 22,
    \"product_id\": \"6b72fe4a-5b40-307c-bc24-f79acf9a1bb9\",
    \"entrepot_id\": \"977e5426-8d13-3824-86aa-b092f8ae52c5\",
    \"quantite_min\": 76,
    \"quantite_max\": 60
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks"
);

const params = {
    "page": "1",
    "per_page": "15",
    "product_id": "550e8400-e29b-41d4-a716-446655440000",
    "entrepot_id": "550e8400-e29b-41d4-a716-446655440001",
    "quantite_min": "10",
    "quantite_max": "100",
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
    "product_id": "6b72fe4a-5b40-307c-bc24-f79acf9a1bb9",
    "entrepot_id": "977e5426-8d13-3824-86aa-b092f8ae52c5",
    "quantite_min": 76,
    "quantite_max": 60
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stocks';
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
            'product_id' =&gt; '550e8400-e29b-41d4-a716-446655440000',
            'entrepot_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
            'quantite_min' =&gt; '10',
            'quantite_max' =&gt; '100',
        ],
        'json' =&gt; [
            'page' =&gt; 16,
            'per_page' =&gt; 22,
            'product_id' =&gt; '6b72fe4a-5b40-307c-bc24-f79acf9a1bb9',
            'entrepot_id' =&gt; '977e5426-8d13-3824-86aa-b092f8ae52c5',
            'quantite_min' =&gt; 76,
            'quantite_max' =&gt; 60,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-stocks">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;current_page&quot;: 1,
        &quot;data&quot;: [
            {
                &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
                &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
                &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
                &quot;quantite&quot;: 50,
                &quot;reserved_quantity&quot;: 5,
                &quot;available_quantity&quot;: 45,
                &quot;created_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;,
                &quot;product&quot;: {
                    &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
                    &quot;name&quot;: &quot;Produit Example&quot;
                },
                &quot;entrepot&quot;: {
                    &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
                    &quot;name&quot;: &quot;Entrep&ocirc;t Principal&quot;
                }
            }
        ],
        &quot;per_page&quot;: 15,
        &quot;total&quot;: 1
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stocks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stocks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stocks"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stocks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stocks">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stocks" data-method="GET"
      data-path="api/stocks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stocks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stocks"
                    onclick="tryItOut('GETapi-stocks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stocks"
                    onclick="cancelTryOut('GETapi-stocks');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stocks"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stocks</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stocks"
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
                              name="Accept"                data-endpoint="GETapi-stocks"
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
               step="any"               name="page"                data-endpoint="GETapi-stocks"
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
               step="any"               name="per_page"                data-endpoint="GETapi-stocks"
               value="15"
               data-component="query">
    <br>
<p>Nombre d'éléments par page (max 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="GETapi-stocks"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="query">
    <br>
<p>Filtrer par ID du produit. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>entrepot_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_id"                data-endpoint="GETapi-stocks"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="query">
    <br>
<p>Filtrer par ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>quantite_min</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantite_min"                data-endpoint="GETapi-stocks"
               value="10"
               data-component="query">
    <br>
<p>Quantité minimum. Example: <code>10</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>quantite_max</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantite_max"                data-endpoint="GETapi-stocks"
               value="100"
               data-component="query">
    <br>
<p>Quantité maximum. Example: <code>100</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-stocks"
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
               step="any"               name="per_page"                data-endpoint="GETapi-stocks"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="GETapi-stocks"
               value="6b72fe4a-5b40-307c-bc24-f79acf9a1bb9"
               data-component="body">
    <br>
<p>Must be a valid UUID. Example: <code>6b72fe4a-5b40-307c-bc24-f79acf9a1bb9</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>entrepot_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_id"                data-endpoint="GETapi-stocks"
               value="977e5426-8d13-3824-86aa-b092f8ae52c5"
               data-component="body">
    <br>
<p>Must be a valid UUID. Example: <code>977e5426-8d13-3824-86aa-b092f8ae52c5</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantite_min</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantite_min"                data-endpoint="GETapi-stocks"
               value="76"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantite_max</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantite_max"                data-endpoint="GETapi-stocks"
               value="60"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>60</code></p>
        </div>
        </form>

                    <h2 id="gestion-des-stocks-POSTapi-stocks">Créer un nouveau stock</h2>

<p>
</p>

<p>Crée un nouveau stock pour un produit dans un entrepôt</p>

<span id="example-requests-POSTapi-stocks">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stocks" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"product_id\": \"550e8400-e29b-41d4-a716-446655440001\",
    \"entrepot_id\": \"550e8400-e29b-41d4-a716-446655440002\",
    \"quantite\": 100,
    \"reserved_quantity\": 10
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_id": "550e8400-e29b-41d4-a716-446655440001",
    "entrepot_id": "550e8400-e29b-41d4-a716-446655440002",
    "quantite": 100,
    "reserved_quantity": 10
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stocks';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'product_id' =&gt; '550e8400-e29b-41d4-a716-446655440001',
            'entrepot_id' =&gt; '550e8400-e29b-41d4-a716-446655440002',
            'quantite' =&gt; 100,
            'reserved_quantity' =&gt; 10,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stocks">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Stock cr&eacute;&eacute; avec succ&egrave;s&quot;,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
        &quot;quantite&quot;: 100,
        &quot;reserved_quantity&quot;: 10,
        &quot;available_quantity&quot;: 90,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Erreur de validation&quot;,
    &quot;errors&quot;: {
        &quot;product_id&quot;: [
            &quot;Le champ product_id est requis.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stocks" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stocks"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stocks"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stocks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stocks">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stocks" data-method="POST"
      data-path="api/stocks"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stocks', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stocks"
                    onclick="tryItOut('POSTapi-stocks');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stocks"
                    onclick="cancelTryOut('POSTapi-stocks');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stocks"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stocks</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stocks"
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
                              name="Accept"                data-endpoint="POSTapi-stocks"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="POSTapi-stocks"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="body">
    <br>
<p>L'ID du produit. Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>entrepot_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="entrepot_id"                data-endpoint="POSTapi-stocks"
               value="550e8400-e29b-41d4-a716-446655440002"
               data-component="body">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440002</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantite</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantite"                data-endpoint="POSTapi-stocks"
               value="100"
               data-component="body">
    <br>
<p>La quantité en stock. Example: <code>100</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reserved_quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="reserved_quantity"                data-endpoint="POSTapi-stocks"
               value="10"
               data-component="body">
    <br>
<p>La quantité réservée (optionnel, défaut: 0). Example: <code>10</code></p>
        </div>
        </form>

                    <h2 id="gestion-des-stocks-GETapi-stocks--id-">Afficher un stock spécifique</h2>

<p>
</p>

<p>Récupère les détails d'un stock par son ID</p>

<span id="example-requests-GETapi-stocks--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stocks/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/architecto"
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
$url = 'http://localhost/api/stocks/architecto';
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

<span id="example-responses-GETapi-stocks--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
        &quot;quantite&quot;: 50,
        &quot;reserved_quantity&quot;: 5,
        &quot;available_quantity&quot;: 45,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;,
        &quot;product&quot;: {
            &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
            &quot;name&quot;: &quot;Produit Example&quot;
        },
        &quot;entrepot&quot;: {
            &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
            &quot;name&quot;: &quot;Entrep&ocirc;t Principal&quot;
        }
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stocks--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stocks--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stocks--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stocks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stocks--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stocks--id-" data-method="GET"
      data-path="api/stocks/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stocks--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stocks--id-"
                    onclick="tryItOut('GETapi-stocks--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stocks--id-"
                    onclick="cancelTryOut('GETapi-stocks--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stocks--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stocks/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stocks--id-"
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
                              name="Accept"                data-endpoint="GETapi-stocks--id-"
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
                              name="id"                data-endpoint="GETapi-stocks--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_id"                data-endpoint="GETapi-stocks--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="gestion-des-stocks-PUTapi-stocks--id-">Mettre à jour un stock</h2>

<p>
</p>

<p>Met à jour les informations d'un stock existant</p>

<span id="example-requests-PUTapi-stocks--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/stocks/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"quantite\": 75,
    \"reserved_quantity\": 15
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/architecto"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quantite": 75,
    "reserved_quantity": 15
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stocks/architecto';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'quantite' =&gt; 75,
            'reserved_quantity' =&gt; 15,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-stocks--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Stock mis &agrave; jour avec succ&egrave;s&quot;,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
        &quot;quantite&quot;: 75,
        &quot;reserved_quantity&quot;: 15,
        &quot;available_quantity&quot;: 60,
        &quot;created_at&quot;: &quot;2024-01-15T10:30:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2024-01-15T11:45:00.000000Z&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-stocks--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-stocks--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-stocks--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-stocks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-stocks--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-stocks--id-" data-method="PUT"
      data-path="api/stocks/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-stocks--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-stocks--id-"
                    onclick="tryItOut('PUTapi-stocks--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-stocks--id-"
                    onclick="cancelTryOut('PUTapi-stocks--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-stocks--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/stocks/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-stocks--id-"
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
                              name="Accept"                data-endpoint="PUTapi-stocks--id-"
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
                              name="id"                data-endpoint="PUTapi-stocks--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_id"                data-endpoint="PUTapi-stocks--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantite</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantite"                data-endpoint="PUTapi-stocks--id-"
               value="75"
               data-component="body">
    <br>
<p>La nouvelle quantité en stock. Example: <code>75</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reserved_quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="reserved_quantity"                data-endpoint="PUTapi-stocks--id-"
               value="15"
               data-component="body">
    <br>
<p>La nouvelle quantité réservée. Example: <code>15</code></p>
        </div>
        </form>

                    <h2 id="gestion-des-stocks-DELETEapi-stocks--id-">Supprimer un stock</h2>

<p>
</p>

<p>Supprime un stock de manière définitive</p>

<span id="example-requests-DELETEapi-stocks--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/stocks/architecto" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/architecto"
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
$url = 'http://localhost/api/stocks/architecto';
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

<span id="example-responses-DELETEapi-stocks--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Stock supprim&eacute; avec succ&egrave;s&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-stocks--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-stocks--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-stocks--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-stocks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-stocks--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-stocks--id-" data-method="DELETE"
      data-path="api/stocks/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-stocks--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-stocks--id-"
                    onclick="tryItOut('DELETEapi-stocks--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-stocks--id-"
                    onclick="cancelTryOut('DELETEapi-stocks--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-stocks--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/stocks/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-stocks--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-stocks--id-"
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
                              name="id"                data-endpoint="DELETEapi-stocks--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_id"                data-endpoint="DELETEapi-stocks--id-"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock à supprimer. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="gestion-des-stocks-POSTapi-stocks--id--adjust">Ajuster la quantité en stock</h2>

<p>
</p>

<p>Ajuste la quantité d'un stock (ajout ou retrait)</p>

<span id="example-requests-POSTapi-stocks--id--adjust">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stocks/architecto/adjust" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"adjustment\": -10,
    \"reason\": \"\\\"Inventaire physique\\\"\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/architecto/adjust"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "adjustment": -10,
    "reason": "\"Inventaire physique\""
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stocks/architecto/adjust';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'adjustment' =&gt; -10,
            'reason' =&gt; '"Inventaire physique"',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stocks--id--adjust">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Quantit&eacute; ajust&eacute;e avec succ&egrave;s&quot;,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
        &quot;quantite&quot;: 40,
        &quot;reserved_quantity&quot;: 5,
        &quot;available_quantity&quot;: 35,
        &quot;previous_quantity&quot;: 50,
        &quot;adjustment&quot;: -10,
        &quot;reason&quot;: &quot;Inventaire physique&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Quantit&eacute; insuffisante pour cet ajustement&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stocks--id--adjust" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stocks--id--adjust"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stocks--id--adjust"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stocks--id--adjust" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stocks--id--adjust">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stocks--id--adjust" data-method="POST"
      data-path="api/stocks/{id}/adjust"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stocks--id--adjust', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stocks--id--adjust"
                    onclick="tryItOut('POSTapi-stocks--id--adjust');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stocks--id--adjust"
                    onclick="cancelTryOut('POSTapi-stocks--id--adjust');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stocks--id--adjust"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stocks/{id}/adjust</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stocks--id--adjust"
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
                              name="Accept"                data-endpoint="POSTapi-stocks--id--adjust"
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
                              name="id"                data-endpoint="POSTapi-stocks--id--adjust"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_id"                data-endpoint="POSTapi-stocks--id--adjust"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>adjustment</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="adjustment"                data-endpoint="POSTapi-stocks--id--adjust"
               value="-10"
               data-component="body">
    <br>
<p>L'ajustement à appliquer (positif pour ajout, négatif pour retrait). Example: <code>-10</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reason</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="reason"                data-endpoint="POSTapi-stocks--id--adjust"
               value=""Inventaire physique""
               data-component="body">
    <br>
<p>La raison de l'ajustement. Example: <code>"Inventaire physique"</code></p>
        </div>
        </form>

                    <h2 id="gestion-des-stocks-POSTapi-stocks--id--reserve">Réserver une quantité</h2>

<p>
</p>

<p>Réserve une quantité spécifique du stock</p>

<span id="example-requests-POSTapi-stocks--id--reserve">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stocks/architecto/reserve" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"quantity\": 5
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/architecto/reserve"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quantity": 5
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stocks/architecto/reserve';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'quantity' =&gt; 5,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stocks--id--reserve">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Quantit&eacute; r&eacute;serv&eacute;e avec succ&egrave;s&quot;,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;quantite&quot;: 50,
        &quot;reserved_quantity&quot;: 10,
        &quot;available_quantity&quot;: 40
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Quantit&eacute; disponible insuffisante&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stocks--id--reserve" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stocks--id--reserve"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stocks--id--reserve"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stocks--id--reserve" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stocks--id--reserve">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stocks--id--reserve" data-method="POST"
      data-path="api/stocks/{id}/reserve"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stocks--id--reserve', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stocks--id--reserve"
                    onclick="tryItOut('POSTapi-stocks--id--reserve');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stocks--id--reserve"
                    onclick="cancelTryOut('POSTapi-stocks--id--reserve');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stocks--id--reserve"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stocks/{id}/reserve</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stocks--id--reserve"
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
                              name="Accept"                data-endpoint="POSTapi-stocks--id--reserve"
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
                              name="id"                data-endpoint="POSTapi-stocks--id--reserve"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_id"                data-endpoint="POSTapi-stocks--id--reserve"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-stocks--id--reserve"
               value="5"
               data-component="body">
    <br>
<p>La quantité à réserver. Example: <code>5</code></p>
        </div>
        </form>

                    <h2 id="gestion-des-stocks-POSTapi-stocks--id--release">Libérer une réservation</h2>

<p>
</p>

<p>Libère une quantité réservée du stock</p>

<span id="example-requests-POSTapi-stocks--id--release">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/stocks/architecto/release" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"quantity\": 3
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/architecto/release"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "quantity": 3
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/stocks/architecto/release';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'quantity' =&gt; 3,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-stocks--id--release">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;R&eacute;servation lib&eacute;r&eacute;e avec succ&egrave;s&quot;,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;quantite&quot;: 50,
        &quot;reserved_quantity&quot;: 7,
        &quot;available_quantity&quot;: 43
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Quantit&eacute; r&eacute;serv&eacute;e insuffisante&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-stocks--id--release" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-stocks--id--release"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-stocks--id--release"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-stocks--id--release" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-stocks--id--release">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-stocks--id--release" data-method="POST"
      data-path="api/stocks/{id}/release"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-stocks--id--release', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-stocks--id--release"
                    onclick="tryItOut('POSTapi-stocks--id--release');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-stocks--id--release"
                    onclick="cancelTryOut('POSTapi-stocks--id--release');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-stocks--id--release"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/stocks/{id}/release</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-stocks--id--release"
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
                              name="Accept"                data-endpoint="POSTapi-stocks--id--release"
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
                              name="id"                data-endpoint="POSTapi-stocks--id--release"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the stock. Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stock_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stock_id"                data-endpoint="POSTapi-stocks--id--release"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-stocks--id--release"
               value="3"
               data-component="body">
    <br>
<p>La quantité à libérer. Example: <code>3</code></p>
        </div>
        </form>

                    <h2 id="gestion-des-stocks-GETapi-stocks-product--productId-">Stocks par produit</h2>

<p>
</p>

<p>Récupère tous les stocks d'un produit spécifique</p>

<span id="example-requests-GETapi-stocks-product--productId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stocks/product/550e8400-e29b-41d4-a716-446655440001" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/product/550e8400-e29b-41d4-a716-446655440001"
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
$url = 'http://localhost/api/stocks/product/550e8400-e29b-41d4-a716-446655440001';
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

<span id="example-responses-GETapi-stocks-product--productId-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: [
        {
            &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
            &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
            &quot;quantite&quot;: 50,
            &quot;reserved_quantity&quot;: 5,
            &quot;available_quantity&quot;: 45,
            &quot;entrepot&quot;: {
                &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
                &quot;name&quot;: &quot;Entrep&ocirc;t Principal&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stocks-product--productId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stocks-product--productId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stocks-product--productId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stocks-product--productId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stocks-product--productId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stocks-product--productId-" data-method="GET"
      data-path="api/stocks/product/{productId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stocks-product--productId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stocks-product--productId-"
                    onclick="tryItOut('GETapi-stocks-product--productId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stocks-product--productId-"
                    onclick="cancelTryOut('GETapi-stocks-product--productId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stocks-product--productId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stocks/product/{productId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stocks-product--productId-"
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
                              name="Accept"                data-endpoint="GETapi-stocks-product--productId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>productId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="productId"                data-endpoint="GETapi-stocks-product--productId-"
               value="550e8400-e29b-41d4-a716-446655440001"
               data-component="url">
    <br>
<p>L'ID du produit. Example: <code>550e8400-e29b-41d4-a716-446655440001</code></p>
            </div>
                    </form>

                    <h2 id="gestion-des-stocks-GETapi-stocks-entrepot--entrepotId-">Stocks par entrepôt</h2>

<p>
</p>

<p>Récupère tous les stocks d'un entrepôt spécifique</p>

<span id="example-requests-GETapi-stocks-entrepot--entrepotId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stocks/entrepot/550e8400-e29b-41d4-a716-446655440002" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/entrepot/550e8400-e29b-41d4-a716-446655440002"
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
$url = 'http://localhost/api/stocks/entrepot/550e8400-e29b-41d4-a716-446655440002';
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

<span id="example-responses-GETapi-stocks-entrepot--entrepotId-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: [
        {
            &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
            &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
            &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
            &quot;quantite&quot;: 50,
            &quot;reserved_quantity&quot;: 5,
            &quot;available_quantity&quot;: 45,
            &quot;product&quot;: {
                &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
                &quot;name&quot;: &quot;Produit Example&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stocks-entrepot--entrepotId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stocks-entrepot--entrepotId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stocks-entrepot--entrepotId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stocks-entrepot--entrepotId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stocks-entrepot--entrepotId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stocks-entrepot--entrepotId-" data-method="GET"
      data-path="api/stocks/entrepot/{entrepotId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stocks-entrepot--entrepotId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stocks-entrepot--entrepotId-"
                    onclick="tryItOut('GETapi-stocks-entrepot--entrepotId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stocks-entrepot--entrepotId-"
                    onclick="cancelTryOut('GETapi-stocks-entrepot--entrepotId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stocks-entrepot--entrepotId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stocks/entrepot/{entrepotId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stocks-entrepot--entrepotId-"
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
                              name="Accept"                data-endpoint="GETapi-stocks-entrepot--entrepotId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>entrepotId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="entrepotId"                data-endpoint="GETapi-stocks-entrepot--entrepotId-"
               value="550e8400-e29b-41d4-a716-446655440002"
               data-component="url">
    <br>
<p>L'ID de l'entrepôt. Example: <code>550e8400-e29b-41d4-a716-446655440002</code></p>
            </div>
                    </form>

                    <h2 id="gestion-des-stocks-GETapi-stocks--id--restore">Restaurer un stock supprimé</h2>

<p>
</p>

<p>Restaure un stock qui a été supprimé de manière logique</p>

<span id="example-requests-GETapi-stocks--id--restore">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/stocks/550e8400-e29b-41d4-a716-446655440000/restore" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/550e8400-e29b-41d4-a716-446655440000/restore"
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
$url = 'http://localhost/api/stocks/550e8400-e29b-41d4-a716-446655440000/restore';
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

<span id="example-responses-GETapi-stocks--id--restore">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Stock restaur&eacute; avec succ&egrave;s&quot;,
    &quot;data&quot;: {
        &quot;stock_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440000&quot;,
        &quot;product_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440001&quot;,
        &quot;entrepot_id&quot;: &quot;550e8400-e29b-41d4-a716-446655440002&quot;,
        &quot;quantite&quot;: 50,
        &quot;reserved_quantity&quot;: 5,
        &quot;available_quantity&quot;: 45
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-stocks--id--restore" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-stocks--id--restore"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-stocks--id--restore"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-stocks--id--restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-stocks--id--restore">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-stocks--id--restore" data-method="GET"
      data-path="api/stocks/{id}/restore"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-stocks--id--restore', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-stocks--id--restore"
                    onclick="tryItOut('GETapi-stocks--id--restore');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-stocks--id--restore"
                    onclick="cancelTryOut('GETapi-stocks--id--restore');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-stocks--id--restore"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/stocks/{id}/restore</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-stocks--id--restore"
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
                              name="Accept"                data-endpoint="GETapi-stocks--id--restore"
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
                              name="id"                data-endpoint="GETapi-stocks--id--restore"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock à restaurer. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                    <h2 id="gestion-des-stocks-DELETEapi-stocks--id--force">Suppression définitive d&#039;un stock</h2>

<p>
</p>

<p>Supprime définitivement un stock de la base de données</p>

<span id="example-requests-DELETEapi-stocks--id--force">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/stocks/550e8400-e29b-41d4-a716-446655440000/force" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/stocks/550e8400-e29b-41d4-a716-446655440000/force"
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
$url = 'http://localhost/api/stocks/550e8400-e29b-41d4-a716-446655440000/force';
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

<span id="example-responses-DELETEapi-stocks--id--force">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Stock supprim&eacute; d&eacute;finitivement&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Stock non trouv&eacute;&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-stocks--id--force" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-stocks--id--force"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-stocks--id--force"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-stocks--id--force" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-stocks--id--force">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-stocks--id--force" data-method="DELETE"
      data-path="api/stocks/{id}/force"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-stocks--id--force', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-stocks--id--force"
                    onclick="tryItOut('DELETEapi-stocks--id--force');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-stocks--id--force"
                    onclick="cancelTryOut('DELETEapi-stocks--id--force');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-stocks--id--force"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/stocks/{id}/force</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-stocks--id--force"
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
                              name="Accept"                data-endpoint="DELETEapi-stocks--id--force"
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
                              name="id"                data-endpoint="DELETEapi-stocks--id--force"
               value="550e8400-e29b-41d4-a716-446655440000"
               data-component="url">
    <br>
<p>L'ID du stock à supprimer définitivement. Example: <code>550e8400-e29b-41d4-a716-446655440000</code></p>
            </div>
                    </form>

                <h1 id="product-categories">Product Categories</h1>

    

                                <h2 id="product-categories-GETapi-product-categories">Afficher toutes les catégories de produits</h2>

<p>
</p>



<span id="example-requests-GETapi-product-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/product-categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/product-categories"
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
$url = 'http://localhost/api/product-categories';
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

<span id="example-responses-GETapi-product-categories">
            <blockquote>
            <p>Example response (200, Liste des catégories):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;product_category_id&quot;: &quot;uuid&quot;,
        &quot;label&quot;: &quot;&Eacute;lectronique&quot;,
        &quot;description&quot;: &quot;Produits high-tech&quot;,
        &quot;is_active&quot;: true,
        &quot;created_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-product-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-product-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-product-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-product-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-product-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-product-categories" data-method="GET"
      data-path="api/product-categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-product-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-product-categories"
                    onclick="tryItOut('GETapi-product-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-product-categories"
                    onclick="cancelTryOut('GETapi-product-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-product-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/product-categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-product-categories"
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
                              name="Accept"                data-endpoint="GETapi-product-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="product-categories-POSTapi-product-categories">Créer une nouvelle catégorie de produit</h2>

<p>
</p>



<span id="example-requests-POSTapi-product-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/product-categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Électronique\",
    \"description\": \"Produits high-tech\",
    \"is_active\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/product-categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Électronique",
    "description": "Produits high-tech",
    "is_active": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/product-categories';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Électronique',
            'description' =&gt; 'Produits high-tech',
            'is_active' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-product-categories">
            <blockquote>
            <p>Example response (201, Succès):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;product_category_id&quot;: &quot;uuid&quot;,
    &quot;label&quot;: &quot;&Eacute;lectronique&quot;,
    &quot;description&quot;: &quot;Produits high-tech&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-product-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-product-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-product-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-product-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-product-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-product-categories" data-method="POST"
      data-path="api/product-categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-product-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-product-categories"
                    onclick="tryItOut('POSTapi-product-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-product-categories"
                    onclick="cancelTryOut('POSTapi-product-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-product-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/product-categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-product-categories"
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
                              name="Accept"                data-endpoint="POSTapi-product-categories"
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
                              name="label"                data-endpoint="POSTapi-product-categories"
               value="Électronique"
               data-component="body">
    <br>
<p>Nom de la catégorie. Example: <code>Électronique</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-product-categories"
               value="Produits high-tech"
               data-component="body">
    <br>
<p>Description de la catégorie. Example: <code>Produits high-tech</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-product-categories" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="POSTapi-product-categories"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-product-categories" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="POSTapi-product-categories"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif ou non (true/false). Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="product-categories-GETapi-product-categories--id-">Afficher une catégorie de produit</h2>

<p>
</p>



<span id="example-requests-GETapi-product-categories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4"
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
$url = 'http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4';
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

<span id="example-responses-GETapi-product-categories--id-">
            <blockquote>
            <p>Example response (200, Succès):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;product_category_id&quot;: &quot;uuid&quot;,
    &quot;label&quot;: &quot;&Eacute;lectronique&quot;,
    &quot;description&quot;: &quot;Produits high-tech&quot;,
    &quot;is_active&quot;: true,
    &quot;created_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-product-categories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-product-categories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-product-categories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-product-categories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-product-categories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-product-categories--id-" data-method="GET"
      data-path="api/product-categories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-product-categories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-product-categories--id-"
                    onclick="tryItOut('GETapi-product-categories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-product-categories--id-"
                    onclick="cancelTryOut('GETapi-product-categories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-product-categories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/product-categories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-product-categories--id-"
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
                              name="Accept"                data-endpoint="GETapi-product-categories--id-"
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
                              name="id"                data-endpoint="GETapi-product-categories--id-"
               value="9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4"
               data-component="url">
    <br>
<p>L'UUID de la catégorie. Example: <code>9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4</code></p>
            </div>
                    </form>

                    <h2 id="product-categories-PUTapi-product-categories--id-">Mettre à jour une catégorie de produit</h2>

<p>
</p>



<span id="example-requests-PUTapi-product-categories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"label\": \"Accessoires\",
    \"description\": \"Produits dérivés\",
    \"is_active\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "label": "Accessoires",
    "description": "Produits dérivés",
    "is_active": false
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'label' =&gt; 'Accessoires',
            'description' =&gt; 'Produits dérivés',
            'is_active' =&gt; false,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-PUTapi-product-categories--id-">
            <blockquote>
            <p>Example response (200, Succès):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;product_category_id&quot;: &quot;uuid&quot;,
    &quot;label&quot;: &quot;Accessoires&quot;,
    &quot;description&quot;: &quot;Produits d&eacute;riv&eacute;s&quot;,
    &quot;is_active&quot;: false,
    &quot;created_at&quot;: &quot;2025-09-24T12:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2025-09-24T12:30:00.000000Z&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-product-categories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-product-categories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-product-categories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-product-categories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-product-categories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-product-categories--id-" data-method="PUT"
      data-path="api/product-categories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-product-categories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-product-categories--id-"
                    onclick="tryItOut('PUTapi-product-categories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-product-categories--id-"
                    onclick="cancelTryOut('PUTapi-product-categories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-product-categories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/product-categories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-product-categories--id-"
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
                              name="Accept"                data-endpoint="PUTapi-product-categories--id-"
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
                              name="id"                data-endpoint="PUTapi-product-categories--id-"
               value="9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4"
               data-component="url">
    <br>
<p>L'UUID de la catégorie. Example: <code>9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>label</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="label"                data-endpoint="PUTapi-product-categories--id-"
               value="Accessoires"
               data-component="body">
    <br>
<p>Nom de la catégorie (unique). Example: <code>Accessoires</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-product-categories--id-"
               value="Produits dérivés"
               data-component="body">
    <br>
<p>Description de la catégorie. Example: <code>Produits dérivés</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_active</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="PUTapi-product-categories--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="true"
                   data-endpoint="PUTapi-product-categories--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-product-categories--id-" style="display: none">
            <input type="radio" name="is_active"
                   value="false"
                   data-endpoint="PUTapi-product-categories--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Statut actif ou non (true/false). Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="product-categories-DELETEapi-product-categories--id-">Supprimer une catégorie de produit</h2>

<p>
</p>



<span id="example-requests-DELETEapi-product-categories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4"
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
$url = 'http://localhost/api/product-categories/9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4';
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

<span id="example-responses-DELETEapi-product-categories--id-">
            <blockquote>
            <p>Example response (200, Succès):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Cat&eacute;gorie supprim&eacute;e avec succ&egrave;s.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-product-categories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-product-categories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-product-categories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-product-categories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-product-categories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-product-categories--id-" data-method="DELETE"
      data-path="api/product-categories/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-product-categories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-product-categories--id-"
                    onclick="tryItOut('DELETEapi-product-categories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-product-categories--id-"
                    onclick="cancelTryOut('DELETEapi-product-categories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-product-categories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/product-categories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-product-categories--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-product-categories--id-"
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
                              name="id"                data-endpoint="DELETEapi-product-categories--id-"
               value="9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4"
               data-component="url">
    <br>
<p>L'UUID de la catégorie. Example: <code>9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4</code></p>
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
