@component('mail::message')
# Bienvenue {{ $user->firstname }} !

Votre compte a été créé avec succès sur notre plateforme de gestion d'entreprise.

**Vos informations de connexion :**
- **Email :** {{ $user->email }}
- **Nom d'utilisateur :** {{ $user->username }}

@component('mail::button', ['url' => config('app.frontend_url')])
Accéder à la plateforme
@endcomponent

Si vous avez des questions, n'hésitez pas à nous contacter.

Cordialement,<br>
{{ config('app.name') }}
@endcomponent