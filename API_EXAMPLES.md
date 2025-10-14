# Exemples d'utilisation de l'API Payment & Invoice

Ce document contient des exemples concrets pour tester les APIs de gestion des méthodes de paiement, factures et paiements.

## 🔐 Authentification

Avant d'utiliser les APIs, vous devez vous authentifier et obtenir un token :

```bash
# Inscription
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Admin User",
    "username": "admin",
    "email": "admin@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Connexion
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "login": "admin@example.com",
    "password": "password123"
  }'
```

Utilisez le token retourné dans toutes les requêtes suivantes :
```bash
Authorization: Bearer {votre-token}
```

---

## 💳 API Méthodes de Paiement

### 1. Créer des méthodes de paiement

```bash
# Espèces
curl -X POST http://localhost:8000/api/payment-methods \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "name": "Espèces",
    "is_active": true
  }'

# Mobile Money
curl -X POST http://localhost:8000/api/payment-methods \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "name": "Mobile Money",
    "is_active": true
  }'

# Carte bancaire
curl -X POST http://localhost:8000/api/payment-methods \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "name": "Carte bancaire",
    "is_active": true
  }'

# Virement bancaire
curl -X POST http://localhost:8000/api/payment-methods \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "name": "Virement bancaire",
    "is_active": true
  }'

# Chèque
curl -X POST http://localhost:8000/api/payment-methods \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "name": "Chèque",
    "is_active": true
  }'
```

### 2. Lister les méthodes de paiement

```bash
# Liste simple
curl -X GET http://localhost:8000/api/payment-methods \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Avec filtres
curl -X GET "http://localhost:8000/api/payment-methods?is_active=true&per_page=10" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Recherche
curl -X GET "http://localhost:8000/api/payment-methods?search=Mobile" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 3. Afficher une méthode de paiement

```bash
curl -X GET http://localhost:8000/api/payment-methods/{id} \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 4. Mettre à jour une méthode de paiement

```bash
curl -X PUT http://localhost:8000/api/payment-methods/{id} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "name": "Mobile Money (MTN/Moov)",
    "is_active": true
  }'
```

### 5. Activer/Désactiver une méthode

```bash
curl -X PATCH http://localhost:8000/api/payment-methods/{id}/toggle-status \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "is_active": false
  }'
```

### 6. Supprimer une méthode de paiement

```bash
curl -X DELETE http://localhost:8000/api/payment-methods/{id} \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 7. Statistiques

```bash
curl -X GET http://localhost:8000/api/payment-methods/statistics/overview \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

---

## 🧾 API Factures

### 1. Créer une facture

```bash
curl -X POST http://localhost:8000/api/factures \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "reference": "REF-2025-001",
    "client_id": "{client_uuid}",
    "user_id": "{user_uuid}",
    "due_date": "2025-02-15",
    "taxe_rate": 18,
    "transport_cost": 5000,
    "discount_amount": 2000,
    "delivery_adresse": "123 Rue de la Paix, Cotonou",
    "note": "Livraison express demandée",
    "details": [
      {
        "product_id": "{product_uuid_1}",
        "quantite": 10,
        "prix_unitaire": 15000,
        "taxe_rate": 18,
        "discount_amount": 500
      },
      {
        "product_id": "{product_uuid_2}",
        "quantite": 5,
        "prix_unitaire": 25000,
        "taxe_rate": 18,
        "discount_amount": 0
      }
    ]
  }'
```

### 2. Lister les factures

```bash
# Liste simple
curl -X GET http://localhost:8000/api/factures \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Avec relations
curl -X GET "http://localhost:8000/api/factures?with_client=true&with_details=true&per_page=20" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par statut
curl -X GET "http://localhost:8000/api/factures?statut=paid" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par client
curl -X GET "http://localhost:8000/api/factures?client_id={client_uuid}" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par dates
curl -X GET "http://localhost:8000/api/factures?date_from=2025-01-01&date_to=2025-12-31" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Recherche
curl -X GET "http://localhost:8000/api/factures?search=FACT-2025" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 3. Afficher une facture

```bash
# Facture seule
curl -X GET http://localhost:8000/api/factures/{id} \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Avec toutes les relations
curl -X GET "http://localhost:8000/api/factures/{id}?with_client=true&with_details=true&with_payments=true" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 4. Mettre à jour une facture

