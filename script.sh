#!/bin/bash

composer config allow-plugins.symfony true
composer config allow-plugins.symfony/flex true
composer config allow-plugins.symfony/runtime true
composer config allow-plugins.phpstan/extension-installer false
composer config allow-plugins.bamarni/composer-bin-plugin true
composer config repositories.krme-code-quality-meta git https://github.com/KruseMedienGmbH/krme-code-quality-meta.git

# Installiert Symfony Flex in Version 2
composer require symfony/flex "~2" --no-scripts --no-plugins

# Konfiguriert den Symfony Flex-Repository-Endpunkt
composer config extra.symfony.endpoint https://raw.githubusercontent.com/KruseMedienGmbH/krme-recipes/flex/main/index.json

composer config extra.symfony.allow-contrib false

# Installiert das Paket "krme/code-quality-meta"
composer require krme/code-quality-meta:dev-main --no-scripts --no-plugins

# Aktualisiert die Symfony Flex-Rezepte
composer recipes:install krme/code-quality-meta --force



