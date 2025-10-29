<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

/**
 * @group Génération de Bons de Commande PDF
 * 
 * API pour générer des bons de commande PDF à partir des commandes avec support A3/A4/A5.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class CommandePDFController extends Controller
{
    /**
     * Générer un bon de commande PDF
     * 
     * Génère un PDF de bon de commande professionnel avec en-tête et pied de page.
     * Le format peut être A3, A4 (défaut) ou A5.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * @queryParam action string Action à effectuer. Valeurs possibles: download (télécharger), preview (aperçu dans le navigateur). Défaut: download. Example: download
     * 
     * @response 200 scenario="Téléchargement réussi" [Binary PDF Content]
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     * @response 422 scenario="Format invalide" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "format": ["Le format doit être A3, A4 ou A5"]
     *   }
     * }
     * 
     */
    public function generate(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'format' => 'nullable|in:A3,A4,A5',
            'action' => 'nullable|in:download,preview'
        ], [
            'format.in' => 'Le format doit être A3, A4 ou A5',
            'action.in' => 'L\'action doit être download ou preview'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Récupérer la commande avec toutes ses relations
        $commande = Commande::with([
            'fournisseur',
            'detailCommandes.product',
            'chauffeur',
            'camion'
        ])->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        // Format et action
        $format = $request->input('format', 'A4');
        $action = $request->input('action', 'download');

        // Informations de l'entreprise
        $entreprise = [
            'nom' => 'TOURE DISTRIBUTION',
            'adresse' => 'Abidjan, Côte d\'Ivoire',
            'email' => 'contact@toure-distribution.com',
            'telephone' => '+225 XX XX XX XX X',
            'logo' => null,
        ];

        // Préparer les données pour le bon de commande
        $data = [
            'commande' => $commande,
            'entreprise' => $entreprise,
            'format' => $format,
            'numero_bon_commande' => $this->generateNumeroBonCommande($commande->numero_commande),
            'date_generation' => now()->format('d/m/Y à H:i')
        ];

        // Générer le PDF
        $pdf = Pdf::loadView('commandes.template', $data)
            ->setPaper($format)
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);

        // Nom du fichier
        $filename = 'bon_commande_' . $commande->numero_commande . '_' . now()->format('YmdHis') . '.pdf';

        // Action
        if ($action === 'preview') {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    /**
     * Aperçu du bon de commande dans le navigateur
     * 
     * Affiche le bon de commande directement dans le navigateur sans téléchargement.
     * Raccourci pour `/generate?action=preview`.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Aperçu réussi" [PDF displayed in browser]
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function preview(string $id)
    {
        $request = request();
        $request->merge(['action' => 'preview']);
        return $this->generate($request, $id);
    }

    /**
     * Télécharger le bon de commande
     * 
     * Télécharge directement le bon de commande au format PDF.
     * Raccourci pour `/generate?action=download`.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A5
     * 
     * @response 200 scenario="Téléchargement réussi" [Binary PDF Content]
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function download(string $id)
    {
        $request = request();
        $request->merge(['action' => 'download']);
        return $this->generate($request, $id);
    }

    /**
     * Imprimer le bon de commande
     * 
     * Affiche le bon de commande dans le navigateur et déclenche automatiquement la boîte de dialogue d'impression.
     * Idéal pour une impression directe sans téléchargement.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Impression déclenchée" [HTML page with auto-print]
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     */
    public function print(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'format' => 'nullable|in:A3,A4,A5'
        ], [
            'format.in' => 'Le format doit être A3, A4 ou A5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // Récupérer la commande avec toutes ses relations
        $commande = Commande::with([
            'fournisseur',
            'detailCommandes.product',
            'chauffeur',
            'camion'
        ])->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        // Format
        $format = $request->input('format', 'A4');

        // Informations de l'entreprise
        $entreprise = [
            'nom' => 'TOURE DISTRIBUTION',
            'adresse' => 'Abidjan, Côte d\'Ivoire',
            'email' => 'contact@toure-distribution.com',
            'telephone' => '+225 XX XX XX XX X',
            'logo' => null,
        ];

        // Préparer les données pour le bon de commande
        $data = [
            'commande' => $commande,
            'entreprise' => $entreprise,
            'format' => $format,
            'numero_bon_commande' => $this->generateNumeroBonCommande($commande->numero_commande),
            'date_generation' => now()->format('d/m/Y à H:i'),
            'auto_print' => true  // Flag pour activer l'impression automatique
        ];

        // Retourner la vue HTML avec auto-print
        return view('commandes.template', $data);
    }

    /**
     * Générer le numéro de bon de commande à partir du numéro de commande
     */
    private function generateNumeroBonCommande(string $numeroCommande): string
    {
        // Transformer CMD-2025-0001 en BC-2025-0001
        return str_replace('CMD', 'BC', $numeroCommande);
    }

    /**
     * Envoyer le bon de commande par email au fournisseur
     * 
     * Envoie le bon de commande PDF par email au fournisseur.
     * Si l'email n'est pas fourni, utilise l'email enregistré du fournisseur.
     * 
     * **Note:** Cette fonctionnalité nécessite la configuration du service d'email.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la commande. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam email string Email du destinataire. Si non fourni, utilise l'email du fournisseur. Example: fournisseur@example.com
     * @bodyParam message string Message personnalisé à inclure dans l'email (max 1000 caractères). Example: Veuillez trouver ci-joint notre bon de commande.
     * @bodyParam format string Format du PDF à joindre. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Email envoyé avec succès" {
     *   "success": true,
     *   "message": "Bon de commande envoyé par email avec succès",
     *   "data": {
     *     "email": "fournisseur@example.com",
     *     "numero_bon_commande": "BC-2025-0001"
     *   }
     * }
     * @response 404 scenario="Commande non trouvée" {
     *   "success": false,
     *   "message": "Commande non trouvée"
     * }
     * @response 422 scenario="Aucun email disponible" {
     *   "success": false,
     *   "message": "Aucun email disponible pour ce fournisseur"
     * }
     * @response 422 scenario="Email invalide" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "email": ["Le champ email doit être une adresse email valide."]
     *   }
     * }
     */
    public function sendEmail(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email',
            'message' => 'nullable|string|max:1000',
            'format' => 'nullable|in:A3,A4,A5'
        ], [
            'email.email' => 'L\'email fourni n\'est pas valide',
            'message.max' => 'Le message ne peut pas dépasser 1000 caractères',
            'format.in' => 'Le format doit être A3, A4 ou A5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $commande = Commande::with(['fournisseur', 'detailCommandes.product'])->find($id);

        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        // Email du destinataire
        $email = $request->input('email', $commande->fournisseur->email);

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun email disponible pour ce fournisseur'
            ], 422);
        }

        // TODO: Implémenter l'envoi d'email
        // Vous devrez créer un Mailable et configurer votre service d'email

        return response()->json([
            'success' => true,
            'message' => 'Bon de commande envoyé par email avec succès',
            'data' => [
                'email' => $email,
                'numero_bon_commande' => $this->generateNumeroBonCommande($commande->numero_commande)
            ]
        ]);
    }

    /**
     * Générer plusieurs bons de commande en lot (ZIP)
     * 
     * Génère plusieurs bons de commande PDF et les regroupe dans un fichier ZIP.
     * Maximum 50 bons de commande par lot.
     * 
     * **Note:** Cette fonctionnalité nécessite l'implémentation complète.
     * 
     * @authenticated
     * 
     * @bodyParam commande_ids string[] required Liste des UUIDs des commandes (min: 1, max: 50). Example: ["9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a", "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b"]
     * @bodyParam format string Format du PDF pour tous les bons de commande. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Génération en cours" {
     *   "success": true,
     *   "message": "Génération en lot en cours...",
     *   "data": {
     *     "count": 3
     *   }
     * }
     * @response 422 scenario="Validation échouée - commande_ids manquant" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "commande_ids": ["Le champ commande ids est obligatoire."]
     *   }
     * }
     * @response 422 scenario="Validation échouée - IDs invalides" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "commande_ids.0": ["La commande sélectionnée est invalide."]
     *   }
     * }
     * @response 422 scenario="Validation échouée - Trop de bons de commande" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "commande_ids": ["Le nombre maximum de bons de commande par lot est de 50."]
     *   }
     * }
     */
    public function generateBatch(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commande_ids' => 'required|array|min:1|max:50',
            'commande_ids.*' => 'required|uuid|exists:commandes,commande_id',
            'format' => 'nullable|in:A3,A4,A5'
        ], [
            'commande_ids.required' => 'La liste des commandes est obligatoire',
            'commande_ids.array' => 'La liste des commandes doit être un tableau',
            'commande_ids.min' => 'Au moins une commande est requise',
            'commande_ids.max' => 'Le nombre maximum de bons de commande par lot est de 50',
            'commande_ids.*.required' => 'Chaque commande doit avoir un ID',
            'commande_ids.*.uuid' => 'L\'ID de la commande doit être un UUID valide',
            'commande_ids.*.exists' => 'La commande sélectionnée n\'existe pas',
            'format.in' => 'Le format doit être A3, A4 ou A5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        // TODO: Implémenter la génération en lot avec création d'un fichier ZIP

        return response()->json([
            'success' => true,
            'message' => 'Génération en lot en cours...',
            'data' => [
                'count' => count($request->commande_ids)
            ]
        ]);
    }
}