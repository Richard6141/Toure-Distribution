# Guide API - Mouvements de Stock

## Vue d'ensemble

Ce guide détaille l'utilisation des APIs pour la gestion des mouvements de stock dans le système de gestion d'entreprise. Les APIs permettent de gérer trois entités principales :

1. **Types de Mouvements de Stock** (`Stock Movement Types`)
2. **Mouvements de Stock** (`Stock Movements`) 
3. **Détails de Mouvements de Stock** (`Stock Movement Details`)

## Architecture des Données

### Types de Mouvements de Stock
- **Entrée** (`in`) : Réception de produits (achats, retours clients)
- **Sortie** (`out`) : Vente de produits, sorties diverses
- **Transfert** (`transfer`) : Déplacement entre entrepôts

### Mouvements de Stock
Un mouvement de stock représente une transaction complète avec :
- Une référence unique
- Un type de mouvement
- Des entrepôts source et/ou destination
- Un client ou fournisseur (optionnel)
- Un statut (pending, completed, cancelled)
- Des détails (produits et quantités)

### Détails de Mouvements
Chaque mouvement peut contenir plusieurs détails :
- Un produit spécifique
- Une quantité
- Lien vers le mouvement parent

## Endpoints Principaux

### 1. Types de Mouvements de Stock

#### `GET /api/stock-movement-types`
Récupère la liste des types de mouvements avec filtrage et pagination.

**Paramètres de requête :**
- `direction` : Filtrer par direction (in, out, transfer)
- `search` : Rechercher par nom
- `sort_by` : Champ de tri (défaut: created_at)
- `sort_order` : Ordre de tri (asc, desc)
- `per_page` : Nombre d'éléments par page

**Exemple de requête :**
```bash
curl -X GET "http://localhost:8000/api/stock-movement-types?direction=in&per_page=10" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### `POST /api/stock-movement-types`
Crée un nouveau type de mouvement.

**Corps de la requête :**
```json
{
    "name": "Réception Fournisseur",
    "direction": "in"
}
```

### 2. Mouvements de Stock

#### `GET /api/stock-movements`
Récupère la liste des mouvements avec filtrage avancé.

**Paramètres de requête :**
- `movement_type_id` : Filtrer par type
- `statut` : Filtrer par statut
- `entrepot_from_id` : Filtrer par entrepôt source
- `entrepot_to_id` : Filtrer par entrepôt destination
- `client_id` : Filtrer par client
- `fournisseur_id` : Filtrer par fournisseur
- `search` : Rechercher par référence
- `date_from` / `date_to` : Filtrer par période
- `sort_by` / `sort_order` : Tri
- `per_page` : Pagination

#### `POST /api/stock-movements`
Crée un nouveau mouvement de stock.

**Corps de la requête :**
```json
{
    "reference": "MV-2024-001",
    "movement_type_id": "uuid-du-type",
    "entrepot_from_id": "uuid-entrepot-source",
    "entrepot_to_id": "uuid-entrepot-destination",
    "fournisseur_id": "uuid-fournisseur",
    "client_id": "uuid-client",
    "statut": "pending",
    "note": "Note optionnelle",
    "user_id": "uuid-utilisateur",
    "details": [
        {
            "product_id": "uuid-produit-1",
            "quantity": 10
        },
        {
            "product_id": "uuid-produit-2",
            "quantity": 5
        }
    ]
}
```

#### `PATCH /api/stock-movements/{id}/update-status`
Met à jour le statut d'un mouvement.

**Corps de la requête :**
```json
{
    "statut": "completed"
}
```

### 3. Détails de Mouvements de Stock

#### `GET /api/stock-movement-details`
Récupère la liste des détails avec filtrage.

**Paramètres de requête :**
- `stock_movement_id` : Filtrer par mouvement
- `product_id` : Filtrer par produit
- `quantity_min` / `quantity_max` : Filtrer par quantité
- `sort_by` / `sort_order` : Tri
- `per_page` : Pagination

#### `GET /api/stock-movement-details/stock-movement/{stockMovementId}`
Récupère tous les détails d'un mouvement spécifique.

#### `GET /api/stock-movement-details/product/{productId}`
Récupère tous les détails de mouvements pour un produit.

## Exemples d'Utilisation

### Scénario 1 : Réception de Marchandise

1. **Créer le type de mouvement** (si nécessaire) :
```bash
curl -X POST "http://localhost:8000/api/stock-movement-types" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Réception Fournisseur",
    "direction": "in"
  }'
