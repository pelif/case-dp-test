FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js e NPM (necessário para Breeze)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Configurar GD corretamente
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instalar extensões PHP necessárias
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_sqlite \
    sqlite3 \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    xml \
    zip

# Habilitar módulo de reescrita do Apache
RUN a2enmod rewrite

# Definir DocumentRoot para pasta public do Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar aplicação Laravel
COPY . /var/www/html

# ========== CORREÇÃO DE PERMISSÕES ==========
# Definir proprietário e permissões básicas
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 777 /var/www/html/storage

RUN chmod -R 777 /var/www/html/bootstrap/cache

# Garantir que o Apache consegue escrever nos arquivos
RUN find /var/www/html/storage -type d -exec chmod 777 {} \;

RUN find /var/www/html/bootstrap/cache -type d -exec chmod 777 {} \;

# =============================================

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instalar dependências do Composer
RUN composer install --no-dev --no-interaction --prefer-dist

# Limpar caches ao iniciar
RUN php artisan cache:clear 2>/dev/null || true
RUN php artisan view:clear 2>/dev/null || true
RUN php artisan config:clear 2>/dev/null || true

# Configurar upload_max_filesize e post_max_size para uploads
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini

# Expor porta
EXPOSE 80

CMD ["apache2-foreground"]
