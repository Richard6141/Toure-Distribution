# Implémentation API Payment Methods et Factures

## 📋 Résumé

Ce document décrit l'implémentation complète des APIs pour la gestion des méthodes de paiement, des factures et des paiements avec documentation Scribe détaillée.

## ✅ Fichiers créés et modifiés

### 1. Contrôleurs API créés

#### `app/Http/Controllers/Api/PaymentMethodController.php`
Gestion complète des méthodes de paiement avec les endpoints suivants :
- ✅ **GET** `/api/payment-methods` - Liste toutes les méthodes de paiement (avec pagination et filtres)
- ✅ **POST** `/api/payment-methods` - Créer une nouvelle méthode de paiement
- ✅ **GET** `/api/payment-methods/{id}` - Afficher une méthode de paiement
- ✅ **PUT/PATCH** `/api/payment-methods/{id}` - Mettre à jour une méthode de paiement
- ✅ **DELETE** `/api/payment-methods/{id}` - Supprimer une méthode de paiement
- ✅ **PATCH** `/api/payment-methods/{id}/toggle-status` - Activer/Désactiver une méthode
- ✅ **GET** `/api/payment-methods/statistics/overview` - Statistiques des méthodes de paiement

#### `app/Http/Controllers/Api/FactureController.php`
Gestion complète des factures avec les endpoints suivants :
- ✅ **GET** `/api/factures` - Liste toutes les factures (avec pagination et filtres avancés)
- ✅ **POST** `/api/factures` - Créer une nouvelle facture avec détails
- ✅ **GET** `/api/factures/{id}` - Afficher une facture avec ses détails
- ✅ **PUT/PATCH** `/api/factures/{id}` - Mettre à jour une facture
- ✅ **DELETE** `/api/factures/{id}` - Supprimer une facture
- ✅ **PATCH** `/api/factures/{id}/update-status` - Changer le statut d'une facture
- ✅ **GET** `/api/factures/statistics/overview` - Statistiques des factures

#### `app/Http/Controllers/Api/PaiementController.php`
Gestion complète des paiements avec les endpoints suivants :
- ✅ **GET** `/api/paiements` - Liste tous les paiements (avec pagination et filtres)
- ✅ **POST** `/api/paiements` - Enregistrer un nouveau paiement
- ✅ **GET** `/api/paiements/{id}` - Afficher un paiement
- ✅ **PUT/PATCH** `/api/paiements/{id}` - Mettre à jour un paiement
- ✅ **DELETE** `/api/paiements/{id}` - Supprimer un paiement
- ✅ **PATCH** `/api/paiements/{id}/update-status` - Changer le statut d'un paiement
- ✅ **GET** `/api/paiements/statistics/overview` - Statistiques des paiements

### 2. Modèles mis à jour

#### `app/Models/PaymentMethod.php`
- ✅ Ajout de la relation `paiements()` - Un PaymentMethod a plusieurs Paiements

#### `app/Models/Facture.php`
- ✅ Ajout de la relation `details()` - Une Facture a plusieurs FactureDetails
- ✅ Ajout de la relation `paiements()` - Une Facture a plusieurs Paiements
- ✅ Ajout de la relation `user()` - Une Facture appartient à un User (créateur)
- ✅ Correction de la relation `client()` - Utilise le bon foreign key

#### `app/Models/Paiement.php`
- ✅ Correction de la relation `facture()` - Utilise le bon foreign key
- ✅ Correction de la relation `paymentMethod()` - Utilise le bon foreign key
- ✅ Ajout de la relation `user()` - Un Paiement appartient à un User (enregistreur)

#### `app/Models/FactureDetail.php`
- ✅ Correction de la relation `facture()` - Utilise le bon foreign key

### 3. Routes API ajoutées (`routes/api.php`)

Toutes les routes sont protégées par le middleware `auth:sanctum` et organisées en groupes logiques :

#### Routes Payment Methods
```php
/api/payment-methods/*
```

#### Routes Factures
```php
/api/factures/*
```

#### Routes Paiements
```php
/api/paiements/*
```

### 4. Configuration Scribe mise à jour (`config/scribe.php`)

- ✅ Ajout des nouveaux groupes dans l'ordre de documentation :
  - `Payment Methods Management`
  - `Invoices Management`
  - `Payments Management`

## 🎯 Fonctionnalités clés implémentées

### Gestion des Méthodes de Paiement
- CRUD complet
- Activation/Désactivation
- Vérification avant suppression (si utilisée dans des paiements)
- Statistiques d'utilisation

### Gestion des Factures
- CRUD complet avec gestion des détails
- Génération automatique du numéro de facture (format: FACT-2025-00001)
- Calcul automatique des montants (HT, taxes, transport, remises)
- Gestion des statuts (pending, paid, partially_paid, cancelled, overdue)
- Filtres avancés (par client, statut, dates)
- Relations avec clients, détails de facture et paiements
- Protection contre la suppression des factures payées
- Statistiques détaillées

### Gestion des Paiements
- CRUD complet
- Génération automatique de la référence (format: PAY-2025-00001)
- Mise à jour automatique du montant payé de la facture
- Mise à jour automatique du statut de la facture selon les paiements
- Vérification du montant (ne peut pas dépasser le solde restant)
- Gestion des statuts (pending, completed, failed, refunded)
- Recalcul automatique lors de modifications/suppressions
- Statistiques par méthode de paiement

