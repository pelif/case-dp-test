
## No container rodar estes comandos 

```
PERMISSÕES NO CONTAINER 

docker exec -it laravel_app bash

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 777 /var/www/html/storage

RUN chmod -R 777 /var/www/html/bootstrap/cache

RUN find /var/www/html/storage -type d -exec chmod 777 {} \;

RUN find /var/www/html/bootstrap/cache -type d -exec chmod 777 {} \;

```

## Instalação Breeze ara Fluxo de Autenticação

```
 Instalar Breeze
docker-compose exec app composer require laravel/breeze --dev

# Executar instalação (escolha blade, react ou vue)
docker-compose exec app php artisan breeze:install blade

# Instalar dependências NPM
docker-compose exec app npm install

# Rodar migrations
docker-compose exec app php artisan migrate

# Compilar assets
docker-compose exec app npm run dev
```


