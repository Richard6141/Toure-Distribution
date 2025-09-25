<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    /**
     * Afficher toutes les catégories de produits
     *
     * @group Product Categories
     * @response 200 scenario="Liste des catégories"
     * [
     *   {
     *     "product_category_id": "uuid",
     *     "label": "Électronique",
     *     "description": "Produits high-tech",
     *     "is_active": true,
     *     "created_at": "2025-09-24T12:00:00.000000Z",
     *     "updated_at": "2025-09-24T12:00:00.000000Z"
     *   }
     * ]
     */
    public function index(): JsonResponse
    {
        $categories = ProductCategory::orderBy('label')->get();
        return response()->json($categories);
    }

    /**
     * Créer une nouvelle catégorie de produit
     *
     * @group Product Categories
     * @bodyParam label string required Nom de la catégorie. Example: Électronique
     * @bodyParam description string Description de la catégorie. Example: Produits high-tech
     * @bodyParam is_active boolean Statut actif ou non (true/false). Example: true
     * 
     * @response 201 scenario="Succès"
     * {
     *   "product_category_id": "uuid",
     *   "label": "Électronique",
     *   "description": "Produits high-tech",
     *   "is_active": true,
     *   "created_at": "2025-09-24T12:00:00.000000Z",
     *   "updated_at": "2025-09-24T12:00:00.000000Z"
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'label' => 'required|string|max:255|unique:product_categories,label',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = ProductCategory::create($validator->validated());

        return response()->json($category, 201);
    }

    /**
     * Afficher une catégorie de produit
     *
     * @group Product Categories
     * @urlParam id string required L'UUID de la catégorie. Example: 9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4
     * 
     * @response 200 scenario="Succès"
     * {
     *   "product_category_id": "uuid",
     *   "label": "Électronique",
     *   "description": "Produits high-tech",
     *   "is_active": true,
     *   "created_at": "2025-09-24T12:00:00.000000Z",
     *   "updated_at": "2025-09-24T12:00:00.000000Z"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Mettre à jour une catégorie de produit
     *
     * @group Product Categories
     * @urlParam id string required L'UUID de la catégorie. Example: 9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4
     * @bodyParam label string required Nom de la catégorie (unique). Example: Accessoires
     * @bodyParam description string Description de la catégorie. Example: Produits dérivés
     * @bodyParam is_active boolean Statut actif ou non (true/false). Example: false
     * 
     * @response 200 scenario="Succès"
     * {
     *   "product_category_id": "uuid",
     *   "label": "Accessoires",
     *   "description": "Produits dérivés",
     *   "is_active": false,
     *   "created_at": "2025-09-24T12:00:00.000000Z",
     *   "updated_at": "2025-09-24T12:30:00.000000Z"
     * }
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);

        $rules = [
            'label' => 'required|string|max:255|unique:product_categories,label,' . $id . ',product_category_id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->update($validator->validated());

        return response()->json($category);
    }

    /**
     * Supprimer une catégorie de produit
     *
     * @group Product Categories
     * @urlParam id string required L'UUID de la catégorie. Example: 9a4c8e1f-5b52-4e7d-bc83-0a7c1d0b33f4
     * 
     * @response 200 scenario="Succès"
     * {
     *   "message": "Catégorie supprimée avec succès."
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Catégorie supprimée avec succès.']);
    }
}
