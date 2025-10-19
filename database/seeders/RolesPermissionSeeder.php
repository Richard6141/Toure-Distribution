<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // === GESTION DES UTILISATEURS ===
            ['name' => 'users.view', 'libelle' => 'Consulter les utilisateurs'],
            ['name' => 'users.create', 'libelle' => 'Créer un utilisateur'],
            ['name' => 'users.update', 'libelle' => 'Modifier un utilisateur'],
            ['name' => 'users.delete', 'libelle' => 'Supprimer un utilisateur'],
            ['name' => 'users.activate', 'libelle' => 'Activer/Désactiver un utilisateur'],
            ['name' => 'users.unlock', 'libelle' => 'Déverrouiller un compte'],
            ['name' => 'users.stats', 'libelle' => 'Voir les statistiques utilisateurs'],
            ['name' => 'users.export', 'libelle' => 'Exporter les utilisateurs'],

            // === GESTION DES CLIENTS ===
            ['name' => 'clients.view', 'libelle' => 'Consulter les clients'],
            ['name' => 'clients.create', 'libelle' => 'Créer un client'],
            ['name' => 'clients.update', 'libelle' => 'Modifier un client'],
            ['name' => 'clients.delete', 'libelle' => 'Supprimer un client'],
            ['name' => 'clients.restore', 'libelle' => 'Restaurer un client supprimé'],
            ['name' => 'clients.toggle_status', 'libelle' => 'Activer/Désactiver un client'],
            ['name' => 'clients.update_balance', 'libelle' => 'Modifier le solde client'],
            ['name' => 'clients.search', 'libelle' => 'Rechercher des clients'],
            ['name' => 'clients.stats', 'libelle' => 'Voir les statistiques clients'],
            ['name' => 'clients.trashed', 'libelle' => 'Voir les clients supprimés'],

            // === GESTION DES TYPES DE CLIENTS ===
            ['name' => 'client_types.view', 'libelle' => 'Consulter les types de clients'],
            ['name' => 'client_types.create', 'libelle' => 'Créer un type de client'],
            ['name' => 'client_types.update', 'libelle' => 'Modifier un type de client'],
            ['name' => 'client_types.delete', 'libelle' => 'Supprimer un type de client'],
            ['name' => 'client_types.restore', 'libelle' => 'Restaurer un type de client'],

            // === GESTION DES FOURNISSEURS ===
            ['name' => 'fournisseurs.view', 'libelle' => 'Consulter les fournisseurs'],
            ['name' => 'fournisseurs.create', 'libelle' => 'Créer un fournisseur'],
            ['name' => 'fournisseurs.update', 'libelle' => 'Modifier un fournisseur'],
            ['name' => 'fournisseurs.delete', 'libelle' => 'Supprimer un fournisseur'],
            ['name' => 'fournisseurs.restore', 'libelle' => 'Restaurer un fournisseur'],
            ['name' => 'fournisseurs.force_delete', 'libelle' => 'Supprimer définitivement un fournisseur'],

            // === GESTION DES ENTREPÔTS ===
            ['name' => 'entrepots.view', 'libelle' => 'Consulter les entrepôts'],
            ['name' => 'entrepots.create', 'libelle' => 'Créer un entrepôt'],
            ['name' => 'entrepots.update', 'libelle' => 'Modifier un entrepôt'],
            ['name' => 'entrepots.delete', 'libelle' => 'Supprimer un entrepôt'],
            ['name' => 'entrepots.assign_user', 'libelle' => 'Assigner un responsable à un entrepôt'],
            ['name' => 'entrepots.unassign_user', 'libelle' => 'Retirer un responsable d\'un entrepôt'],
            ['name' => 'entrepots.change_user', 'libelle' => 'Changer le responsable d\'un entrepôt'],
            ['name' => 'entrepots.view_stocks', 'libelle' => 'Voir les stocks d\'un entrepôt'],
            ['name' => 'entrepots.own_only', 'libelle' => 'Accès limité à son propre entrepôt'],

            // === GESTION DES CATÉGORIES DE PRODUITS ===
            ['name' => 'product_categories.view', 'libelle' => 'Consulter les catégories de produits'],
            ['name' => 'product_categories.create', 'libelle' => 'Créer une catégorie'],
            ['name' => 'product_categories.update', 'libelle' => 'Modifier une catégorie'],
            ['name' => 'product_categories.delete', 'libelle' => 'Supprimer une catégorie'],

            // === GESTION DES PRODUITS ===
            ['name' => 'products.view', 'libelle' => 'Consulter les produits'],
            ['name' => 'products.create', 'libelle' => 'Créer un produit'],
            ['name' => 'products.update', 'libelle' => 'Modifier un produit'],
            ['name' => 'products.delete', 'libelle' => 'Supprimer un produit'],
            ['name' => 'products.restore', 'libelle' => 'Restaurer un produit'],
            ['name' => 'products.force_delete', 'libelle' => 'Supprimer définitivement un produit'],
            ['name' => 'products.by_category', 'libelle' => 'Voir les produits par catégorie'],

            // === GESTION DES STOCKS ===
            ['name' => 'stocks.view', 'libelle' => 'Consulter les stocks'],
            ['name' => 'stocks.create', 'libelle' => 'Créer un stock'],
            ['name' => 'stocks.update', 'libelle' => 'Modifier un stock'],
            ['name' => 'stocks.delete', 'libelle' => 'Supprimer un stock'],
            ['name' => 'stocks.adjust', 'libelle' => 'Ajuster les quantités en stock'],
            ['name' => 'stocks.reserve', 'libelle' => 'Réserver du stock'],
            ['name' => 'stocks.release', 'libelle' => 'Libérer une réservation'],
            ['name' => 'stocks.by_product', 'libelle' => 'Voir les stocks par produit'],
            ['name' => 'stocks.by_entrepot', 'libelle' => 'Voir les stocks par entrepôt'],
            ['name' => 'stocks.restore', 'libelle' => 'Restaurer un stock'],
            ['name' => 'stocks.force_delete', 'libelle' => 'Supprimer définitivement un stock'],

            // === GESTION DES MOUVEMENTS DE STOCK ===
            ['name' => 'stock_movements.view', 'libelle' => 'Consulter les mouvements de stock'],
            ['name' => 'stock_movements.create', 'libelle' => 'Créer un mouvement de stock'],
            ['name' => 'stock_movements.update', 'libelle' => 'Modifier un mouvement de stock'],
            ['name' => 'stock_movements.delete', 'libelle' => 'Supprimer un mouvement de stock'],
            ['name' => 'stock_movements.validate', 'libelle' => 'Valider un mouvement de stock'],
            ['name' => 'stock_movements.cancel', 'libelle' => 'Annuler un mouvement de stock'],
            ['name' => 'stock_movements.transfer', 'libelle' => 'Effectuer un transfert entre entrepôts'],
            ['name' => 'stock_movements.receipt', 'libelle' => 'Enregistrer une réception fournisseur'],
            ['name' => 'stock_movements.update_status', 'libelle' => 'Modifier le statut d\'un mouvement'],
            ['name' => 'stock_movements.restore', 'libelle' => 'Restaurer un mouvement'],
            ['name' => 'stock_movements.trashed', 'libelle' => 'Voir les mouvements supprimés'],

            // === GESTION DES TYPES DE MOUVEMENTS ===
            ['name' => 'stock_movement_types.view', 'libelle' => 'Consulter les types de mouvements'],
            ['name' => 'stock_movement_types.create', 'libelle' => 'Créer un type de mouvement'],
            ['name' => 'stock_movement_types.update', 'libelle' => 'Modifier un type de mouvement'],
            ['name' => 'stock_movement_types.delete', 'libelle' => 'Supprimer un type de mouvement'],
            ['name' => 'stock_movement_types.restore', 'libelle' => 'Restaurer un type de mouvement'],

            // === GESTION DES DÉTAILS DE MOUVEMENTS ===
            ['name' => 'stock_movement_details.view', 'libelle' => 'Consulter les détails de mouvements'],
            ['name' => 'stock_movement_details.create', 'libelle' => 'Créer un détail de mouvement'],
            ['name' => 'stock_movement_details.update', 'libelle' => 'Modifier un détail de mouvement'],
            ['name' => 'stock_movement_details.delete', 'libelle' => 'Supprimer un détail de mouvement'],
            ['name' => 'stock_movement_details.restore', 'libelle' => 'Restaurer un détail de mouvement'],

            // === GESTION DES COMMANDES D'ACHAT ===
            ['name' => 'commandes.view', 'libelle' => 'Consulter les commandes'],
            ['name' => 'commandes.create', 'libelle' => 'Créer une commande'],
            ['name' => 'commandes.update', 'libelle' => 'Modifier une commande'],
            ['name' => 'commandes.delete', 'libelle' => 'Supprimer une commande'],
            ['name' => 'commandes.restore', 'libelle' => 'Restaurer une commande'],
            ['name' => 'commandes.distribute', 'libelle' => 'Répartir une commande aux entrepôts'],
            ['name' => 'commandes.view_distribution', 'libelle' => 'Voir l\'historique de distribution'],
            ['name' => 'commandes.trashed', 'libelle' => 'Voir les commandes supprimées'],

            // === GESTION DES DÉTAILS DE COMMANDES ===
            ['name' => 'detail_commandes.view', 'libelle' => 'Consulter les détails de commandes'],
            ['name' => 'detail_commandes.create', 'libelle' => 'Créer un détail de commande'],
            ['name' => 'detail_commandes.create_multiple', 'libelle' => 'Créer plusieurs détails de commande'],
            ['name' => 'detail_commandes.update', 'libelle' => 'Modifier un détail de commande'],
            ['name' => 'detail_commandes.delete', 'libelle' => 'Supprimer un détail de commande'],
            ['name' => 'detail_commandes.restore', 'libelle' => 'Restaurer un détail de commande'],

            // === GESTION DES PAIEMENTS DE COMMANDES ===
            ['name' => 'paiement_commandes.view', 'libelle' => 'Consulter les paiements de commandes'],
            ['name' => 'paiement_commandes.create', 'libelle' => 'Créer un paiement de commande'],
            ['name' => 'paiement_commandes.update', 'libelle' => 'Modifier un paiement de commande'],
            ['name' => 'paiement_commandes.delete', 'libelle' => 'Supprimer un paiement de commande'],
            ['name' => 'paiement_commandes.restore', 'libelle' => 'Restaurer un paiement de commande'],

            // === GESTION DES VENTES ===
            ['name' => 'ventes.view', 'libelle' => 'Consulter les ventes'],
            ['name' => 'ventes.create', 'libelle' => 'Créer une vente'],
            ['name' => 'ventes.update', 'libelle' => 'Modifier une vente'],
            ['name' => 'ventes.delete', 'libelle' => 'Supprimer une vente'],
            ['name' => 'ventes.restore', 'libelle' => 'Restaurer une vente'],
            ['name' => 'ventes.trashed', 'libelle' => 'Voir les ventes supprimées'],

            // === GESTION DES DÉTAILS DE VENTES ===
            ['name' => 'detail_ventes.view', 'libelle' => 'Consulter les détails de ventes'],
            ['name' => 'detail_ventes.create', 'libelle' => 'Créer un détail de vente'],
            ['name' => 'detail_ventes.create_multiple', 'libelle' => 'Créer plusieurs détails de vente'],
            ['name' => 'detail_ventes.update', 'libelle' => 'Modifier un détail de vente'],
            ['name' => 'detail_ventes.delete', 'libelle' => 'Supprimer un détail de vente'],
            ['name' => 'detail_ventes.restore', 'libelle' => 'Restaurer un détail de vente'],

            // === GESTION DES PAIEMENTS DE VENTES ===
            ['name' => 'paiement_ventes.view', 'libelle' => 'Consulter les paiements de ventes'],
            ['name' => 'paiement_ventes.create', 'libelle' => 'Créer un paiement de vente'],
            ['name' => 'paiement_ventes.update', 'libelle' => 'Modifier un paiement de vente'],
            ['name' => 'paiement_ventes.delete', 'libelle' => 'Supprimer un paiement de vente'],
            ['name' => 'paiement_ventes.restore', 'libelle' => 'Restaurer un paiement de vente'],

            // === GESTION DES FACTURES ===
            ['name' => 'factures.view', 'libelle' => 'Consulter les factures'],
            ['name' => 'factures.create', 'libelle' => 'Créer une facture'],
            ['name' => 'factures.update', 'libelle' => 'Modifier une facture'],
            ['name' => 'factures.delete', 'libelle' => 'Supprimer une facture'],
            ['name' => 'factures.update_status', 'libelle' => 'Modifier le statut d\'une facture'],
            ['name' => 'factures.stats', 'libelle' => 'Voir les statistiques des factures'],

            // === GESTION DES PAIEMENTS ===
            ['name' => 'paiements.view', 'libelle' => 'Consulter les paiements'],
            ['name' => 'paiements.create', 'libelle' => 'Créer un paiement'],
            ['name' => 'paiements.update', 'libelle' => 'Modifier un paiement'],
            ['name' => 'paiements.delete', 'libelle' => 'Supprimer un paiement'],
            ['name' => 'paiements.update_status', 'libelle' => 'Modifier le statut d\'un paiement'],
            ['name' => 'paiements.stats', 'libelle' => 'Voir les statistiques des paiements'],

            // === GESTION DES MÉTHODES DE PAIEMENT ===
            ['name' => 'payment_methods.view', 'libelle' => 'Consulter les méthodes de paiement'],
            ['name' => 'payment_methods.create', 'libelle' => 'Créer une méthode de paiement'],
            ['name' => 'payment_methods.update', 'libelle' => 'Modifier une méthode de paiement'],
            ['name' => 'payment_methods.delete', 'libelle' => 'Supprimer une méthode de paiement'],
            ['name' => 'payment_methods.toggle_status', 'libelle' => 'Activer/Désactiver une méthode de paiement'],
            ['name' => 'payment_methods.stats', 'libelle' => 'Voir les statistiques des méthodes de paiement'],

            // === GESTION DES LIVRAISONS ===
            ['name' => 'deliveries.view', 'libelle' => 'Consulter les livraisons'],
            ['name' => 'deliveries.create', 'libelle' => 'Créer une livraison'],
            ['name' => 'deliveries.update', 'libelle' => 'Modifier une livraison'],
            ['name' => 'deliveries.delete', 'libelle' => 'Supprimer une livraison'],
            ['name' => 'deliveries.start', 'libelle' => 'Démarrer une livraison'],
            ['name' => 'deliveries.complete', 'libelle' => 'Terminer une livraison'],
            ['name' => 'deliveries.cancel', 'libelle' => 'Annuler une livraison'],
            ['name' => 'deliveries.stats', 'libelle' => 'Voir les statistiques des livraisons'],

            // === GESTION DES DÉTAILS DE LIVRAISON ===
            ['name' => 'delivery_details.view', 'libelle' => 'Consulter les détails de livraison'],
            ['name' => 'delivery_details.update', 'libelle' => 'Modifier un détail de livraison'],
            ['name' => 'delivery_details.preparer', 'libelle' => 'Préparer un produit pour livraison'],
            ['name' => 'delivery_details.livrer', 'libelle' => 'Marquer un produit comme livré'],
            ['name' => 'delivery_details.retourner', 'libelle' => 'Retourner un produit'],
            ['name' => 'delivery_details.preparer_tout', 'libelle' => 'Préparer tous les produits d\'une livraison'],

            // === GESTION DES CHAUFFEURS ===
            ['name' => 'chauffeurs.view', 'libelle' => 'Consulter les chauffeurs'],
            ['name' => 'chauffeurs.create', 'libelle' => 'Créer un chauffeur'],
            ['name' => 'chauffeurs.update', 'libelle' => 'Modifier un chauffeur'],
            ['name' => 'chauffeurs.delete', 'libelle' => 'Supprimer un chauffeur'],
            ['name' => 'chauffeurs.restore', 'libelle' => 'Restaurer un chauffeur'],
            ['name' => 'chauffeurs.trashed', 'libelle' => 'Voir les chauffeurs supprimés'],

            // === GESTION DES CAMIONS ===
            ['name' => 'camions.view', 'libelle' => 'Consulter les camions'],
            ['name' => 'camions.create', 'libelle' => 'Créer un camion'],
            ['name' => 'camions.update', 'libelle' => 'Modifier un camion'],
            ['name' => 'camions.delete', 'libelle' => 'Supprimer un camion'],
            ['name' => 'camions.restore', 'libelle' => 'Restaurer un camion'],
            ['name' => 'camions.trashed', 'libelle' => 'Voir les camions supprimés'],

            // === RÔLES ET PERMISSIONS ===
            ['name' => 'roles.view', 'libelle' => 'Consulter les rôles'],
            ['name' => 'roles.create', 'libelle' => 'Créer un rôle'],
            ['name' => 'roles.update', 'libelle' => 'Modifier un rôle'],
            ['name' => 'roles.delete', 'libelle' => 'Supprimer un rôle'],
            ['name' => 'permissions.view', 'libelle' => 'Consulter les permissions'],
            ['name' => 'permissions.assign', 'libelle' => 'Assigner des permissions'],
            ['name' => 'permissions.revoke', 'libelle' => 'Révoquer des permissions'],

            // === RAPPORTS ET STATISTIQUES ===
            ['name' => 'rapports.view', 'libelle' => 'Consulter les rapports'],
            ['name' => 'rapports.generate', 'libelle' => 'Générer des rapports'],
            ['name' => 'rapports.export', 'libelle' => 'Exporter des rapports'],
            ['name' => 'rapports.stocks', 'libelle' => 'Rapport des stocks'],
            ['name' => 'rapports.ventes', 'libelle' => 'Rapport des ventes'],
            ['name' => 'rapports.achats', 'libelle' => 'Rapport des achats'],
            ['name' => 'rapports.financier', 'libelle' => 'Rapport financier'],
            ['name' => 'rapports.livraisons', 'libelle' => 'Rapport des livraisons'],

            // === EXPORTS ===
            ['name' => 'export.pdf', 'libelle' => 'Exporter en PDF'],
            ['name' => 'export.excel', 'libelle' => 'Exporter en Excel'],
            ['name' => 'export.csv', 'libelle' => 'Exporter en CSV'],

            // === SYSTÈME (Super Admin uniquement) ===
            ['name' => 'system.settings', 'libelle' => 'Modifier les paramètres système'],
            ['name' => 'system.logs', 'libelle' => 'Consulter les logs système'],
            ['name' => 'system.backup', 'libelle' => 'Gérer les sauvegardes'],
            ['name' => 'system.maintenance', 'libelle' => 'Activer le mode maintenance'],
            ['name' => 'system.database', 'libelle' => 'Gérer la base de données'],
            ['name' => 'system.health', 'libelle' => 'Vérifier la santé du système'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'name' => $permission['name'],
                    'libelle' => $permission['libelle'],
                    'guard_name' => 'web'
                ]
            );
        }

        $this->command->info('✅ Permissions créées avec succès !');
        $this->command->info('📊 Total : ' . count($permissions) . ' permissions');
    }
}