```

2. **Créer le mouvement de réception** :
```bash
curl -X POST "http://localhost:8000/api/stock-movements" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "reference": "REC-2024-001",
    "movement_type_id": "uuid-type-reception",
    "entrepot_to_id": "uuid-entrepot-principal",
    "fournisseur_id": "uuid-fournisseur",
    "statut": "pending",
    "user_id": "uuid-utilisateur",
    "details": [
      {
        "product_id": "uuid-produit-a",
        "quantity": 50
      },
      {
        "product_id": "uuid-produit-b",
        "quantity": 25
      }
    ]
  }'
```

3. **Valider le mouvement** :
```bash
curl -X PATCH "http://localhost:8000/api/stock-movements/{movement-id}/update-status" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "statut": "completed"
  }'
```

### Scénario 2 : Transfert entre Entrepôts

```bash
curl -X POST "http://localhost:8000/api/stock-movements" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "reference": "TRF-2024-001",
    "movement_type_id": "uuid-type-transfer",
    "entrepot_from_id": "uuid-entrepot-source",
    "entrepot_to_id": "uuid-entrepot-destination",
    "statut": "pending",
    "user_id": "uuid-utilisateur",
    "details": [
      {
        "product_id": "uuid-produit-c",
        "quantity": 30
      }
    ]
  }'
```

### Scénario 3 : Vente de Produits

```bash
curl -X POST "http://localhost:8000/api/stock-movements" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "reference": "VTE-2024-001",
    "movement_type_id": "uuid-type-vente",
    "entrepot_from_id": "uuid-entrepot-principal",
    "client_id": "uuid-client",
    "statut": "pending",
    "user_id": "uuid-utilisateur",
    "details": [
      {
        "product_id": "uuid-produit-d",
        "quantity": 15
      }
    ]
  }'
```

## Gestion des Erreurs

### Codes de Statut HTTP
- `200` : Succès
- `201` : Créé avec succès
- `400` : Requête invalide
- `401` : Non authentifié
- `404` : Ressource non trouvée
- `422` : Erreur de validation
- `500` : Erreur serveur

### Format des Erreurs
```json
{
    "success": false,
    "message": "Message d'erreur descriptif",
    "errors": {
        "field_name": ["Message de validation spécifique"]
    }
}
```

### Exemples d'Erreurs Courantes

**Validation échouée :**
```json
{
    "success": false,
    "message": "Erreur de validation",
    "errors": {
        "reference": ["La référence est obligatoire."],
        "movement_type_id": ["Le type de mouvement est obligatoire."],
        "details": ["Les détails du mouvement sont obligatoires."]
    }
}
```

**Ressource non trouvée :**
```json
{
    "success": false,
    "message": "Mouvement de stock non trouvé"
}
```

## Bonnes Pratiques

### 1. Gestion des Transactions
- Utilisez les transactions pour les opérations complexes
- Validez les données avant de créer les mouvements
- Gérez les erreurs de manière appropriée

### 2. Performance
- Utilisez la pagination pour les grandes listes
- Filtrez les données côté serveur
- Chargez les relations nécessaires uniquement

### 3. Sécurité
- Authentifiez toutes les requêtes
- Validez les données d'entrée
- Utilisez des références uniques

### 4. Monitoring
- Surveillez les statuts des mouvements
- Gérez les mouvements en attente
- Implémentez des logs d'audit

## Intégration avec d'Autres Systèmes

### Webhooks (Futur)
- Notification lors de changement de statut
- Synchronisation avec les systèmes externes
- Mise à jour des stocks en temps réel

### Rapports
- Historique des mouvements
- Analyse des tendances
- Rapports de performance

## Support et Maintenance

### Documentation Interactive
- Accédez à `/docs` pour la documentation Scribe interactive
- Testez les APIs directement depuis l'interface
- Téléchargez la collection Postman

### Support Technique
- Consultez les logs d'erreur
- Vérifiez la configuration de la base de données
- Contactez l'équipe technique si nécessaire

---

*Cette documentation est mise à jour régulièrement. Consultez la version en ligne pour les dernières informations.*