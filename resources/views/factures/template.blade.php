<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $numero_facture }}</title>
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
            border-bottom: 3px solid #2563eb;
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
            color: #2563eb;
            margin-bottom: 4px;
        }

        .company-info {
            color: #666;
            @if($format==='A5') font-size: 7.5px;
            @elseif($format==='A3') font-size: 11px;
            @else font-size: 8.5px;
            @endif line-height: 1.45;
        }

        .invoice-title {
            @if($format==='A5') font-size: 17px;
            @elseif($format==='A3') font-size: 26px;
            @else font-size: 21px;
            @endif font-weight: bold;
            color: #2563eb;
            margin-bottom: 4px;
        }

        .invoice-number {
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
            color: #2563eb;
            margin-bottom: 6px;
            text-transform: uppercase;
            border-bottom: 2px solid #2563eb;
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
            background: linear-gradient(to right, #2563eb, #3b82f6, #60a5fa);
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
            background-color: #2563eb;
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

        /* Colonnes du tableau - Largeurs très précises pour éviter débordement */
        .products-table th:nth-child(1),
        .products-table td:nth-child(1) {
            width: 3%;
        }

        .products-table th:nth-child(2),
        .products-table td:nth-child(2) {
            @if($format==='A5') width: 32%;
            @else width: 35%;
            @endif
        }

        .products-table th:nth-child(3),
        .products-table td:nth-child(3) {
            width: 6%;
        }

        .products-table th:nth-child(4),
        .products-table td:nth-child(4) {
            width: 12%;
        }

        .products-table th:nth-child(5),
        .products-table td:nth-child(5) {
            width: 11%;
        }

        .products-table th:nth-child(6),
        .products-table td:nth-child(6) {
            width: 7%;
        }

        .products-table th:nth-child(7),
        .products-table td:nth-child(7) {
            width: 14%;
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
            background-color: #2563eb;
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

        /* Statut de paiement */
        .payment-status {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 12px;
            @if($format==='A5') font-size: 6.5px;
            @elseif($format==='A3') font-size: 10px;
            @else font-size: 7.5px;
            @endif font-weight: bold;
            text-transform: uppercase;
        }

        .status-non-paye {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-paye-partiellement {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-paye-totalement {
            background-color: #d1fae5;
            color: #065f46;
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
            @endif color: rgba(239, 68, 68, 0.1);
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
                <div class="invoice-title">FACTURE</div>
                <div class="invoice-number">N° {{ $numero_facture }}</div>
                <div class="company-info" style="margin-top: 6px;">
                    <div>Date: {{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</div>
                    <div>Générée le: {{ $date_generation }}</div>
                </div>
            </div>
        </div>

        <!-- Informations Client et Vente -->
        <div class="info-section clearfix">
            <div class="info-box">
                <div class="info-title">Informations Client</div>
                <div class="info-line">
                    <span class="info-label">Client:</span> {{ $vente->client->name_client }}
                </div>
                @if($vente->client->code)
                <div class="info-line">
                    <span class="info-label">Code:</span> {{ $vente->client->code }}
                </div>
                @endif
                @if($vente->client->name_representant)
                <div class="info-line">
                    <span class="info-label">Représentant:</span> {{ $vente->client->name_representant }}
                </div>
                @endif
                @if($vente->client->adresse)
                <div class="info-line">
                    <span class="info-label">Adresse:</span> {{ $vente->client->adresse }}
                </div>
                @endif
                @if($vente->client->city)
                <div class="info-line">
                    <span class="info-label">Ville:</span> {{ $vente->client->city }}
                </div>
                @endif
                @if($vente->client->phonenumber)
                <div class="info-line">
                    <span class="info-label">Téléphone:</span> {{ $vente->client->phonenumber }}
                </div>
                @endif
                @if($vente->client->email)
                <div class="info-line">
                    <span class="info-label">Email:</span> {{ $vente->client->email }}
                </div>
                @endif
                @if($vente->client->ifu)
                <div class="info-line">
                    <span class="info-label">IFU:</span> {{ $vente->client->ifu }}
                </div>
                @endif
            </div>

            <div class="info-box">
                <div class="info-title">Détails de la Vente</div>
                <div class="info-line">
                    <span class="info-label">N° Vente:</span> {{ $vente->numero_vente }}
                </div>
                <div class="info-line">
                    <span class="info-label">Date:</span>
                    {{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y à H:i') }}
                </div>
                @if($vente->entrepot)
                <div class="info-line">
                    <span class="info-label">Entrepôt:</span> {{ $vente->entrepot->name }}
                </div>
                @endif
                <div class="info-line">
                    <span class="info-label">Statut:</span>
                    <strong>{{ ucfirst(str_replace('_', ' ', $vente->status)) }}</strong>
                </div>
                <div class="info-line">
                    <span class="info-label">Paiement:</span>
                    <span class="payment-status status-{{ str_replace('_', '-', $vente->statut_paiement) }}">
                        {{ ucfirst(str_replace('_', ' ', $vente->statut_paiement)) }}
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
                    <th class="text-center">Qté</th>
                    <th class="text-right">P.U. HT</th>
                    <th class="text-right">Remise</th>
                    <th class="text-center">TVA %</th>
                    <th class="text-right">Total TTC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vente->detailVentes as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-center">{{ number_format($detail->quantite, 0, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format($detail->prix_unitaire, 0, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format($detail->remise_ligne, 0, ',', ' ') }}</td>
                    <td class="text-center">{{ number_format($detail->taux_taxe, 1, ',', '') }}%</td>
                    <td class="text-right">{{ number_format($detail->montant_ttc, 0, ',', ' ') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Section des totaux -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="label">Total HT:</td>
                    <td class="amount">{{ number_format($vente->montant_ht, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td class="label">Total TVA:</td>
                    <td class="amount">{{ number_format($vente->montant_taxe, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr>
                    <td class="label">Montant Total:</td>
                    <td class="amount">{{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
                @if($vente->remise > 0)
                <tr>
                    <td class="label">Remise:</td>
                    <td class="amount">- {{ number_format($vente->remise, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                @if($vente->transport_price > 0)
                <tr>
                    <td class="label">Frais de transport:</td>
                    <td class="amount">+ {{ number_format($vente->transport_price, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                <tr class="total-final">
                    <td class="label" style="color: white;">
                        NET À PAYER:
                    </td>
                    <td class="amount">{{ number_format($vente->montant_net, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
        </div>

        <!-- Notes -->
        @if($vente->note)
        <div class="notes-section">
            <div class="notes-title">📝 Notes:</div>
            <div class="notes-content">{{ $vente->note }}</div>
        </div>
        @endif

        <!-- Pied de page -->
        <div class="footer">
            <div class="footer-line">{{ $entreprise['nom'] }} - {{ $entreprise['adresse'] }}</div>
            <div class="footer-line">Email: {{ $entreprise['email'] }} | Tél: {{ $entreprise['telephone'] }}</div>
            <div class="footer-line" style="margin-top: 6px; font-style: italic;">
                Merci pour votre confiance !
            </div>
        </div>

        <!-- Filigrane si non payé -->
        @if($vente->statut_paiement === 'non_paye')
        <div class="watermark">IMPAYÉ</div>
        @endif
    </div>
</body>

</html>