# Exemples de Données - APIs Mouvements de Stock

## Types de Mouvements de Stock

### Types d'Entrée (in)
```json
{
    "name": "Réception Fournisseur",
    "direction": "in"
}
```

```json
{
    "name": "Retour Client",
    "direction": "in"
}
```

```json
{
    "name": "Inventaire Initial",
    "direction": "in"
}
```

### Types de Sortie (out)
```json
{
    "name": "Vente Client",
    "direction": "out"
}
```

```json
{
    "name": "Sortie Détériorée",
    "direction": "out"
}
```

```json
{
    "name": "Don/Échantillon",
    "direction": "out"
}
```

### Types de Transfert (transfer)
```json
{
    "name": "Transfert Entrepôt",
    "direction": "transfer"
}
```

```json
{
    "name": "Réapprovisionnement",
    "direction": "transfer"
}
```

## Exemples de Mouvements de Stock

### 1. Réception de Marchandise
```json
{
    "reference": "REC-2024-001",
    "movement_type_id": "uuid-type-reception",
    "entrepot_to_id": "uuid-entrepot-principal",
    "fournisseur_id": "uuid-fournisseur-abc",
    "statut": "pending",
    "note": "Livraison commande #12345",
    "user_id": "uuid-utilisateur-manager",
    "details": [
        {
            "product_id": "uuid-produit-laptop",
            "quantity": 10
        },
        {
            "product_id": "uuid-produit-souris",
            "quantity": 50
        },
        {
            "product_id": "uuid-produit-clavier",
            "quantity": 25
        }
    ]
}
```

### 2. Vente Client
```json
{
    "reference": "VTE-2024-001",
    "movement_type_id": "uuid-type-vente",
    "entrepot_from_id": "uuid-entrepot-principal",
    "client_id": "uuid-client-entreprise",
    "statut": "pending",
    "note": "Commande client #67890",
    "user_id": "uuid-utilisateur-vendeur",
    "details": [
        {
            "product_id": "uuid-produit-laptop",
            "quantity": 2
        },
        {
            "product_id": "uuid-produit-souris",
            "quantity": 4
        }
    ]
}
```

### 3. Transfert entre Entrepôts
```json
{
    "reference": "TRF-2024-001",
    "movement_type_id": "uuid-type-transfer",
    "entrepot_from_id": "uuid-entrepot-principal",
    "entrepot_to_id": "uuid-entrepot-succursale",
    "statut": "pending",
    "note": "Réapprovisionnement succursale",
    "user_id": "uuid-utilisateur-logisticien",
    "details": [
        {
            "product_id": "uuid-produit-laptop",
            "quantity": 5
        },
        {
            "product_id": "uuid-produit-clavier",
            "quantity": 10
        }
    ]
}
```

### 4. Retour Client
```json
{
    "reference": "RET-2024-001",
    "movement_type_id": "uuid-type-retour",
    "entrepot_to_id": "uuid-entrepot-principal",
    "client_id": "uuid-client-entreprise",
    "statut": "pending",
    "note": "Retour produit défectueux",
    "user_id": "uuid-utilisateur-sav",
    "details": [
        {
            "product_id": "uuid-produit-laptop",
            "quantity": 1
        }
    ]
}
```

### 5. Sortie Détériorée
```json
{
    "reference": "DET-2024-001",
    "movement_type_id": "uuid-type-deteriore",
    "entrepot_from_id": "uuid-entrepot-principal",
    "statut": "pending",
    "note": "Produit endommagé lors du transport",
    "user_id": "uuid-utilisateur-inventaire",
    "details": [
        {
            "product_id": "uuid-produit-souris",
            "quantity": 3
        }
    ]
}
```

## Exemples de Détails de Mouvements

### Détail Simple
```json
{
    "stock_movement_id": "uuid-mouvement-001",
    "product_id": "uuid-produit-laptop",
    "quantity": 10
}
```

### Détail avec Produit Complexe
```json
{
    "stock_movement_id": "uuid-mouvement-002",
    "product_id": "uuid-produit-kit-complet",
    "quantity": 5
}
```

## Exemples de Requêtes de Filtrage

### Filtrer par Type de Mouvement
```bash
GET /api/stock-movements?movement_type_id=uuid-type-reception
```

### Filtrer par Statut
```bash
GET /api/stock-movements?statut=pending
```

### Filtrer par Période
```bash
GET /api/stock-movements?date_from=2024-01-01&date_to=2024-01-31
```

### Filtrer par Entrepôt
```bash
GET /api/stock-movements?entrepot_from_id=uuid-entrepot-principal
```

### Recherche par Référence
```bash
GET /api/stock-movements?search=REC-2024
```

### Combinaison de Filtres
```bash
GET /api/stock-movements?movement_type_id=uuid-type-vente&statut=completed&date_from=2024-01-01&per_page=20
```

## Exemples de Réponses

