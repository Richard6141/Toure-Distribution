<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe modifié</title>
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f9fa;
    }

    .container {
        background: white;
        border-radius: 8px;
        padding: 40px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        color: #16a34a;
        margin-bottom: 10px;
    }

    h1 {
        color: #1f2937;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .success-box {
        background-color: #dcfce7;
        border: 1px solid #16a34a;
        border-radius: 6px;
        padding: 16px;
        margin: 20px 0;
        text-align: center;
    }

    .info-box {
        background-color: #fef3c7;
        border: 1px solid #f59e0b;
        border-radius: 6px;
        padding: 16px;
        margin: 20px 0;
    }

    .details {
        background-color: #f3f4f6;
        border-radius: 6px;
        padding: 16px;
        margin: 20px 0;
        font-family: monospace;
        font-size: 14px;
    }

    .button {
        display: inline-block;
        background-color: #dc2626;
        color: white !important;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        margin: 10px 0;
        text-align: center;
    }

    .footer {
        margin-top: 40px;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
        border-top: 1px solid #e5e7eb;
        padding-top: 20px;
    }

    @media (max-width: 600px) {
        body {
            padding: 10px;
        }

        .container {
            padding: 20px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>

        <div class="success-box">
            <h1 style="color: #16a34a; margin: 0;">✅ Mot de passe modifié</h1>
        </div>

        <p>Bonjour {{ $user->firstname }},</p>

        <p>
            Votre mot de passe a été modifié avec succès pour le compte associé à l'adresse email
            <strong>{{ $user->email }}</strong>.
        </p>

        <div class="details">
            <strong>Détails de la modification :</strong><br>
            📅 Date : {{ $changeTime }}<br>
            🌐 Adresse IP : {{ $ipAddress }}
        </div>

        <div class="info-box">
            <strong>🔒 Mesures de sécurité appliquées :</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Toutes vos sessions actives ont été déconnectées</li>
                <li>Vous devrez vous reconnecter sur tous vos appareils</li>
                <li>Vos tentatives de connexion échouées ont été réinitialisées</li>
            </ul>
        </div>

        <p><strong>Si vous n'êtes pas à l'origine de cette modification :</strong></p>
        <ul>
            <li>Votre compte pourrait être compromis</li>
            <li>Contactez immédiatement notre support</li>
            <li>Changez votre mot de passe dès que possible</li>
        </ul>

        <div style="text-align: center; margin: 30px 0;">
            <a href="mailto:support@example.com" class="button">
                🚨 Signaler un problème
            </a>
        </div>

        <p>
            <strong>Conseils de sécurité :</strong><br>
            • Utilisez un mot de passe unique et complexe<br>
            • Activez l'authentification à deux facteurs si disponible<br>
            • Ne partagez jamais vos identifiants<br>
            • Déconnectez-vous des appareils publics
        </p>

        <div class="footer">
            <p>
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.<br>
                Si vous avez des questions, contactez notre support.
            </p>
            <p>
                © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
            </p>
        </div>
    </div>
</body>

</html>