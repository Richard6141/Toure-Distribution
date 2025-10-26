<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserListResource;

/**
 * @group Gestion des Rôles et Permissions
 *
 * API pour gérer les rôles, permissions et leurs assignations
 */
class RolePermissionController extends Controller
{
    // ==================== GESTION DES RÔLES ====================

    /**
     * Liste des rôles
     *
     * Récupère la liste de tous les rôles avec leurs permissions et statistiques.
     *
     * @authenticated
     *
     * @queryParam search string Rechercher un rôle par nom. Example: Admin
     * @queryParam per_page int Nombre d'éléments par page. Example: 15
     * @queryParam with_permissions bool Inclure les permissions de chaque rôle. Example: true
     * @queryParam with_users_count bool Inclure le nombre d'utilisateurs par rôle. Example: true
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des rôles récupérée avec succès",
     *   "data": {
     *     "roles": [
     *       {
     *         "id": 1,
     *         "name": "Super Admin",
     *         "guard_name": "web",
     *         "created_at": "2025-01-15T10:30:00.000000Z",
     *         "updated_at": "2025-01-15T10:30:00.000000Z",
     *         "permissions_count": 161,
     *         "users_count": 2,
     *         "permissions": [
     *           {
     *             "id": 1,
     *             "name": "users.view",
     *             "libelle": "Consulter les utilisateurs"
     *           }
     *         ]
     *       }
     *     ],
     *     "pagination": {
     *       "total": 11,
     *       "per_page": 15,
     *       "current_page": 1,
     *       "last_page": 1
     *     }
     *   }
     * }
     */
    public function indexRoles(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $search = $request->get('search');
            $withPermissions = $request->boolean('with_permissions', false);
            $withUsersCount = $request->boolean('with_users_count', true);

            $query = Role::query();

            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            }

            if ($withPermissions) {
                $query->with('permissions:id,name,libelle');
            }

            $query->withCount('permissions');

            $roles = $query->paginate($perPage);

            // ✅ COMPTAGE MANUEL POUR UUID
            if ($withUsersCount) {
                $roles->getCollection()->transform(function ($role) {
                    $role->users_count = DB::table('model_has_roles')
                        ->where('role_id', $role->id)
                        ->where('model_type', User::class)
                        ->count();
                    return $role;
                });
            }

