# Documentation API - Mouvements de Stock

## Vue d'ensemble

Cette documentation décrit les APIs pour la gestion des mouvements de stock, incluant les types de mouvements, les mouvements eux-mêmes et leurs détails.

## Endpoints disponibles

### 1. Types de Mouvements de Stock (`/api/stock-movement-types`)

#### GET `/api/stock-movement-types`
Récupère la liste des types de mouvements de stock.

**Paramètres de requête :**
- `direction` (optionnel) : Filtrer par direction (`in`, `out`, `transfer`)
- `search` (optionnel) : Rechercher par nom
- `sort_by` (optionnel) : Champ de tri (défaut: `created_at`)
- `sort_order` (optionnel) : Ordre de tri (`asc` ou `desc`, défaut: `desc`)
- `per_page` (optionnel) : Nombre d'éléments par page (défaut: 15)

**Exemple de réponse :**
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "stock_movement_type_id": "uuid",
                "name": "Réception",
                "direction": "in",
                "created_at": "2024-01-01 10:00:00",
                "updated_at": "2024-01-01 10:00:00"
            }
        ],
        "current_page": 1,
        "per_page": 15,
        "total": 1
    },
    "message": "Types de mouvements de stock récupérés avec succès"
}
```

#### POST `/api/stock-movement-types`
Crée un nouveau type de mouvement de stock.

**Corps de la requête :**
```json
{
    "name": "Réception",
    "direction": "in"
}
```

#### GET `/api/stock-movement-types/{id}`
Récupère un type de mouvement de stock spécifique.

#### PUT/PATCH `/api/stock-movement-types/{id}`
Met à jour un type de mouvement de stock.

#### DELETE `/api/stock-movement-types/{id}`
Supprime un type de mouvement de stock (soft delete).

#### GET `/api/stock-movement-types/trashed/list`
Récupère la liste des types de mouvements supprimés.

#### POST `/api/stock-movement-types/{id}/restore`
Restaure un type de mouvement de stock supprimé.

### 2. Mouvements de Stock (`/api/stock-movements`)

#### GET `/api/stock-movements`
Récupère la liste des mouvements de stock.

**Paramètres de requête :**
- `movement_type_id` (optionnel) : Filtrer par type de mouvement
- `statut` (optionnel) : Filtrer par statut (`pending`, `completed`, `cancelled`)
- `entrepot_from_id` (optionnel) : Filtrer par entrepôt source
- `entrepot_to_id` (optionnel) : Filtrer par entrepôt destination
- `client_id` (optionnel) : Filtrer par client
- `fournisseur_id` (optionnel) : Filtrer par fournisseur
- `search` (optionnel) : Rechercher par référence
- `date_from` (optionnel) : Filtrer par date de début
- `date_to` (optionnel) : Filtrer par date de fin
- `sort_by` (optionnel) : Champ de tri
- `sort_order` (optionnel) : Ordre de tri
- `per_page` (optionnel) : Nombre d'éléments par page

#### POST `/api/stock-movements`
Crée un nouveau mouvement de stock.

**Corps de la requête :**
```json
{
    "reference": "MV-2024-001",
    "movement_type_id": "uuid",
    "entrepot_from_id": "uuid",
    "entrepot_to_id": "uuid",
    "fournisseur_id": "uuid",
    "client_id": "uuid",
    "statut": "pending",
    "note": "Note optionnelle",
    "user_id": "uuid",
    "details": [
        {
            "product_id": "uuid",
            "quantity": 10
        },
        {
            "product_id": "uuid",
            "quantity": 5
        }
    ]
}
```

#### GET `/api/stock-movements/{id}`
Récupère un mouvement de stock spécifique avec tous ses détails.

#### PUT/PATCH `/api/stock-movements/{id}`
Met à jour un mouvement de stock.

#### DELETE `/api/stock-movements/{id}`
Supprime un mouvement de stock (soft delete).

#### GET `/api/stock-movements/trashed/list`
Récupère la liste des mouvements supprimés.

#### POST `/api/stock-movements/{id}/restore`
Restaure un mouvement de stock supprimé.

#### PATCH `/api/stock-movements/{id}/update-status`
Met à jour le statut d'un mouvement de stock.

**Corps de la requête :**
```json
{
    "statut": "completed"
}
```

### 3. Détails de Mouvements de Stock (`/api/stock-movement-details`)

#### GET `/api/stock-movement-details`
Récupère la liste des détails de mouvements de stock.

**Paramètres de requête :**
- `stock_movement_id` (optionnel) : Filtrer par mouvement de stock
- `product_id` (optionnel) : Filtrer par produit
- `quantity_min` (optionnel) : Filtrer par quantité minimale
- `quantity_max` (optionnel) : Filtrer par quantité maximale
- `sort_by` (optionnel) : Champ de tri
- `sort_order` (optionnel) : Ordre de tri
- `per_page` (optionnel) : Nombre d'éléments par page

#### POST `/api/stock-movement-details`
Crée un nouveau détail de mouvement de stock.

**Corps de la requête :**
```json
{
    "stock_movement_id": "uuid",
    "product_id": "uuid",
    "quantity": 10
}
```

#### GET `/api/stock-movement-details/{id}`
Récupère un détail de mouvement de stock spécifique.

#### PUT/PATCH `/api/stock-movement-details/{id}`
Met à jour un détail de mouvement de stock.

#### DELETE `/api/stock-movement-details/{id}`
Supprime un détail de mouvement de stock (soft delete).

#### GET `/api/stock-movement-details/trashed/list`
Récupère la liste des détails supprimés.

#### POST `/api/stock-movement-details/{id}/restore`
Restaure un détail de mouvement de stock supprimé.

#### GET `/api/stock-movement-details/stock-movement/{stockMovementId}`
Récupère tous les détails d'un mouvement de stock spécifique.

#### GET `/api/stock-movement-details/product/{productId}`
Récupère tous les détails de mouvements pour un produit spécifique.

## Codes de statut HTTP

- `200` : Succès
- `201` : Créé avec succès
- `400` : Requête invalide
- `401` : Non authentifié
- `404` : Ressource non trouvée
- `422` : Erreur de validation
- `500` : Erreur serveur

## Authentification

Toutes les routes nécessitent une authentification via Sanctum. Incluez le token d'authentification dans l'en-tête :

```
Authorization: Bearer {token}
```

## Exemples d'utilisation

### Créer un mouvement de réception

```bash
curl -X POST http://localhost:8000/api/stock-movements \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "reference": "REC-2024-001",
    "movement_type_id": "type-uuid",
    "entrepot_to_id": "entrepot-uuid",
    "fournisseur_id": "fournisseur-uuid",
    "statut": "pending",
    "user_id": "user-uuid",
    "details": [
      {
        "product_id": "product-uuid",
        "quantity": 50
      }
    ]
  }'