```bash
curl -X PUT http://localhost:8000/api/factures/{id} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "reference": "REF-2025-001-UPDATED",
    "due_date": "2025-03-15",
    "transport_cost": 7000,
    "discount_amount": 3000,
    "note": "Livraison urgente - prioritaire"
  }'
```

### 5. Changer le statut d'une facture

```bash
curl -X PATCH http://localhost:8000/api/factures/{id}/update-status \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "statut": "cancelled"
  }'
```

### 6. Supprimer une facture

```bash
curl -X DELETE http://localhost:8000/api/factures/{id} \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 7. Statistiques des factures

```bash
# Statistiques globales
curl -X GET http://localhost:8000/api/factures/statistics/overview \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Statistiques sur une période
curl -X GET "http://localhost:8000/api/factures/statistics/overview?date_from=2025-01-01&date_to=2025-01-31" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

---

## 💰 API Paiements

### 1. Enregistrer un paiement

```bash
# Paiement complet
curl -X POST http://localhost:8000/api/paiements \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "facture_id": "{facture_uuid}",
    "client_id": "{client_uuid}",
    "payment_method_id": "{payment_method_uuid}",
    "amount": 121000,
    "payment_date": "2025-01-15 14:30:00",
    "note": "Paiement en espèces",
    "statut": "completed",
    "user_id": "{user_uuid}"
  }'

# Paiement partiel
curl -X POST http://localhost:8000/api/paiements \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "facture_id": "{facture_uuid}",
    "client_id": "{client_uuid}",
    "payment_method_id": "{payment_method_uuid}",
    "amount": 50000,
    "payment_date": "2025-01-15 14:30:00",
    "note": "Acompte - Paiement en espèces",
    "statut": "completed",
    "user_id": "{user_uuid}"
  }'
```

### 2. Lister les paiements

```bash
# Liste simple
curl -X GET http://localhost:8000/api/paiements \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Avec relations
curl -X GET "http://localhost:8000/api/paiements?with_facture=true&with_client=true&with_payment_method=true" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par facture
curl -X GET "http://localhost:8000/api/paiements?facture_id={facture_uuid}" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par client
curl -X GET "http://localhost:8000/api/paiements?client_id={client_uuid}" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par méthode de paiement
curl -X GET "http://localhost:8000/api/paiements?payment_method_id={payment_method_uuid}" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par statut
curl -X GET "http://localhost:8000/api/paiements?statut=completed" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Filtrer par dates
curl -X GET "http://localhost:8000/api/paiements?date_from=2025-01-01&date_to=2025-12-31" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Recherche
curl -X GET "http://localhost:8000/api/paiements?search=PAY-2025" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 3. Afficher un paiement

```bash
# Paiement seul
curl -X GET http://localhost:8000/api/paiements/{id} \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Avec toutes les relations
curl -X GET "http://localhost:8000/api/paiements/{id}?with_facture=true&with_client=true&with_payment_method=true" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 4. Mettre à jour un paiement

```bash
curl -X PUT http://localhost:8000/api/paiements/{id} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "amount": 60000,
    "payment_date": "2025-01-16 10:00:00",
    "note": "Montant rectifié après vérification"
  }'
```

### 5. Changer le statut d'un paiement

```bash
# Marquer comme remboursé
curl -X PATCH http://localhost:8000/api/paiements/{id}/update-status \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "statut": "refunded"
  }'

# Marquer comme échoué
curl -X PATCH http://localhost:8000/api/paiements/{id}/update-status \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "statut": "failed"
  }'
```

### 6. Supprimer un paiement

```bash
curl -X DELETE http://localhost:8000/api/paiements/{id} \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### 7. Statistiques des paiements

```bash
# Statistiques globales
curl -X GET http://localhost:8000/api/paiements/statistics/overview \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# Statistiques sur une période
curl -X GET "http://localhost:8000/api/paiements/statistics/overview?date_from=2025-01-01&date_to=2025-01-31" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

---

## 📊 Scénarios d'utilisation complets

### Scénario 1 : Créer une facture et l'encaisser complètement