### Réponse de Liste Paginée
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "stock_movement_id": "uuid-001",
                "reference": "REC-2024-001",
                "movement_type_id": "uuid-type-reception",
                "statut": "completed",
                "created_at": "2024-01-15 10:30:00",
                "movement_type": {
                    "name": "Réception Fournisseur",
                    "direction": "in"
                },
                "details_count": 3
            }
        ],
        "current_page": 1,
        "per_page": 15,
        "total": 1,
        "last_page": 1
    },
    "message": "Mouvements de stock récupérés avec succès"
}
```

### Réponse de Détail Complet
```json
{
    "success": true,
    "data": {
        "stock_movement_id": "uuid-001",
        "reference": "REC-2024-001",
        "movement_type_id": "uuid-type-reception",
        "entrepot_to_id": "uuid-entrepot-principal",
        "fournisseur_id": "uuid-fournisseur-abc",
        "statut": "completed",
        "note": "Livraison commande #12345",
        "user_id": "uuid-utilisateur-manager",
        "created_at": "2024-01-15 10:30:00",
        "updated_at": "2024-01-15 11:00:00",
        "movement_type": {
            "stock_movement_type_id": "uuid-type-reception",
            "name": "Réception Fournisseur",
            "direction": "in"
        },
        "entrepot_to": {
            "entrepot_id": "uuid-entrepot-principal",
            "name": "Entrepôt Principal",
            "city": "Paris"
        },
        "fournisseur": {
            "fournisseur_id": "uuid-fournisseur-abc",
            "name": "ABC Technologies",
            "email": "contact@abc-tech.com"
        },
        "user": {
            "user_id": "uuid-utilisateur-manager",
            "username": "manager1",
            "first_name": "Jean",
            "last_name": "Dupont"
        },
        "details": [
            {
                "stock_movement_detail_id": "uuid-detail-001",
                "product_id": "uuid-produit-laptop",
                "quantity": 10,
                "product": {
                    "product_id": "uuid-produit-laptop",
                    "name": "Laptop Dell XPS 13",
                    "sku": "DELL-XPS13-001",
                    "price": 1299.99
                }
            }
        ]
    },
    "message": "Mouvement de stock récupéré avec succès"
}
```

## Codes d'Erreur Courants

### Erreur de Validation
```json
{
    "success": false,
    "message": "Erreur de validation",
    "errors": {
        "reference": ["La référence est obligatoire."],
        "movement_type_id": ["Le type de mouvement est obligatoire."],
        "details": ["Les détails du mouvement sont obligatoires."],
        "details.0.product_id": ["Le produit est obligatoire pour chaque détail."],
        "details.0.quantity": ["La quantité doit être au moins 1."]
    }
}
```

### Ressource Non Trouvée
```json
{
    "success": false,
    "message": "Mouvement de stock non trouvé"
}
```

### Erreur de Contrainte
```json
{
    "success": false,
    "message": "Erreur lors de la création du mouvement de stock",
    "error": "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'REC-2024-001' for key 'stock_movements.reference'"
}
```

## Tests d'Intégration

### Séquence de Test Complète

1. **Créer un type de mouvement**
2. **Créer un mouvement de stock**
3. **Vérifier le mouvement créé**
4. **Mettre à jour le statut**
5. **Ajouter un détail supplémentaire**
6. **Supprimer le mouvement (soft delete)**
7. **Restaurer le mouvement**

### Script de Test Bash
```bash
#!/bin/bash

# Variables
BASE_URL="http://localhost:8000/api"
TOKEN="your-auth-token"

# 1. Créer un type de mouvement
echo "1. Création du type de mouvement..."
TYPE_RESPONSE=$(curl -s -X POST "$BASE_URL/stock-movement-types" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Réception",
    "direction": "in"
  }')

TYPE_ID=$(echo $TYPE_RESPONSE | jq -r '.data.stock_movement_type_id')
echo "Type créé avec ID: $TYPE_ID"

# 2. Créer un mouvement
echo "2. Création du mouvement..."
MOVEMENT_RESPONSE=$(curl -s -X POST "$BASE_URL/stock-movements" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d "{
    \"reference\": \"TEST-$(date +%s)\",
    \"movement_type_id\": \"$TYPE_ID\",
    \"statut\": \"pending\",
    \"user_id\": \"your-user-id\",
    \"details\": [
      {
        \"product_id\": \"your-product-id\",
        \"quantity\": 1
      }
    ]
  }")

MOVEMENT_ID=$(echo $MOVEMENT_RESPONSE | jq -r '.data.stock_movement_id')
echo "Mouvement créé avec ID: $MOVEMENT_ID"

# 3. Vérifier le mouvement
echo "3. Vérification du mouvement..."
curl -s -X GET "$BASE_URL/stock-movements/$MOVEMENT_ID" \
  -H "Authorization: Bearer $TOKEN" | jq '.'

echo "Test terminé avec succès!"
```

---

*Ces exemples peuvent être utilisés pour tester et comprendre le fonctionnement des APIs de mouvements de stock.*