## 📚 Documentation Scribe

Chaque endpoint est documenté avec :
- ✅ Description détaillée en français
- ✅ Groupe organisationnel (@group)
- ✅ Paramètres de requête (@queryParam)
- ✅ Paramètres de corps de requête (@bodyParam)
- ✅ Paramètres d'URL (@urlParam)
- ✅ Exemples de réponses réussies (@response)
- ✅ Exemples de réponses d'erreur (@response avec codes 400, 404, 422)
- ✅ Exemples de valeurs pour chaque paramètre

### Génération de la documentation

Pour générer la documentation Scribe, exécutez :

```bash
php artisan scribe:generate
```

La documentation sera accessible à l'URL :
```
http://votre-domaine.com/docs
```

## 🔐 Authentification

Toutes les routes nécessitent une authentification via **Laravel Sanctum**.

Les utilisateurs doivent :
1. S'inscrire via `/api/auth/register` ou se connecter via `/api/auth/login`
2. Utiliser le token reçu dans le header `Authorization: Bearer {TOKEN}`

## 📊 Exemples d'utilisation

### Créer une facture

```bash
POST /api/factures
Authorization: Bearer {token}
Content-Type: application/json

{
  "client_id": "550e8400-e29b-41d4-a716-446655440000",
  "user_id": "550e8400-e29b-41d4-a716-446655440001",
  "taxe_rate": 18,
  "transport_cost": 5000,
  "discount_amount": 2000,
  "delivery_adresse": "123 Rue de la Paix, Cotonou",
  "note": "Livraison express",
  "details": [
    {
      "product_id": "550e8400-e29b-41d4-a716-446655440002",
      "quantite": 10,
      "prix_unitaire": 10000,
      "taxe_rate": 18,
      "discount_amount": 500
    }
  ]
}
```

### Enregistrer un paiement

```bash
POST /api/paiements
Authorization: Bearer {token}
Content-Type: application/json

{
  "facture_id": "550e8400-e29b-41d4-a716-446655440000",
  "client_id": "550e8400-e29b-41d4-a716-446655440001",
  "payment_method_id": "550e8400-e29b-41d4-a716-446655440002",
  "amount": 50000,
  "payment_date": "2025-01-15 10:30:00",
  "note": "Paiement en espèces",
  "statut": "completed",
  "user_id": "550e8400-e29b-41d4-a716-446655440003"
}
```

### Obtenir les statistiques

```bash
GET /api/factures/statistics/overview
Authorization: Bearer {token}

GET /api/paiements/statistics/overview?date_from=2025-01-01&date_to=2025-12-31
Authorization: Bearer {token}

GET /api/payment-methods/statistics/overview
Authorization: Bearer {token}
```

## 🔄 Logique métier implémentée

### Lors de la création d'une facture
1. Génération automatique du numéro de facture
2. Calcul du montant HT à partir des détails
3. Calcul du montant total avec taxes, transport et remises
4. Statut initial : `pending`
5. Montant payé initial : `0`

### Lors de l'enregistrement d'un paiement
1. Génération automatique de la référence de paiement
2. Vérification que le montant ne dépasse pas le solde restant
3. Mise à jour du `paid_amount` de la facture (si statut = completed)
4. Mise à jour automatique du statut de la facture :
   - `paid` si montant payé >= montant total
   - `partially_paid` si 0 < montant payé < montant total
   - `pending` si montant payé = 0

### Lors de la modification/suppression d'un paiement
1. Recalcul du `paid_amount` de la facture
2. Mise à jour automatique du statut de la facture

## 🧪 Tests recommandés

Pour tester l'API, vous pouvez :

1. **Utiliser la documentation interactive Scribe** (bouton "Try It Out")
2. **Utiliser Postman** avec la collection générée (`public/docs/collection.json`)
3. **Utiliser les tests unitaires Laravel**

## 📝 Notes importantes

- Les UUIDs sont utilisés comme clés primaires pour tous les modèles
- Les montants sont stockés en `decimal(15,2)`
- Les relations utilisent les bons foreign keys (corrigés)
- Les timestamps sont automatiquement gérés par Laravel
- Les montants sont formatés avec 2 décimales dans les réponses JSON
- Toutes les opérations critiques utilisent des transactions DB pour garantir l'intégrité

## 🚀 Prochaines étapes suggérées

1. ✅ Créer des tests unitaires et d'intégration
2. ✅ Ajouter des Resources Laravel pour formater les réponses API
3. ✅ Ajouter des Request classes pour la validation
4. ✅ Implémenter des événements et listeners (ex: envoyer un email lors d'une nouvelle facture)
5. ✅ Ajouter des policies pour l'autorisation fine
6. ✅ Implémenter la génération de PDF pour les factures
7. ✅ Ajouter un système de notifications

## 📞 Support

Pour toute question ou problème, référez-vous à la documentation Scribe générée ou consultez le code source des contrôleurs.

---

**Date de création**: 14 octobre 2025  
**Version**: 1.0.0  
**Framework**: Laravel avec Sanctum et Scribe
