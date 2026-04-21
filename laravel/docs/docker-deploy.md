# Docker Deploy Notes

## Target Server Topology

- Existing public HTTP/HTTPS entrypoint: Docker container `chatbot-nginx-1`.
- Existing public Docker network: `chatbot_chatbot_net`.
- DiskoDiler project path on host: `/opt/diskodiler`.

## Laravel Containers

The production compose file for the Laravel app lives in `docker-compose.prod.yml`.

- `app`: PHP-FPM runtime for Laravel, joined to the existing `chatbot_chatbot_net` as `diskodiler-app`.
- `db`: isolated PostgreSQL container dedicated to DiskoDiler.

This keeps the current chatbot stack intact while letting the shared nginx proxy PHP requests to Laravel.

## Required Server Files

Create `/opt/diskodiler/laravel/.env` with production values similar to:

```env
APP_NAME=DiskoDiler
APP_ENV=production
APP_DEBUG=false
APP_URL=https://diskodiler.shop
APP_PREVENT_INDEXING=true
APP_KEY=

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=diskodiler
DB_USERNAME=diskodiler
DB_PASSWORD=change-me

POSTGRES_DB=diskodiler
POSTGRES_USER=diskodiler
POSTGRES_PASSWORD=change-me

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=local
PRODUCT_MEDIA_DISK=public
```

## First Start

From `/opt/diskodiler/laravel`:

```bash
docker compose -f docker-compose.prod.yml up -d --build
docker compose -f docker-compose.prod.yml exec app php artisan key:generate --force
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
docker compose -f docker-compose.prod.yml exec app php artisan db:seed --class=CatalogDemoSeeder --force
docker compose -f docker-compose.prod.yml exec app php artisan optimize:clear
docker compose -f docker-compose.prod.yml exec app php artisan config:cache
docker compose -f docker-compose.prod.yml exec app php artisan route:cache
docker compose -f docker-compose.prod.yml exec app php artisan view:cache
```

## Nginx Switch

Replace the `diskodiler.shop` server blocks in `/opt/chatbot/nginx/nginx.conf` with `docker/nginx/diskodiler.conf.example`, then reload the existing nginx container.

## Admin User

After the app starts, create an admin user inside the app container and verify `/admin`.
