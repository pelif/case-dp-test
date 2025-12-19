#!/bin/bash

set -e

echo "=========================================="
echo "Instalando Laravel Breeze com Bootstrap"
echo "=========================================="

cd /var/www/html

# Instalar Breeze com stack Blade
echo "Instalando Breeze..."
php artisan breeze:install blade --no-interaction

# Remover Tailwind CSS
echo "Removendo Tailwind CSS..."
npm uninstall tailwindcss postcss autoprefixer @tailwindcss/forms

# Instalar Bootstrap e dependências
echo "Instalando Bootstrap..."
npm install bootstrap @popperjs/core sass --save

# Remover arquivos de configuração do Tailwind
echo "Removendo arquivos de configuração do Tailwind..."
rm -f tailwind.config.js
rm -f postcss.config.js

# Instalar dependências do NPM
echo "Instalando dependências NPM..."
npm install

# Compilar assets
echo "Compilando assets..."
npm run build

# Ajustar permissões
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

echo "=========================================="
echo "Laravel Breeze com Bootstrap instalado!"
echo "=========================================="
echo ""
echo "IMPORTANTE: Você precisa atualizar manualmente:"
echo "1. resources/css/app.css - substituir por app.scss e importar Bootstrap"
echo "2. resources/js/app.js - adicionar import do Bootstrap"
echo "3. vite.config.js - atualizar para compilar SCSS"
echo "4. Atualizar os templates Blade conforme necessário"
echo "=========================================="
