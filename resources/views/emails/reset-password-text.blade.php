RÉINITIALISATION DE MOT DE PASSE
{{ config('app.name') }}

Bonjour {{ $user->firstname }},

Vous avez demandé la réinitialisation de votre mot de passe pour votre compte associé à l'adresse email
{{ $user->email }}.

Pour créer un nouveau mot de passe, cliquez sur le lien ci-dessous ou copiez-le dans votre navigateur :

{{ $resetUrl }}

IMPORTANT :
- Ce lien est valable pendant {{ $expireMinutes }} minutes
- Si vous n'avez pas demandé cette réinitialisation, ignorez cet email
- Pour votre sécurité, ne partagez jamais ce lien

Si vous avez des questions, contactez notre support.

---
Cet email a été envoyé automatiquement, merci de ne pas y répondre.
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.