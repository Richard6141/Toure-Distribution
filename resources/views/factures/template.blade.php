<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $numero_facture }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;

            font-size: {
                    {
                    $format==='A5' ? '10px': '11px'
                }
            }

            ;
            color: #333;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        /* En-tête */
        .header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .header-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .company-name {
            font-size: {
                    {
                    $format==='A5' ? '18px': '22px'
                }
            }

            ;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .company-info {
            color: #666;

            font-size: {
                    {
                    $format==='A5' ? '9px': '10px'
                }
            }

            ;
            line-height: 1.6;
        }

        .invoice-title {
            font-size: {
                    {
                    $format==='A5' ? '20px': '24px'
                }
            }

            ;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: {
                    {
                    $format==='A5' ? '11px': '12px'
                }
            }

            ;
            color: #666;
            font-weight: bold;
        }

        /* Section informations */
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .info-box {
            display: table-cell;
            width: 48%;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            background-color: #f9fafb;
        }

        .info-box:first-child {
            margin-right: 4%;
        }

        .info-title {
            font-size: {
                    {
                    $format==='A5' ? '11px': '12px'
                }
            }

            ;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 5px;
        }

        .info-line {
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        /* Tableau des produits */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .products-table thead {
            background-color: #2563eb;
            color: white;
        }

        .products-table th {
            padding: 10px 8px;
            text-align: left;

            font-size: {
                    {
                    $format==='A5' ? '9px': '10px'
                }
            }

            ;
            font-weight: bold;
            text-transform: uppercase;
        }

        .products-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;

            font-size: {
                    {
                    $format==='A5' ? '9px': '10px'
                }
            }

            ;
        }

        .products-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .products-table tbody tr:hover {
            background-color: #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Totaux */
        .totals-section {
            float: right;

            width: {
                    {
                    $format==='A5' ? '55%': '45%'
                }
            }

            ;
            margin-top: 20px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-table .label {
            font-weight: bold;
            color: #666;
            text-align: right;
        }

        .totals-table .amount {
            text-align: right;
            font-weight: bold;
        }

        .totals-table tr.total-final {
            background-color: #2563eb;
            color: white;

            font-size: {
                    {
                    $format==='A5' ? '12px': '14px'
                }
            }

            ;
        }

        .totals-table tr.total-final td {
            padding: 12px;
            border: none;
        }

        /* Notes */
        .notes-section {
            clear: both;
            margin-top: 30px;
            padding: 15px;
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 5px;
        }

        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 5px;
        }

        .notes-content {
            color: #78350f;

            font-size: {
                    {
                    $format==='A5' ? '9px': '10px'
                }
            }

            ;
        }

        /* Statut de paiement */
        .payment-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;

            font-size: {
                    {
                    $format==='A5' ? '8px': '9px'
                }
            }

            ;
            font-weight: bold;
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
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;

            font-size: {
                    {
                    $format==='A5' ? '8px': '9px'
                }
            }

            ;
            color: #666;
        }

        .footer-line {
            margin-bottom: 3px;
        }

        /* Filigrane pour statut */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(239, 68, 68, 0.1);
            font-weight: bold;
            z-index: -1;
            text-transform: uppercase;
        }

        /* Séparateur */
        .separator {
            height: 2px;
            background: linear-gradient(to right, #2563eb, #3b82f6, #60a5fa);
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <div class="header-content">
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
                    <div class="company-info" style="margin-top: 10px;">
                        <div>Date: {{ \Carbon\Carbon::parse($vente->date_vente)->format('d/m/Y') }}</div>
                        <div>Générée le: {{ $date_generation }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations Client et Vente -->
        <div class="info-section">
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
                    <th style="width: 5%;">#</th>
                    <th style="width: 12%;">Code</th>
                    <th style="width: 30%;">Désignation</th>
                    <th style="width: 8%;" class="text-center">Qté</th>
                    <th style="width: 12%;" class="text-right">P.U. HT</th>
                    <th style="width: 10%;" class="text-right">Remise</th>
                    <th style="width: 8%;" class="text-center">TVA %</th>
                    <th style="width: 15%;" class="text-right">Total TTC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vente->detailVentes as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detail->product->code }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-center">{{ number_format($detail->quantite, 0, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format($detail->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($detail->remise_ligne, 0, ',', ' ') }} FCFA</td>
                    <td class="text-center">{{ number_format($detail->taux_taxe, 2, ',', ' ') }}%</td>
                    <td class="text-right">{{ number_format($detail->montant_total, 0, ',', ' ') }} FCFA</td>
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
                    <td class="label">NET À PAYER:</td>
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
            <div class="footer-line" style="margin-top: 10px; font-style: italic;">
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