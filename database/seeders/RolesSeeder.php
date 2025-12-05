<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Récupérer toutes les permissions système
        $systemPermissions = Permission::where('name', 'LIKE', 'system.%')->pluck('name')->toArray();

        // Récupérer toutes les permissions sauf système
        $allPermissionsExceptSystem = Permission::where('name', 'NOT LIKE', 'system.%')->pluck('name')->toArray();

        // Définition des rôles avec leurs permissions
        $rolesPermissions = [
            // === SUPER ADMIN ===
            'Super Admin' => 'all', // Toutes les permissions

            // === ADMINISTRATEUR ===
            'Administrateur' => 'all_except_system',

            // === GESTIONNAIRE DE STOCK ===
            'Gestionnaire de stock' => [
                // Produits et catégories
                'products.view',
                'products.create',
                'products.update',
                'products.delete',
                'products.restore',
                'products.by_category',
                'product_categories.view',
                'product_categories.create',
                'product_categories.update',
                'product_categories.delete',

                // Stocks
                'stocks.view',
                'stocks.create',
                'stocks.update',
                'stocks.adjust',
                'stocks.reserve',
                'stocks.release',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Mouvements de stock
                'stock_movements.view',
                'stock_movements.create',
                'stock_movements.update',
                'stock_movements.validate',
                'stock_movements.cancel',
                'stock_movements.transfer',
                'stock_movements.receipt',
                'stock_movements.update_status',
                'stock_movement_types.view',
                'stock_movement_details.view',
                'stock_movement_details.create',
                'stock_movement_details.update',

                // Entrepôts
                'entrepots.view',
                'entrepots.view_stocks',

                // Fournisseurs (consultation)
                'fournisseurs.view',

                // Commandes (consultation pour réception)
                'commandes.view',
                'detail_commandes.view',

                // Rapports
                'rapports.view',
                'rapports.generate',
                'rapports.stocks',
                'export.pdf',
                'export.excel',
                'export.csv',
            ],

            // === RESPONSABLE DES ACHATS ===
            'Responsable des achats' => [
                // Fournisseurs
                'fournisseurs.view',
                'fournisseurs.create',
                'fournisseurs.update',
                'fournisseurs.delete',

                // Commandes
                'commandes.view',
                'commandes.create',
                'commandes.update',
                'commandes.delete',
                'commandes.distribute',
                'commandes.view_distribution',
                'detail_commandes.view',
                'detail_commandes.create',
                'detail_commandes.create_multiple',
                'detail_commandes.update',
                'detail_commandes.delete',

                // Paiements de commandes
                'paiement_commandes.view',
                'paiement_commandes.create',
                'paiement_commandes.update',

                // Produits (consultation)
                'products.view',
                'products.by_category',
                'product_categories.view',

                // Stocks (consultation)
                'stocks.view',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Entrepôts (consultation)
                'entrepots.view',
                'entrepots.view_stocks',

                // Mouvements de stock (réception)
                'stock_movements.view',
                'stock_movements.receipt',
                'stock_movements.validate',

                // Rapports
                'rapports.view',
                'rapports.generate',
                'rapports.achats',
                'rapports.stocks',
                'export.pdf',
                'export.excel',
            ],

            // === RESPONSABLE DES VENTES ===
            'Responsable des ventes' => [
                // Clients
                'clients.view',
                'clients.create',
                'clients.update',
                'clients.toggle_status',
                'clients.update_balance',
                'clients.search',
                'clients.stats',
                'client_types.view',
                'client_types.create',
                'client_types.update',

                // Ventes
                'ventes.view',
                'ventes.create',
                'ventes.update',
                'ventes.delete',
                'detail_ventes.view',
                'detail_ventes.create',
                'detail_ventes.create_multiple',
                'detail_ventes.update',
                'detail_ventes.delete',

                // Paiements de ventes
                'paiement_ventes.view',
                'paiement_ventes.create',
                'paiement_ventes.update',

                // Factures
                'factures.view',
                'factures.create',
                'factures.update',
                'factures.update_status',
                'factures.stats',

                // Livraisons
                'deliveries.view',
                'deliveries.create',
                'deliveries.update',
                'deliveries.start',
                'deliveries.complete',
                'deliveries.cancel',
                'deliveries.stats',
                'delivery_details.view',
                'delivery_details.update',

                // Produits (consultation)
                'products.view',
                'products.by_category',
                'product_categories.view',

                // Stocks (consultation)
                'stocks.view',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Entrepôts (consultation)
                'entrepots.view',
                'entrepots.view_stocks',

                // Chauffeurs et camions
                'chauffeurs.view',
                'chauffeurs.create',
                'chauffeurs.update',
                'camions.view',
                'camions.create',
                'camions.update',

                // Rapports
                'rapports.view',
                'rapports.generate',
                'rapports.ventes',
                'rapports.livraisons',
                'rapports.financier',
                'export.pdf',
                'export.excel',
            ],

            // === COMPTABLE ===
            'Comptable' => [
                // Factures
                'factures.view',
                'factures.create',
                'factures.update',
                'factures.delete',
                'factures.update_status',
                'factures.stats',

                // Paiements
                'paiements.view',
                'paiements.create',
                'paiements.update',
                'paiements.delete',
                'paiements.update_status',
                'paiements.stats',

                // Méthodes de paiement
                'payment_methods.view',
                'payment_methods.create',
                'payment_methods.update',
                'payment_methods.toggle_status',
                'payment_methods.stats',

                // Paiements de commandes
                'paiement_commandes.view',
                'paiement_commandes.create',
                'paiement_commandes.update',
                'paiement_commandes.delete',

                // Paiements de ventes
                'paiement_ventes.view',
                'paiement_ventes.create',
                'paiement_ventes.update',
                'paiement_ventes.delete',

                // Clients (consultation et gestion du solde)
                'clients.view',
                'clients.update_balance',
                'clients.search',
                'clients.stats',

                // Fournisseurs (consultation)
                'fournisseurs.view',

                // Ventes (consultation)
                'ventes.view',
                'detail_ventes.view',

                // Commandes (consultation)
                'commandes.view',
                'detail_commandes.view',

                // Rapports
                'rapports.view',
                'rapports.generate',
                'rapports.export',
                'rapports.financier',
                'rapports.ventes',
                'rapports.achats',
                'export.pdf',
                'export.excel',
                'export.csv',
            ],

            // === GESTIONNAIRE D'ENTREPÔT ===
            'Gestionnaire d\'entrepôt' => [
                // Entrepôts (limité au sien)
                'entrepots.view',
                'entrepots.view_stocks',
                'entrepots.own_only',

                // Produits (consultation)
                'products.view',
                'products.by_category',
                'product_categories.view',

                // Stocks (son entrepôt)
                'stocks.view',
                'stocks.update',
                'stocks.adjust',
                'stocks.reserve',
                'stocks.release',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Mouvements de stock
                'stock_movements.view',
                'stock_movements.create',
                'stock_movements.update',
                'stock_movements.validate',
                'stock_movements.transfer',
                'stock_movements.receipt',
                'stock_movements.update_status',
                'stock_movement_details.view',
                'stock_movement_details.create',
                'stock_movement_details.update',

                // Livraisons (préparation)
                'deliveries.view',
                'delivery_details.view',
                'delivery_details.update',
                'delivery_details.preparer',
                'delivery_details.preparer_tout',

                // Rapports
                'rapports.view',
                'rapports.generate',
                'rapports.stocks',
                'export.pdf',
                'export.excel',
            ],

            // === LIVREUR / CHAUFFEUR ===
            'Livreur' => [
                // Livraisons
                'deliveries.view',
                'deliveries.start',
                'deliveries.complete',
                'delivery_details.view',
                'delivery_details.livrer',
                'delivery_details.retourner',

                // Clients (consultation)
                'clients.view',

                // Produits (consultation)
                'products.view',

                // Camions (consultation)
                'camions.view',
            ],

            // === AGENT COMMERCIAL ===
            'Agent commercial' => [
                // Clients
                'clients.view',
                'clients.create',
                'clients.update',
                'clients.search',
                'clients.stats',
                'client_types.view',

                // Ventes
                'ventes.view',
                'ventes.create',
                'ventes.update',
                'detail_ventes.view',
                'detail_ventes.create',
                'detail_ventes.create_multiple',
                'detail_ventes.update',

                // Paiements de ventes (consultation)
                'paiement_ventes.view',

                // Factures (consultation)
                'factures.view',

                // Produits (consultation)
                'products.view',
                'products.by_category',
                'product_categories.view',

                // Stocks (consultation)
                'stocks.view',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Livraisons (consultation et création)
                'deliveries.view',
                'deliveries.create',
                'delivery_details.view',

                // Rapports
                'rapports.view',
                'rapports.ventes',
                'export.pdf',
            ],

            // === MAGASINIER ===
            'Magasinier' => [
                // Entrepôts (limité au sien)
                'entrepots.view',
                'entrepots.view_stocks',
                'entrepots.own_only',

                // Produits (consultation)
                'products.view',
                'products.by_category',
                'product_categories.view',

                // Stocks (consultation et ajustements basiques)
                'stocks.view',
                'stocks.adjust',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Mouvements de stock (consultation et création)
                'stock_movements.view',
                'stock_movements.create',
                'stock_movement_details.view',
                'stock_movement_details.create',

                // Livraisons (préparation)
                'delivery_details.view',
                'delivery_details.preparer',
                'delivery_details.preparer_tout',
            ],

            // === CAISSIER / CAISSIÈRE ===
            'Caissier' => [
                // Caisse - permissions complètes
                'caisse.view',
                'caisse.create',
                'caisse.delete',
                'caisse.restore',
                'caisse.search_client',
                'caisse.view_client_info',
                'caisse.view_client_history',
                'caisse.stats',
                'caisse.trashed',
                'caisse.debtors',

                // Clients (consultation)
                'clients.view',
                'clients.search',

                // Produits (consultation pour information)
                'products.view',

                // Rapports
                'rapports.view',
                'rapports.financier',
                'export.pdf',
            ],

            // === DIRECTEUR GÉNÉRAL ===
            'Directeur général' => [
                // Vue d'ensemble complète (lecture seule principalement)
                'users.view',
                'users.stats',

                // Clients
                'clients.view',
                'clients.stats',
                'client_types.view',

                // Fournisseurs
                'fournisseurs.view',

                // Produits
                'products.view',
                'product_categories.view',

                // Stocks
                'stocks.view',
                'stocks.by_product',
                'stocks.by_entrepot',

                // Entrepôts
                'entrepots.view',
                'entrepots.view_stocks',

                // Mouvements de stock
                'stock_movements.view',

                // Commandes
                'commandes.view',
                'detail_commandes.view',
                'paiement_commandes.view',

                // Ventes
                'ventes.view',
                'detail_ventes.view',
                'paiement_ventes.view',

                // Factures et paiements
                'factures.view',
                'factures.stats',
                'paiements.view',
                'paiements.stats',
                'payment_methods.view',
                'payment_methods.stats',

                // Livraisons
                'deliveries.view',
                'deliveries.stats',
                'delivery_details.view',

                // Chauffeurs et camions
                'chauffeurs.view',
                'camions.view',

                // Rapports (tous)
                'rapports.view',
                'rapports.generate',
                'rapports.export',
                'rapports.stocks',
                'rapports.ventes',
                'rapports.achats',
                'rapports.financier',
                'rapports.livraisons',

                // Export
                'export.pdf',
                'export.excel',
                'export.csv',
            ],
        ];

        // Création des rôles et assignation des permissions
        foreach ($rolesPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if ($permissions === 'all') {
                // Pour le Super Admin, assigner toutes les permissions
                $role->syncPermissions(Permission::all());
            } elseif ($permissions === 'all_except_system') {
                // Pour l'Administrateur, assigner toutes les permissions sauf système
                $role->syncPermissions($allPermissionsExceptSystem);
            } elseif (is_array($permissions)) {
                // Vérifier que toutes les permissions existent avant de les assigner
                $existingPermissions = Permission::whereIn('name', $permissions)->pluck('name')->toArray();
                $missingPermissions = array_diff($permissions, $existingPermissions);

                if (!empty($missingPermissions)) {
                    $this->command->warn("⚠️  Permissions manquantes pour le rôle {$roleName}: " . implode(', ', $missingPermissions));
                }

                $role->syncPermissions($existingPermissions);
            }
        }

        $this->command->info('✅ Rôles et permissions assignés avec succès !');

        // Affichage des rôles créés avec comptage des permissions
        $this->command->info("\n" . str_repeat('=', 80));
        $this->command->info('📋 RÉSUMÉ DES RÔLES CRÉÉS');
        $this->command->info(str_repeat('=', 80));

        foreach (array_keys($rolesPermissions) as $roleName) {
            $role = Role::where('name', $roleName)->first();
            $permissionCount = $role ? $role->permissions()->count() : 0;

            // Vérifier si le rôle a des permissions système
            $hasSystemPerms = false;
            if ($role) {
                $rolePermissions = $role->permissions()->pluck('name')->toArray();
                $hasSystemPerms = !empty(array_intersect($rolePermissions, $systemPermissions));
            }

            $systemIndicator = $hasSystemPerms ? ' 🔒 [+SYSTÈME]' : '';
            $icon = $this->getRoleIcon($roleName);

            $this->command->line(sprintf(
                "%s %-30s : %3d permissions%s",
                $icon,
                $roleName,
                $permissionCount,
                $systemIndicator
            ));
        }

        $this->command->info(str_repeat('=', 80));
        $this->command->info("📊 Total permissions dans le système: " . Permission::count());
        $this->command->info("🔒 Permissions système: " . count($systemPermissions));
        $this->command->info(str_repeat('=', 80));
    }

    /**
     * Obtenir une icône pour chaque rôle
     */
    private function getRoleIcon(string $roleName): string
    {
        $icons = [
            'Super Admin' => '👑',
            'Administrateur' => '⚙️',
            'Gestionnaire de stock' => '📦',
            'Responsable des achats' => '🛒',
            'Responsable des ventes' => '💰',
            'Comptable' => '💵',
            'Gestionnaire d\'entrepôt' => '🏭',
            'Livreur' => '🚚',
            'Agent commercial' => '🤝',
            'Magasinier' => '📋',
            'Caissier' => '💳',
            'Directeur général' => '🎯',
        ];

        return $icons[$roleName] ?? '👤';
    }
}
