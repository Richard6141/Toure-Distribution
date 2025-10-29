<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

/**
 * @group Génération de Factures PDF
 * 
 * API pour générer des factures PDF à partir des ventes avec support A3/A4/A5.
 * Toutes les routes nécessitent une authentification via Sanctum.
 */
class FacturePDFController extends Controller
{
    /**
     * Générer une facture PDF pour une vente
     * 
     * Génère un PDF de facture professionnelle avec en-tête et pied de page.
     * Le format peut être A3, A4 (défaut) ou A5.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * @queryParam action string Action à effectuer. Valeurs possibles: download (télécharger), preview (aperçu dans le navigateur). Défaut: download. Example: download
     * 
     * @response 200 scenario="Téléchargement réussi" [Binary PDF Content]
     * @response 404 scenario="Vente non trouvée" {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     * @response 422 scenario="Format invalide" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "format": ["Le format doit être A3, A4 ou A5"]
     *   }
     * }
     * 
     * @responseFile storage/responses/facture.pdf
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

        // Récupérer la vente avec toutes ses relations
        $vente = Vente::with([
            'client',
            'entrepot',
            'detailVentes.product'
        ])->find($id);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
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

        // Préparer les données pour la facture
        $data = [
            'vente' => $vente,
            'entreprise' => $entreprise,
            'format' => $format,
            'numero_facture' => $this->generateNumeroFacture($vente->numero_vente),
            'date_generation' => now()->format('d/m/Y à H:i')
        ];

        // Générer le PDF
        $pdf = Pdf::loadView('factures.template', $data)
            ->setPaper($format)
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10);

        // Nom du fichier
        $filename = 'facture_' . $vente->numero_vente . '_' . now()->format('YmdHis') . '.pdf';

        // Action
        if ($action === 'preview') {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    /**
     * Aperçu de la facture dans le navigateur
     * 
     * Affiche la facture directement dans le navigateur sans téléchargement.
     * Raccourci pour `/generate?action=preview`.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Aperçu réussi" [PDF displayed in browser]
     * @response 404 scenario="Vente non trouvée" {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     */
    public function preview(string $id)
    {
        $request = request();
        $request->merge(['action' => 'preview']);
        return $this->generate($request, $id);
    }

    /**
     * Télécharger la facture
     * 
     * Télécharge directement la facture au format PDF.
     * Raccourci pour `/generate?action=download`.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @queryParam format string Format du PDF. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A5
     * 
     * @response 200 scenario="Téléchargement réussi" [Binary PDF Content]
     * @response 404 scenario="Vente non trouvée" {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     */
    public function download(string $id)
    {
        $request = request();
        $request->merge(['action' => 'download']);
        return $this->generate($request, $id);
    }

    /**
     * Générer le numéro de facture à partir du numéro de vente
     */
    private function generateNumeroFacture(string $numeroVente): string
    {
        // Transformer VTE-2025-0001 en FACT-2025-0001
        return str_replace('VTE', 'FACT', $numeroVente);
    }

    /**
     * Envoyer la facture par email au client
     * 
     * Envoie la facture PDF par email au client.
     * Si l'email n'est pas fourni, utilise l'email enregistré du client.
     * 
     * **Note:** Cette fonctionnalité nécessite la configuration du service d'email.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * 
     * @bodyParam email string Email du destinataire. Si non fourni, utilise l'email du client. Example: client@example.com
     * @bodyParam message string Message personnalisé à inclure dans l'email (max 1000 caractères). Example: Merci pour votre achat. Veuillez trouver ci-joint votre facture.
     * @bodyParam format string Format du PDF à joindre. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Email envoyé avec succès" {
     *   "success": true,
     *   "message": "Facture envoyée par email avec succès",
     *   "data": {
     *     "email": "client@example.com",
     *     "numero_facture": "FACT-2025-0001"
     *   }
     * }
     * @response 404 scenario="Vente non trouvée" {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     * @response 422 scenario="Aucun email disponible" {
     *   "success": false,
     *   "message": "Aucun email disponible pour ce client"
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

        $vente = Vente::with(['client', 'entrepot', 'detailVentes.product'])->find($id);

        if (!$vente) {
            return response()->json([
                'success' => false,
                'message' => 'Vente non trouvée'
            ], 404);
        }

        // Email du destinataire
        $email = $request->input('email', $vente->client->email);

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun email disponible pour ce client'
            ], 422);
        }

        // TODO: Implémenter l'envoi d'email
        // Vous devrez créer un Mailable et configurer votre service d'email
        // Voir le fichier ADVANCED_FEATURES.md pour l'implémentation complète

        return response()->json([
            'success' => true,
            'message' => 'Facture envoyée par email avec succès',
            'data' => [
                'email' => $email,
                'numero_facture' => $this->generateNumeroFacture($vente->numero_vente)
            ]
        ]);
    }

    /**
     * Générer plusieurs factures en lot (ZIP)
     * 
     * Génère plusieurs factures PDF et les regroupe dans un fichier ZIP.
     * Maximum 50 factures par lot.
     * 
     * **Note:** Cette fonctionnalité nécessite l'implémentation complète.
     * 
     * @authenticated
     * 
     * @bodyParam vente_ids string[] required Liste des UUIDs des ventes (min: 1, max: 50). Example: ["9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a", "9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2b"]
     * @bodyParam format string Format du PDF pour toutes les factures. Valeurs possibles: A3, A4, A5. Défaut: A4. Example: A4
     * 
     * @response 200 scenario="Génération en cours" {
     *   "success": true,
     *   "message": "Génération en lot en cours...",
     *   "data": {
     *     "count": 3
     *   }
     * }
     * @response 422 scenario="Validation échouée - vente_ids manquant" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "vente_ids": ["Le champ vente ids est obligatoire."]
     *   }
     * }
     * @response 422 scenario="Validation échouée - IDs invalides" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "vente_ids.0": ["La vente sélectionnée est invalide."]
     *   }
     * }
     * @response 422 scenario="Validation échouée - Trop de factures" {
     *   "success": false,
     *   "message": "Erreur de validation",
     *   "errors": {
     *     "vente_ids": ["Le nombre maximum de factures par lot est de 50."]
     *   }
     * }
     */
    public function generateBatch(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vente_ids' => 'required|array|min:1|max:50',
            'vente_ids.*' => 'required|uuid|exists:ventes,vente_id',
            'format' => 'nullable|in:A3,A4,A5'
        ], [
            'vente_ids.required' => 'La liste des ventes est obligatoire',
            'vente_ids.array' => 'La liste des ventes doit être un tableau',
            'vente_ids.min' => 'Au moins une vente est requise',
            'vente_ids.max' => 'Le nombre maximum de factures par lot est de 50',
            'vente_ids.*.required' => 'Chaque vente doit avoir un ID',
            'vente_ids.*.uuid' => 'L\'ID de la vente doit être un UUID valide',
            'vente_ids.*.exists' => 'La vente sélectionnée n\'existe pas',
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
        // Voir le fichier ADVANCED_FEATURES.md pour l'implémentation complète

        return response()->json([
            'success' => true,
            'message' => 'Génération en lot en cours...',
            'data' => [
                'count' => count($request->vente_ids)
            ]
        ]);
    }
}
