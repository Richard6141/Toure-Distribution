<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
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
        color: #2563eb;
        margin-bottom: 10px;
    }

    h1 {
        color: #1f2937;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .button {
        display: inline-block;
        background-color: #2563eb;
        color: white !important;
        padding: 14px 28px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        margin: 20px 0;
        text-align: center;
    }

    .button:hover {
        background-color: #1d4ed8;
    }

    .info-box {
        background-color: #fef3c7;
        border: 1px solid #f59e0b;
        border-radius: 6px;
        padding: 16px;
        margin: 20px 0;
    }

    .footer {
        margin-top: 40px;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
        border-top: 1px solid #e5e7eb;
        padding-top: 20px;
    }

    .manual-link {
        word-break: break-all;
        background-color: #f3f4f6;
        padding: 10px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 12px;
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

        <h1>Réinitialisation de mot de passe</h1>

        <p>Bonjour {{ $user->firstname }},</p>

        <p>
            Vous avez demandé la réinitialisation de votre mot de passe pour votre compte associé à l'adresse email
            <strong>{{ $user->email }}</strong>.
        </p>

        <p>Pour créer un nouveau mot de passe, cliquez sur le bouton ci-dessous :</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" class="button">
                Réinitialiser mon mot de passe
            </a>
        </div>

        <div class="info-box">
            <strong>⚠️ Important :</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Ce lien est valable pendant <strong>{{ $expireMinutes }} minutes</strong></li>
                <li>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email</li>
                <li>Pour votre sécurité, ne partagez jamais ce lien</li>
            </ul>
        </div>

        <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller le lien suivant dans votre navigateur :</p>
        <div class="manual-link">{{ $resetUrl }}</div>

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