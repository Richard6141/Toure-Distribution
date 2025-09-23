MOT DE PASSE MODIFIÉ
{{ config('app.name') }}

Bonjour {{ $user->firstname }},

Votre mot de passe a été modifié avec succès pour le compte associé à l'adresse email {{ $user->email }}.

DÉTAILS DE LA MODIFICATION :
- Date : {{ $changeTime }}
- Adresse IP : {{ $ipAddress }}

MESURES DE SÉCURITÉ APPLIQUÉES :
- Toutes vos sessions actives ont été déconnectées
- Vous devrez vous reconnecter sur tous vos appareils
- Vos tentatives de connexion échouées ont été réinitialisées

SI VOUS N'ÊTES PAS À L'ORIGINE DE CETTE MODIFICATION :
- Votre compte pourrait être compromis
- Contactez immédiatement notre support : support@example.com
- Changez votre mot de passe dès que possible

CONSEILS DE SÉCURITÉ :
• Utilisez un mot de passe unique et complexe
• Activez l'authentification à deux facteurs si disponible
• Ne partagez jamais vos identifiants
• Déconnectez-vous des appareils publics

---
Cet email a été envoyé automatiquement, merci de ne pas y répondre.
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.