            return response()->json([
                'success' => true,
                'message' => 'Liste des rôles récupérée avec succès',
                'data' => [
                    'roles' => RoleResource::collection($roles->items()),
                    'pagination' => [
                        'total' => $roles->total(),
                        'per_page' => $roles->perPage(),
                        'current_page' => $roles->currentPage(),
                        'last_page' => $roles->lastPage(),
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des rôles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer un rôle
     *
     * Crée un nouveau rôle avec ou sans permissions.
     *
     * @authenticated
     *
     * @bodyParam name string required Le nom du rôle. Example: Superviseur
     * @bodyParam permissions array Les IDs des permissions à assigner. Example: [1, 2, 3]
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Rôle créé avec succès",
     *   "data": {
     *     "role": {
     *       "id": 12,
     *       "name": "Superviseur",
     *       "guard_name": "web",
     *       "created_at": "2025-10-18T15:30:00.000000Z",
     *       "updated_at": "2025-10-18T15:30:00.000000Z",
     *       "permissions": [
     *         {
     *           "id": 1,
     *           "name": "users.view",
     *           "libelle": "Consulter les utilisateurs"
     *         }
     *       ]
     *     }
     *   }
     * }
     *
     * @response 422 {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "name": ["Le nom du rôle est obligatoire"]
     *   }
     * }
     */
    public function storeRole(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id'
            ], [
                'name.required' => 'Le nom du rôle est obligatoire',
                'name.unique' => 'Ce nom de rôle existe déjà',
                'permissions.*.exists' => 'Une ou plusieurs permissions n\'existent pas'
            ]);

            DB::beginTransaction();

            $role = Role::create(['name' => $validated['name']]);

            if (isset($validated['permissions'])) {
                $role->syncPermissions($validated['permissions']);
            }

            $role->load('permissions:id,name,libelle');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rôle créé avec succès',
                'data' => ['role' => new RoleResource($role)]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du rôle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Détails d'un rôle
     *
     * Récupère les informations détaillées d'un rôle spécifique.
     *
     * @authenticated
     *
     * @urlParam id int required L'ID du rôle. Example: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Rôle récupéré avec succès",
     *   "data": {
     *     "role": {
     *       "id": 1,
     *       "name": "Super Admin",
     *       "guard_name": "web",
     *       "created_at": "2025-01-15T10:30:00.000000Z",
     *       "updated_at": "2025-01-15T10:30:00.000000Z",
     *       "permissions_count": 161,
     *       "users_count": 2,
     *       "permissions": [],
     *       "users": []
     *     }
     *   }
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Rôle non trouvé"
     * }
     */
    public function showRole(int $id): JsonResponse
    {
        try {
            $role = Role::with(['permissions:id,name,libelle'])
                ->withCount('permissions')
                ->findOrFail($id);

            // ✅ Charger les utilisateurs manuellement
            $users = DB::table('model_has_roles')
                ->where('role_id', $id)
                ->where('model_type', User::class)
                ->join('users', 'model_has_roles.model_id', '=', 'users.user_id')
                ->select('users.user_id as id', 'users.firstname', 'users.lastname', 'users.email')
                ->get();

            $role->users = $users;
            $role->users_count = $users->count();

            return response()->json([
                'success' => true,
                'message' => 'Rôle récupéré avec succès',
                'data' => ['role' => new RoleResource($role)]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle non trouvé'
            ], 404);
        }
    }

