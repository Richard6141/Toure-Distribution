# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer Bearer {YOUR_AUTH_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Vous pouvez récupérer votre token en vous inscrivant via <code>POST /api/auth/register</code> ou en vous connectant via <code>POST /api/auth/login</code>. Utilisez le token dans le header Authorization avec le préfixe "Bearer ".
