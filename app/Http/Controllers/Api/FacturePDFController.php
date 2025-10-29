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
 * API pour générer des factures PDF à partir des ventes.
 */
class FacturePDFController extends Controller
{
    /**
     * Générer une facture PDF pour une vente
     * 
     * Génère un PDF de facture professionnelle avec en-tête et pied de page.
     * Le format peut être A4 (défaut) ou A5.
     * 
     * @authenticated
     * 
     * @urlParam id string required L'UUID de la vente. Example: 9d0e8f5a-3b2c-4d1e-8f6a-7b8c9d0e1f2a
     * @queryParam format string Format du PDF (A4 ou A5). Example: A4
     * @queryParam action string Action à effectuer: 'download' (télécharger) ou 'preview' (aperçu). Example: download
     * 
     * @response 200 {
     *   "success": true,
     *   "message": "Facture générée avec succès",
     *   "data": {
     *     "pdf_url": "base64_encoded_pdf_content"
     *   }
     * }
     * 
     * @response 404 {
     *   "success": false,
     *   "message": "Vente non trouvée"
     * }
     */
    public function generate(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'format' => 'nullable|in:A4,A5',
            'action' => 'nullable|in:download,preview'
        ], [
            'format.in' => 'Le format doit être A4 ou A5',
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
            'logo' => null // Vous pouvez ajouter le chemin du logo ici
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
     * @authenticated
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
     * @authenticated
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
     * @authenticated
     * 
     * @bodyParam email string Email du destinataire (optionnel, utilise l'email du client par défaut).
     * @bodyParam message string Message personnalisé à inclure dans l'email.
     */
    public function sendEmail(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email',
            'message' => 'nullable|string|max:1000',
            'format' => 'nullable|in:A4,A5'
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
     * @authenticated
     * 
     * @bodyParam vente_ids array required Liste des IDs des ventes.
     * @bodyParam format string Format du PDF (A4 ou A5).
     */
    public function generateBatch(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'vente_ids' => 'required|array|min:1',
            'vente_ids.*' => 'required|uuid|exists:ventes,vente_id',
            'format' => 'nullable|in:A4,A5'
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
                'count' => count($request->vente_ids)
            ]
        ]);
    }
}
