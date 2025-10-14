#!/bin/bash

###############################################################################
# Script de génération de la documentation Scribe
# 
# Ce script génère la documentation API complète avec Scribe pour les APIs
# de gestion des méthodes de paiement, factures et paiements.
###############################################################################

echo "🚀 Génération de la documentation API avec Scribe..."
echo ""

# Vérifier que PHP est installé
if ! command -v php &> /dev/null; then
    echo "❌ Erreur: PHP n'est pas installé ou n'est pas dans le PATH"
    echo "   Veuillez installer PHP pour continuer"
    exit 1
fi

# Vérifier que nous sommes dans un projet Laravel
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Le fichier artisan n'a pas été trouvé"
    echo "   Assurez-vous d'exécuter ce script depuis la racine du projet Laravel"
    exit 1
fi

# Vérifier que Scribe est installé
if ! php artisan list | grep -q "scribe:generate"; then
    echo "❌ Erreur: Scribe n'est pas installé"
    echo "   Installez Scribe avec: composer require --dev knuckleswtf/scribe"
    exit 1
fi

echo "✅ Environnement validé"
echo ""

# Générer la documentation
echo "📚 Génération de la documentation..."
php artisan scribe:generate

# Vérifier le résultat
if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Documentation générée avec succès!"
    echo ""
    echo "📂 Les fichiers de documentation sont disponibles dans:"
    echo "   - HTML: public/docs/index.html"
    echo "   - Postman: public/docs/collection.json"
    echo "   - OpenAPI: public/docs/openapi.yaml"
    echo ""
    echo "🌐 Accédez à la documentation en ligne à:"
    echo "   http://votre-domaine.com/docs"
    echo ""
    echo "💡 Si vous utilisez un serveur local:"
    echo "   php artisan serve"
    echo "   Puis visitez: http://localhost:8000/docs"
    echo ""
else
    echo ""
    echo "❌ Erreur lors de la génération de la documentation"
    echo "   Vérifiez les logs ci-dessus pour plus de détails"
    exit 1
fi

exit 0