```bash
# 1. Créer la facture
FACTURE_RESPONSE=$(curl -X POST http://localhost:8000/api/factures \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "client_id": "{client_uuid}",
    "user_id": "{user_uuid}",
    "taxe_rate": 18,
    "details": [
      {
        "product_id": "{product_uuid}",
        "quantite": 10,
        "prix_unitaire": 10000
      }
    ]
  }')

# Extraire l'ID de la facture (nécessite jq)
FACTURE_ID=$(echo $FACTURE_RESPONSE | jq -r '.data.facture_id')
TOTAL_AMOUNT=$(echo $FACTURE_RESPONSE | jq -r '.data.total_amount')

# 2. Enregistrer le paiement complet
curl -X POST http://localhost:8000/api/paiements \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d "{
    \"facture_id\": \"$FACTURE_ID\",
    \"client_id\": \"{client_uuid}\",
    \"payment_method_id\": \"{payment_method_uuid}\",
    \"amount\": $TOTAL_AMOUNT,
    \"statut\": \"completed\",
    \"user_id\": \"{user_uuid}\"
  }"

# 3. Vérifier que la facture est marquée comme payée
curl -X GET "http://localhost:8000/api/factures/$FACTURE_ID" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

### Scénario 2 : Créer une facture et l'encaisser en plusieurs fois

```bash
# 1. Créer la facture (montant total: 118000 FCFA)
curl -X POST http://localhost:8000/api/factures \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "client_id": "{client_uuid}",
    "user_id": "{user_uuid}",
    "taxe_rate": 18,
    "details": [
      {
        "product_id": "{product_uuid}",
        "quantite": 10,
        "prix_unitaire": 10000
      }
    ]
  }'

# 2. Premier paiement (50000 FCFA)
curl -X POST http://localhost:8000/api/paiements \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "facture_id": "{facture_uuid}",
    "client_id": "{client_uuid}",
    "payment_method_id": "{payment_method_uuid}",
    "amount": 50000,
    "note": "Premier acompte",
    "statut": "completed",
    "user_id": "{user_uuid}"
  }'

# 3. Deuxième paiement (50000 FCFA)
curl -X POST http://localhost:8000/api/paiements \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "facture_id": "{facture_uuid}",
    "client_id": "{client_uuid}",
    "payment_method_id": "{payment_method_uuid}",
    "amount": 50000,
    "note": "Deuxième acompte",
    "statut": "completed",
    "user_id": "{user_uuid}"
  }'

# 4. Paiement final (18000 FCFA - solde)
curl -X POST http://localhost:8000/api/paiements \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "facture_id": "{facture_uuid}",
    "client_id": "{client_uuid}",
    "payment_method_id": "{payment_method_uuid}",
    "amount": 18000,
    "note": "Paiement final - solde",
    "statut": "completed",
    "user_id": "{user_uuid}"
  }'
```

### Scénario 3 : Rapport mensuel des ventes

```bash
# 1. Statistiques des factures du mois
curl -X GET "http://localhost:8000/api/factures/statistics/overview?date_from=2025-01-01&date_to=2025-01-31" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# 2. Statistiques des paiements du mois
curl -X GET "http://localhost:8000/api/paiements/statistics/overview?date_from=2025-01-01&date_to=2025-01-31" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# 3. Liste des factures en attente
curl -X GET "http://localhost:8000/api/factures?statut=pending&per_page=100" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"

# 4. Liste des factures en retard (overdue)
curl -X GET "http://localhost:8000/api/factures?statut=overdue&per_page=100" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

---

## 🎯 Codes de statut

- **200** : Succès
- **201** : Créé avec succès
- **400** : Erreur de requête (ex: montant dépassant le solde)
- **401** : Non autorisé (token manquant ou invalide)
- **404** : Ressource non trouvée
- **422** : Erreur de validation
- **500** : Erreur serveur

---

## 📝 Notes importantes

1. Remplacez `{token}` par votre token d'authentification réel
2. Remplacez tous les `{uuid}` par les UUIDs réels de vos entités
3. Les montants sont en FCFA (ou votre devise locale)
4. Les dates doivent être au format `YYYY-MM-DD` ou `YYYY-MM-DD HH:mm:ss`
5. Utilisez `jq` pour parser les réponses JSON dans vos scripts bash

---

## 🧪 Test avec Postman

Importez la collection Postman générée par Scribe :
```
public/docs/collection.json
```

Cette collection contient tous les endpoints avec des exemples pré-configurés.

---

**Date**: 14 octobre 2025  
**Version**: 1.0.0
