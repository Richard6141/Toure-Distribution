<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande {{ $numero_bon_commande }}</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }

        * {
            margin: 5px;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            @if($format==='A5') font-size: 8.5px;
            @elseif($format==='A3') font-size: 12px;
            @else font-size: 9.5px;
            @endif color: #333;
            line-height: 1.35;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 5px auto;
            padding: 5px;
        }

        /* En-tête */
        .header {
            border-bottom: 3px solid #16a34a;
            padding-bottom: 10px;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .header-left {
            float: left;
            width: 46%;
        }

        .header-right {
            float: right;
            width: 46%;
            text-align: right;
        }

        .company-name {
            @if($format==='A5') font-size: 15px;
            @elseif($format==='A3') font-size: 24px;
            @else font-size: 19px;
            @endif font-weight: bold;
            color: #16a34a;
            margin-bottom: 4px;
        }

        .company-info {
            color: #666;
            @if($format==='A5') font-size: 7.5px;
            @elseif($format==='A3') font-size: 11px;
            @else font-size: 8.5px;
            @endif line-height: 1.45;
        }

        .order-title {
            @if($format==='A5') font-size: 17px;
            @elseif($format==='A3') font-size: 26px;
            @else font-size: 21px;
            @endif font-weight: bold;
            color: #16a34a;
            margin-bottom: 4px;
        }

        .order-number {
            @if($format==='A5') font-size: 9.5px;
            @elseif($format==='A3') font-size: 13px;
            @else font-size: 10.5px;
            @endif color: #666;
            font-weight: bold;
        }

        /* Section informations */
        .info-section {
            margin-bottom: 15px;
            overflow: hidden;
        }

        .info-box {
            float: left;
            width: 46%;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 3px;
            background-color: #f9fafb;
        }

        .info-box:first-child {
            margin-right: 8%;
        }

        .info-title {
            @if($format==='A5') font-size: 9.5px;
            @elseif($format==='A3') font-size: 13px;
            @else font-size: 10.5px;
            @endif font-weight: bold;
            color: #16a34a;
            margin-bottom: 6px;
            text-transform: uppercase;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 3px;
        }

        .info-line {
            margin-bottom: 3px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        /* Séparateur */
        .separator {
            height: 2px;
            background: linear-gradient(to right, #16a34a, #22c55e, #4ade80);
            margin: 12px 0;
            clear: both;
        }

        /* Tableau des produits */
        .products-table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            table-layout: fixed;
        }

        .products-table thead {
            background-color: #16a34a;
            color: white;
        }

        .products-table th {
            padding: 5px 5px;
            text-align: left;
            @if($format==='A5') font-size: 7.5px;
            @elseif($format==='A3') font-size: 11px;
            @else font-size: 8.5px;
            @endif font-weight: bold;
            text-transform: uppercase;
        }

        .products-table td {
            padding: 5px 5px;
            border-bottom: 1px solid #e5e7eb;
            @if($format==='A5') font-size: 7.5px;
            @elseif($format==='A3') font-size: 11px;
            @else font-size: 8.5px;
            @endif word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .products-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Colonnes du tableau */
        .products-table th:nth-child(1),
        .products-table td:nth-child(1) {
            width: 5%;
        }

        .products-table th:nth-child(2),
        .products-table td:nth-child(2) {
            @if($format==='A5') width: 45%;
            @else width: 50%;
            @endif
        }

        .products-table th:nth-child(3),
        .products-table td:nth-child(3) {
            width: 15%;
        }

        .products-table th:nth-child(4),
        .products-table td:nth-child(4) {
            width: 15%;
        }

        .products-table th:nth-child(5),
        .products-table td:nth-child(5) {
            width: 15%;
        }

        /* Totaux */
        .totals-section {
            float: right;
            @if($format==='A5') width: 62%;
            @elseif($format==='A3') width: 42%;
            @else width: 50%;
            @endif margin-top: 12px;
            margin-bottom: 15px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px 6px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-table .label {
            font-weight: bold;
            color: #666;
            text-align: right;
            width: 50%;
        }

        .totals-table .amount {
            text-align: right;
            font-weight: bold;
            width: 50%;
            word-wrap: break-word;
        }

        .totals-table tr.total-final {
            background-color: #16a34a;
            color: white;
            @if($format==='A5') font-size: 10.5px;
            @elseif($format==='A3') font-size: 15px;
            @else font-size: 12.5px;
            @endif
        }

        .totals-table tr.total-final td {
            padding: 8px 12px;
            border: none;
        }

        /* Notes */
        .notes-section {
            clear: both;
            margin-top: 15px;
            margin-bottom: 15px;
            padding: 8px;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 3px;
        }

        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 4px;
        }

        .notes-content {
            color: #78350f;
            @if($format==='A5') font-size: 7.5px;
            @elseif($format==='A3') font-size: 11px;
            @else font-size: 8.5px;
            @endif word-wrap: break-word;
        }

        /* Statut */
        .status-badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 12px;
            @if($format==='A5') font-size: 6.5px;
            @elseif($format==='A3') font-size: 10px;
            @else font-size: 7.5px;
            @endif font-weight: bold;
            text-transform: uppercase;
        }

        .status-en-attente {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-validee {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-en-cours {
            background-color: #e0e7ff;
            color: #4338ca;
        }

        .status-livree {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-partiellement-livree {
            background-color: #fed7aa;
            color: #92400e;
        }

        .status-annulee {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Informations livraison */
        .delivery-section {
            clear: both;
            margin-top: 15px;
            margin-bottom: 15px;
            padding: 8px;
            background-color: #dbeafe;
            border-left: 4px solid #2563eb;
            border-radius: 3px;
        }

        .delivery-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 4px;
        }

        .delivery-content {
            color: #1e3a8a;
            @if($format==='A5') font-size: 7.5px;
            @elseif($format==='A3') font-size: 11px;
            @else font-size: 8.5px;
            @endif
        }

        /* Pied de page */
        .footer {
            clear: both;
            margin-top: 25px;
            padding-top: 12px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            @if($format==='A5') font-size: 6.5px;
            @elseif($format==='A3') font-size: 10px;
            @else font-size: 7.5px;
            @endif color: #666;
        }

        .footer-line {
            margin-bottom: 2px;
        }

        /* Filigrane pour statut */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            @if($format==='A5') font-size: 60px;
            @elseif($format==='A3') font-size: 100px;
            @else font-size: 80px;
            @endif color: rgba(220, 38, 38, 0.1);
            font-weight: bold;
            z-index: -1;
            text-transform: uppercase;
        }

        /* Clearfix pour éviter les débordements */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>

    @if(isset($auto_print) && $auto_print)
    <script type="text/javascript">
        // Déclencher l'impression automatiquement au chargement de la page
        window.onload = function() {
            window.print();
        };
    </script>
    @endif
</head>

<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header clearfix">
            <div class="header-left">
                <div class="company-name">{{ $entreprise['nom'] }}</div>
                <div class="company-info">
                    <div>{{ $entreprise['adresse'] }}</div>
                    <div>Email: {{ $entreprise['email'] }}</div>
                    <div>Tél: {{ $entreprise['telephone'] }}</div>
                </div>
            </div>
            <div class="header-right">
                <div class="order-title">BON DE COMMANDE</div>
                <div class="order-number">N° {{ $numero_bon_commande }}</div>
                <div class="company-info" style="margin-top: 6px;">
                    <div>Date: {{ \Carbon\Carbon::parse($commande->date_achat)->format('d/m/Y') }}</div>
                    <div>Générée le: {{ $date_generation }}</div>
                </div>
            </div>
        </div>

        <!-- Informations Fournisseur et Commande -->
        <div class="info-section clearfix">
            <div class="info-box">
                <div class="info-title">Informations Fournisseur</div>
                <div class="info-line">
                    <span class="info-label">Fournisseur:</span> {{ $commande->fournisseur->name }}
                </div>
                @if($commande->fournisseur->code)
                <div class="info-line">
                    <span class="info-label">Code:</span> {{ $commande->fournisseur->code }}
                </div>
                @endif
                @if($commande->fournisseur->responsable)
                <div class="info-line">
                    <span class="info-label">Responsable:</span> {{ $commande->fournisseur->responsable }}
                </div>
                @endif
                @if($commande->fournisseur->adresse)
                <div class="info-line">
                    <span class="info-label">Adresse:</span> {{ $commande->fournisseur->adresse }}
                </div>
                @endif
                @if($commande->fournisseur->city)
                <div class="info-line">
                    <span class="info-label">Ville:</span> {{ $commande->fournisseur->city }}
                </div>
                @endif
                @if($commande->fournisseur->phone)
                <div class="info-line">
                    <span class="info-label">Téléphone:</span> {{ $commande->fournisseur->phone }}
                </div>
                @endif
                @if($commande->fournisseur->email)
                <div class="info-line">
                    <span class="info-label">Email:</span> {{ $commande->fournisseur->email }}
                </div>
                @endif
                @if($commande->fournisseur->payment_terms)
                <div class="info-line">
                    <span class="info-label">Conditions:</span> {{ $commande->fournisseur->payment_terms }}
                </div>
                @endif
            </div>

            <div class="info-box">
                <div class="info-title">Détails de la Commande</div>
                <div class="info-line">
                    <span class="info-label">N° Commande:</span> {{ $commande->numero_commande }}
                </div>
                <div class="info-line">
                    <span class="info-label">Date d'achat:</span>
                    {{ \Carbon\Carbon::parse($commande->date_achat)->format('d/m/Y') }}
                </div>
                <div class="info-line">
                    <span class="info-label">Livraison prévue:</span>
                    {{ \Carbon\Carbon::parse($commande->date_livraison_prevue)->format('d/m/Y') }}
                </div>
                @if($commande->date_livraison_effective)
                <div class="info-line">
                    <span class="info-label">Livraison effective:</span>
                    {{ \Carbon\Carbon::parse($commande->date_livraison_effective)->format('d/m/Y') }}
                </div>
                @endif
                <div class="info-line">
                    <span class="info-label">Statut:</span>
                    <span class="status-badge status-{{ str_replace('_', '-', $commande->status) }}">
                        {{ ucfirst(str_replace('_', ' ', $commande->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="separator"></div>

        <!-- Tableau des produits -->
        <table class="products-table">
            <thead>
                <tr>
                    <th style="text-align: center;">#</th>
                    <th>Désignation</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-right">Prix Unitaire</th>
                    <th class="text-right">Sous-Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->detailCommandes as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-center">{{ number_format($detail->quantite, 0, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format($detail->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($detail->sous_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Section des totaux -->
        <div class="totals-section">
            <table class="totals-table">
                <tr class="total-final">
                    <td class="label" style="color: white;">
                        MONTANT TOTAL:
                    </td>
                    <td class="amount">{{ number_format($commande->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
        </div>

        <!-- Informations de livraison (chauffeur et camion) -->
        @if($commande->chauffeur || $commande->camion)
        <div class="delivery-section">
            <div class="delivery-title">🚚 Informations de Livraison</div>
            <div class="delivery-content">
                @if($commande->chauffeur)
                <div style="margin-bottom: 3px;">
                    <strong>Chauffeur:</strong> {{ $commande->chauffeur->nom }} {{ $commande->chauffeur->prenom }}
                    @if($commande->chauffeur->telephone)
                    - Tél: {{ $commande->chauffeur->telephone }}
                    @endif
                </div>
                @endif
                @if($commande->camion)
                <div>
                    <strong>Camion:</strong> {{ $commande->camion->marque }} {{ $commande->camion->modele }}
                    - Immat: {{ $commande->camion->immatriculation }}
                    @if($commande->camion->capacite_charge)
                    (Capacité: {{ number_format($commande->camion->capacite_charge, 0, ',', ' ') }} kg)
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($commande->note)
        <div class="notes-section">
            <div class="notes-title">📝 Notes:</div>
            <div class="notes-content">{{ $commande->note }}</div>
        </div>
        @endif

        <!-- Pied de page -->
        <div class="footer">
            <div class="footer-line">{{ $entreprise['nom'] }} - {{ $entreprise['adresse'] }}</div>
            <div class="footer-line">Email: {{ $entreprise['email'] }} | Tél: {{ $entreprise['telephone'] }}</div>
            <div class="footer-line" style="margin-top: 6px; font-style: italic;">
                Ce bon de commande doit être confirmé par le fournisseur
            </div>
        </div>

        <!-- Filigrane si annulé -->
        @if($commande->status === 'annulee')
        <div class="watermark">ANNULÉ</div>
        @endif
    </div>
</body>

</html>