```

### Créer un mouvement de transfert

```bash
curl -X POST http://localhost:8000/api/stock-movements \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "reference": "TRF-2024-001",
    "movement_type_id": "transfer-type-uuid",
    "entrepot_from_id": "entrepot-source-uuid",
    "entrepot_to_id": "entrepot-destination-uuid",
    "statut": "pending",
    "user_id": "user-uuid",
    "details": [
      {
        "product_id": "product-uuid",
        "quantity": 25
      }
    ]
  }'
```

### Créer un mouvement de sortie

```bash
curl -X POST http://localhost:8000/api/stock-movements \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "reference": "OUT-2024-001",
    "movement_type_id": "out-type-uuid",
    "entrepot_from_id": "entrepot-uuid",
    "client_id": "client-uuid",
    "statut": "pending",
    "user_id": "user-uuid",
    "details": [
      {
        "product_id": "product-uuid",
        "quantity": 15
      }
    ]
  }'
```

## Gestion des erreurs

Toutes les réponses d'erreur suivent ce format :

```json
{
    "success": false,
    "message": "Message d'erreur descriptif",
    "errors": {
        "field_name": ["Message de validation spécifique"]
    }
}
```

## Notes importantes

1. Tous les IDs utilisent des UUIDs
2. La suppression est logique (soft delete) par défaut
3. Les relations sont chargées automatiquement dans les réponses
4. La pagination est activée par défaut
5. Tous les champs de date sont au format `Y-m-d H:i:s`
6. Les validations sont strictes et incluent des messages d'erreur en français