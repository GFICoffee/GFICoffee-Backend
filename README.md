# GFI Coffee - Backend

## Environnement de développement

Générer les clés

```
openssl genrsa -out config/jwt/private.pem 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```