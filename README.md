![MIT Licence](https://img.shields.io/badge/licence-GPL-green.svg)

# GFI Coffee - Backend
> GFI Coffee - Backend is a Rest API made with Symfony.  
> This API aims to make Nespresso Pro coffee capsules orders easier at GFI.

## Build Setup

``` bash
# install dependencies
composer install

# build MySQL database from entities
php bin/console doctrine:database:create
php bin/console doctrine:schema:create

# update database structure
php bin/console doctrine:schema:update --force

# Charger les fixtures
php bin/console doctrine:fixtures:load

# serve API at localhost:3000
php bin/console server:run
```

## Environnement de développement

Générer les clés

``` bash
openssl genrsa -out config/jwt/private.pem 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

## Backend

This repository only contains the backend part of the app.  
It's used by a SPA made with VueJS: [GFI Coffee](https://github.com/GFICoffee/GFICoffee).