    /**
     * Mettre à jour un rôle
     *
     * Met à jour le nom d'un rôle existant.
     *
     * @authenticated
     *
     * @urlParam id int required L'ID du rôle. Example: 1
     * @bodyParam name string required Le nouveau nom du rôle. Example: Super Administrateur
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Rôle mis à jour avec succès",
     *   "data": {
     *     "role": {
     *       "id": 1,
     *       "name": "Super Administrateur",
     *       "guard_name": "web",
     *       "updated_at": "2025-10-18T15:35:00.000000Z"
     *     }
     *   }
     * }
     */
    public function updateRole(Request $request, int $id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id
            ], [
                'name.required' => 'Le nom du rôle est obligatoire',
                'name.unique' => 'Ce nom de rôle existe déjà'
            ]);

            $role->update(['name' => $validated['name']]);

            return response()->json([
                'success' => true,
                'message' => 'Rôle mis à jour avec succès',
                'data' => ['role' => new RoleResource($role->fresh()->load('permissions'))]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du rôle'
            ], 500);
        }
    }

    /**
     * Supprimer un rôle
     *
     * Supprime un rôle. Impossible si des utilisateurs sont assignés à ce rôle.
     *
     * @authenticated
     *
     * @urlParam id int required L'ID du rôle. Example: 12
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Rôle supprimé avec succès"
     * }
     *
     * @response 409 {
     *   "success": false,
     *   "message": "Impossible de supprimer ce rôle car 5 utilisateur(s) y sont assignés"
     * }
     */
    public function destroyRole(int $id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);

            // ✅ Compter manuellement
            $usersCount = DB::table('model_has_roles')
                ->where('role_id', $id)
                ->where('model_type', User::class)
                ->count();

            if ($usersCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Impossible de supprimer ce rôle car {$usersCount} utilisateur(s) y sont assignés"
                ], 409);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rôle supprimé avec succès'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du rôle'
            ], 500);
        }
    }

    // ==================== GESTION DES PERMISSIONS ====================

    /**
     * Liste des permissions
     *
     * Récupère la liste de toutes les permissions, optionnellement groupées par module.
     *
     * @authenticated
     *
     * @queryParam search string Rechercher une permission. Example: clients
     * @queryParam grouped bool Grouper par module (prefix). Example: true
     * @queryParam per_page int Nombre d'éléments par page (ignoré si grouped=true). Example: 50
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Liste des permissions récupérée avec succès",
     *   "data": {
     *     "permissions": [
     *       {
     *         "id": 1,
     *         "name": "users.view",
     *         "libelle": "Consulter les utilisateurs",
     *         "guard_name": "web",
     *         "created_at": "2025-01-15T10:30:00.000000Z"
     *       }
     *     ],
     *     "total": 161
     *   }
     * }
     *
     * @response 200 scenario="Groupé par module" {
     *   "success": true,
     *   "message": "Liste des permissions groupées récupérée avec succès",
     *   "data": {
     *     "permissions": {
     *       "users": [
     *         {
     *           "id": 1,
     *           "name": "users.view",
     *           "libelle": "Consulter les utilisateurs"
     *         }
     *       ],
     *       "clients": [
     *         {
     *           "id": 9,
     *           "name": "clients.view",
     *           "libelle": "Consulter les clients"
     *         }
     *       ]
     *     },
     *     "total": 161
     *   }
     * }
     */
    public function indexPermissions(Request $request): JsonResponse
    {
        try {
            $search = $request->get('search');
            $grouped = $request->boolean('grouped', false);
            $perPage = $request->get('per_page', 50);

            $query = Permission::query()->select('id', 'name', 'libelle', 'guard_name', 'created_at');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('libelle', 'LIKE', "%{$search}%");
                });
            }

            if ($grouped) {
                $permissions = $query->get()->groupBy(function ($permission) {
                    return explode('.', $permission->name)[0];
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Liste des permissions groupées récupérée avec succès',
                    'data' => [
                        'permissions' => $permissions,
                        'total' => $query->count()
                    ]
                ], 200);
            }

            $permissions = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Liste des permissions récupérée avec succès',
                'data' => [
                    'permissions' => PermissionResource::collection($permissions->items()),
                    'pagination' => [
                        'total' => $permissions->total(),
                        'per_page' => $permissions->perPage(),
                        'current_page' => $permissions->currentPage(),
                        'last_page' => $permissions->lastPage(),
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des permissions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Créer une permission
     *
     * Crée une nouvelle permission dans le système.
     *
     * @authenticated
     *
     * @bodyParam name string required Le nom de la permission (format: module.action). Example: rapports.custom
     * @bodyParam libelle string required Le libellé descriptif de la permission. Example: Générer des rapports personnalisés
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Permission créée avec succès",
     *   "data": {
     *     "permission": {
     *       "id": 162,
     *       "name": "rapports.custom",
     *       "libelle": "Générer des rapports personnalisés",
     *       "guard_name": "web",
     *       "created_at": "2025-10-18T15:40:00.000000Z"
     *     }
     *   }
     * }
     */
    public function storePermission(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name|regex:/^[a-z_]+\.[a-z_]+$/',
                'libelle' => 'required|string|max:255'
            ], [
                'name.required' => 'Le nom de la permission est obligatoire',
                'name.unique' => 'Cette permission existe déjà',
                'name.regex' => 'Le format doit être: module.action (ex: users.create)',
                'libelle.required' => 'Le libellé est obligatoire'
            ]);

            $permission = Permission::create([
                'name' => $validated['name'],
                'libelle' => $validated['libelle'],
                'guard_name' => 'web'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permission créée avec succès',
                'data' => ['permission' => new PermissionResource($permission)]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la permission',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour une permission
     *
     * Met à jour le libellé d'une permission existante.
     *
     * @authenticated
     *
     * @urlParam id int required L'ID de la permission. Example: 1
     * @bodyParam libelle string required Le nouveau libellé. Example: Voir tous les utilisateurs
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Permission mise à jour avec succès",
     *   "data": {
     *     "permission": {
     *       "id": 1,
     *       "name": "users.view",
     *       "libelle": "Voir tous les utilisateurs",
     *       "updated_at": "2025-10-18T15:45:00.000000Z"
     *     }
     *   }
     * }
     */
    public function updatePermission(Request $request, int $id): JsonResponse
    {
        try {
            $permission = Permission::findOrFail($id);

            $validated = $request->validate([
                'libelle' => 'required|string|max:255'
            ], [
                'libelle.required' => 'Le libellé est obligatoire'
            ]);

            $permission->update(['libelle' => $validated['libelle']]);

            return response()->json([
                'success' => true,
                'message' => 'Permission mise à jour avec succès',
                'data' => ['permission' => new PermissionResource($permission->fresh())]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission non trouvée'
            ], 404);
        }
    }

    /**
     * Supprimer une permission
     *
     * Supprime une permission du système.
     *
     * @authenticated
     *
     * @urlParam id int required L'ID de la permission. Example: 162
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Permission supprimée avec succès"
     * }
     */
    public function destroyPermission(int $id): JsonResponse
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permission supprimée avec succès'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la permission'
            ], 500);
        }
    }

    // ==================== ASSIGNATION RÔLE ↔ PERMISSIONS ====================

    /**
     * Assigner des permissions à un rôle
     *
     * Attribue ou retire des permissions à/d'un rôle spécifique.
     *
     * @authenticated
     *
     * @urlParam roleId int required L'ID du rôle. Example: 5
     * @bodyParam permissions array required Les IDs des permissions à assigner. Example: [1, 2, 3, 10, 15]
     * @bodyParam sync bool Remplacer toutes les permissions (true) ou ajouter (false). Example: true
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Permissions assignées avec succès",
     *   "data": {
     *     "role": "Comptable",
     *     "permissions_count": 30,
     *     "permissions": []
     *   }
     * }
     */
    public function assignPermissionsToRole(Request $request, int $roleId): JsonResponse
    {
        try {
            $role = Role::findOrFail($roleId);

            $validated = $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
                'sync' => 'boolean'
            ], [
                'permissions.required' => 'Les permissions sont obligatoires',
                'permissions.*.exists' => 'Une ou plusieurs permissions n\'existent pas'
            ]);

            $sync = $validated['sync'] ?? true;

            if ($sync) {
                $role->syncPermissions($validated['permissions']);
            } else {
                $role->givePermissionTo($validated['permissions']);
            }

            $role->load('permissions:id,name,libelle');

            return response()->json([
                'success' => true,
                'message' => 'Permissions assignées avec succès',
                'data' => [
                    'role' => new RoleResource($role)
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'assignation des permissions'
            ], 500);
        }
    }

    /**
     * Retirer des permissions d'un rôle
     *
     * Retire des permissions spécifiques d'un rôle.
     *
     * @authenticated
     *
     * @urlParam roleId int required L'ID du rôle. Example: 5
     * @bodyParam permissions array required Les IDs des permissions à retirer. Example: [1, 2, 3]
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Permissions retirées avec succès",
     *   "data": {
     *     "role": "Comptable",
     *     "permissions_removed": 3,
     *     "permissions_remaining": 27
     *   }
     * }
     */
    public function revokePermissionsFromRole(Request $request, int $roleId): JsonResponse
    {
        try {
            $role = Role::findOrFail($roleId);

            $validated = $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id'
            ]);

            $role->revokePermissionTo($validated['permissions']);

            return response()->json([
                'success' => true,
                'message' => 'Permissions retirées avec succès',
                'data' => [
                    'role' => $role->name,
                    'permissions_removed' => count($validated['permissions']),
                    'permissions_remaining' => $role->permissions()->count()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du retrait des permissions'
            ], 500);
        }
    }

    // ==================== ASSIGNATION USER ↔ RÔLES ====================

    /**
     * Assigner des rôles à un utilisateur
     *
     * Attribue un ou plusieurs rôles à un utilisateur.
     *
     * @authenticated
     *
     * @urlParam userId int required L'ID de l'utilisateur. Example: 5
     * @bodyParam roles array required Les IDs ou noms des rôles à assigner. Example: [1, "Comptable"]
     * @bodyParam sync bool Remplacer tous les rôles (true) ou ajouter (false). Example: false
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Rôles assignés avec succès",
     *   "data": {
     *     "user": {
     *       "id": 5,
     *       "name": "John Doe",
     *       "email": "john@example.com"
     *     },
     *     "roles": ["Comptable", "Agent commercial"],
     *     "all_permissions_count": 45
     *   }
     * }
     */
    public function assignRolesToUser(Request $request, int $userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);

            $validated = $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'required',
                'sync' => 'boolean'
            ], [
                'roles.required' => 'Les rôles sont obligatoires'
            ]);

            $sync = $validated['sync'] ?? false;

            // Vérifier que tous les rôles existent
            $roles = collect($validated['roles'])->map(function ($role) {
                if (is_numeric($role)) {
                    return Role::findOrFail($role)->name;
                }
                return $role;
            });

            if ($sync) {
                $user->syncRoles($roles->toArray());
            } else {
                $user->assignRole($roles->toArray());
            }

            $user->load('roles:id,name');

            return response()->json([
                'success' => true,
                'message' => 'Rôles assignés avec succès',
                'data' => [
                    'user' => new UserListResource($user)
                ]
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'assignation des rôles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retirer des rôles d'un utilisateur
     *
     * Retire un ou plusieurs rôles d'un utilisateur.
     *
     * @authenticated
     *
     * @urlParam userId int required L'ID de l'utilisateur. Example: 5
     * @bodyParam roles array required Les IDs ou noms des rôles à retirer. Example: ["Agent commercial"]
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Rôles retirés avec succès",
     *   "data": {
     *     "user": "John Doe",
     *     "roles_removed": 1,
     *     "roles_remaining": ["Comptable"]
     *   }
     * }
     */
    public function revokeRolesFromUser(Request $request, int $userId): JsonResponse
    {
        try {
            $user = User::findOrFail($userId);

            $validated = $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'required'
            ]);

            $roles = collect($validated['roles'])->map(function ($role) {
                if (is_numeric($role)) {
                    return Role::findOrFail($role)->name;
                }
                return $role;
            });

            $user->removeRole($roles->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Rôles retirés avec succès',
                'data' => [
                    'user' => $user->name,
                    'roles_removed' => count($validated['roles']),
                    'roles_remaining' => $user->roles->pluck('name')
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du retrait des rôles'
            ], 500);
        }
    }

    // ==================== CONSULTATION ====================

    /**
     * Utilisateurs par rôle
     *
     * Récupère la liste des utilisateurs ayant un rôle spécifique.
     *
     * @authenticated
     *
     * @urlParam roleId int required L'ID du rôle. Example: 5
     * @queryParam per_page int Nombre d'utilisateurs par page. Example: 15
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Utilisateurs du rôle récupérés avec succès",
     *   "data": {
     *     "role": "Comptable",
     *     "users": [
     *       {
     *         "id": 5,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "created_at": "2025-01-10T08:00:00.000000Z"
     *       }
     *     ],
     *     "total": 3
     *   }
     * }
     */
    public function getUsersByRole(Request $request, int $roleId): JsonResponse
    {
        try {
            $role = Role::findOrFail($roleId);
            $perPage = $request->get('per_page', 15);

            // ✅ Récupérer les IDs des utilisateurs ayant ce rôle
            $userIds = DB::table('model_has_roles')
                ->where('role_id', $roleId)
                ->where('model_type', User::class)
                ->pluck('model_id');

            // Récupérer les utilisateurs complets avec leurs rôles
            $usersQuery = User::whereIn('user_id', $userIds)->with('roles');

            $users = $usersQuery->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Utilisateurs du rôle récupérés avec succès',
                'data' => [
                    'role' => $role->name,
                    'users' => UserListResource::collection($users->items()),
                    'pagination' => [
                        'total' => $users->total(),
                        'per_page' => $users->perPage(),
                        'current_page' => $users->currentPage(),
                        'last_page' => $users->lastPage(),
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle non trouvé'
            ], 404);
        }
    }

    /**
     * Permissions d'un utilisateur
     *
     * Récupère toutes les permissions d'un utilisateur (directes + via rôles).
     *
     * @authenticated
     *
     * @urlParam userId int required L'ID de l'utilisateur. Example: 5
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Permissions de l'utilisateur récupérées avec succès",
     *   "data": {
     *     "user": {
     *       "id": 5,
     *       "name": "John Doe",
     *       "email": "john@example.com"
     *     },
     *     "roles": ["Comptable", "Agent commercial"],
     *     "permissions": [
     *       {
     *         "id": 1,
     *         "name": "users.view",
     *         "libelle": "Consulter les utilisateurs",
     *         "source": "role:Comptable"
     *       }
     *     ],
     *     "total_permissions": 45
     *   }
     * }
     */
    public function getUserPermissions(int $userId): JsonResponse
    {
        try {
            $user = User::with('roles:id,name')->findOrFail($userId);

            $allPermissions = $user->getAllPermissions()->map(function ($permission) use ($user) {
                // Déterminer d'où vient la permission
                $source = 'direct';
                foreach ($user->roles as $role) {
                    if ($role->hasPermissionTo($permission->name)) {
                        $source = 'role:' . $role->name;
                        break;
                    }
                }

                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'libelle' => $permission->libelle,
                    'source' => $source
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Permissions de l\'utilisateur récupérées avec succès',
                'data' => [
                    'user' => new UserListResource($user),
                    'roles' => $user->roles->pluck('name'),
                    'permissions' => $allPermissions,
                    'total_permissions' => $allPermissions->count()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }
    }

    /**
     * Statistiques globales
     *
     * Récupère les statistiques générales sur les rôles et permissions.
     *
     * @authenticated
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Statistiques récupérées avec succès",
     *   "data": {
     *     "total_roles": 11,
     *     "total_permissions": 161,
     *     "total_users_with_roles": 45,
     *     "roles_breakdown": [
     *       {
     *         "role": "Super Admin",
     *         "users_count": 2,
     *         "permissions_count": 161
     *       },
     *       {
     *         "role": "Comptable",
     *         "users_count": 5,
     *         "permissions_count": 30
     *       }
     *     ],
     *     "permissions_by_module": {
     *       "users": 8,
     *       "clients": 9,
     *       "stocks": 15
     *     }
     *   }
     * }
     */
    public function statistics(): JsonResponse
    {
        try {
            $totalRoles = Role::count();
            $totalPermissions = Permission::count();

            $totalUsersWithRoles = DB::table('model_has_roles')
                ->where('model_type', User::class)
                ->distinct('model_id')
                ->count('model_id');

            $rolesBreakdown = Role::withCount('permissions')
                ->get()
                ->map(function ($role) {
                    $usersCount = DB::table('model_has_roles')
                        ->where('role_id', $role->id)
                        ->where('model_type', User::class)
                        ->count();

                    return [
                        'role' => $role->name,
                        'users_count' => $usersCount,
                        'permissions_count' => $role->permissions_count
                    ];
                });

            $permissionsByModule = Permission::all()
                ->groupBy(function ($permission) {
                    return explode('.', $permission->name)[0];
                })
                ->map(function ($group) {
                    return $group->count();
                });

            return response()->json([
                'success' => true,
                'message' => 'Statistiques récupérées avec succès',
                'data' => [
                    'total_roles' => $totalRoles,
                    'total_permissions' => $totalPermissions,
                    'total_users_with_roles' => $totalUsersWithRoles,
                    'roles_breakdown' => $rolesBreakdown,
                    'permissions_by_module' => $permissionsByModule
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
