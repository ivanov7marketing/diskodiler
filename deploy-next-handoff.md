# DiskoDiler Laravel MVP: Deploy Handoff

## Что уже сделано

- Laravel-приложение находится в `laravel/`.
- Каталог переведен на серверный Blade-рендер:
  - `/diski`
  - `/diski/{brand}`
  - `/diski/{brand}/{vehicleModel}`
  - `/product/{product:slug}`
- Работает Filament-админка для брендов, моделей, товаров и заявок.
- Есть модели `Brand`, `VehicleModel`, `Product`, `ProductImage`, `Lead`.
- Есть сидер демо-каталога `CatalogDemoSeeder`.
- Карточка товара доработана как продающая SEO-страница:
  - фото/галерея 1:1;
  - видео/poster;
  - цена, наличие, состояние;
  - CTA-модалки;
  - характеристики;
  - похожие товары;
  - Product JSON-LD, BreadcrumbList и FAQPage.
- Заявки сохраняются в БД, в Filament есть менеджерские статусы, фильтры и быстрые действия.
- Страницы услуг доработаны:
  - `/services`
  - `/services/vin-selection`
  - `/services/wheel-restoration`
  - `/services/premium-tire-fitting`
- На главной есть блок услуг в стиле страницы `/services`.
- Доработана страница `/delivery` с доставкой/оплатой, адресами, FAQ и JSON-LD.
- В шапке есть пункты: `Каталог`, `Услуги`, `Доставка`, `О компании`.
- Для тестового домена нужно закрыть сайт от индексации.
- Последняя проверка: `php artisan test` проходит, `22 passed / 315 assertions`.

## Текущий Git/деплой-контекст

- Репозиторий: `https://github.com/ivanov7marketing/diskodiler.git`
- Текущая ветка: `main`
- Старую статичную версию уже публиковали через GitHub на VPS Timeweb.
- Тестовый домен: `diskodiler.shop`.
- HTTPS на домене уже настроен.
- На сервере сейчас, вероятно, висит статичная версия сайта.
- БД для Laravel на сервере, скорее всего, еще не создавалась.

## Что нужно сделать дальше для публикации

1. Подготовить код к деплою:
   - убедиться, что `laravel/` добавлен в Git;
   - закоммитить актуальные изменения;
   - запушить в GitHub.

2. Получить/использовать SSH-доступ к VPS:
   - host/IP;
   - user;
   - port;
   - пароль или SSH key.

3. На сервере найти текущий webroot и конфиг домена `diskodiler.shop`:
   - nginx или apache;
   - путь текущего статического сайта;
   - текущий deploy-процесс через GitHub.

4. Создать БД для Laravel:
   - MySQL/MariaDB database;
   - database user;
   - password;
   - host.

5. Настроить production `.env`:
   ```env
   APP_NAME=DiskoDiler
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://diskodiler.shop

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...

   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database

   FILESYSTEM_DISK=local
   PRODUCT_MEDIA_DISK=public
   ```

6. S3 можно подключить сразу или позже.
   Для Timeweb S3 нужны:
   ```env
   PRODUCT_MEDIA_DISK=s3
   AWS_ACCESS_KEY_ID=...
   AWS_SECRET_ACCESS_KEY=...
   AWS_DEFAULT_REGION=ru-1
   AWS_BUCKET=...
   AWS_ENDPOINT=https://s3.twcstorage.ru
   AWS_URL=https://s3.twcstorage.ru/BUCKET_NAME
   AWS_USE_PATH_STYLE_ENDPOINT=false
   ```
   Для первого тестового запуска проще оставить `PRODUCT_MEDIA_DISK=public`.

7. Выполнить на сервере:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate --force
   php artisan migrate --force
   php artisan db:seed --class=CatalogDemoSeeder --force
   php artisan storage:link
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

8. Создать production admin-пользователя Filament:
   - email: `m7-agency@yandex.ru`
   - пароль не хранить в репозитории; после первого входа лучше сменить.

9. Настроить web-сервер на Laravel:
   - document root должен смотреть в `laravel/public`;
   - включить обработку PHP-FPM;
   - сохранить HTTPS.

10. Закрыть тестовый домен от индексации:
    - для `diskodiler.shop` отдать `robots.txt`:
      ```txt
      User-agent: *
      Disallow: /
      ```
    - желательно добавить `noindex` на тестовом окружении.

11. После публикации проверить:
    - `/`
    - `/diski`
    - `/diski/bmw`
    - `/diski/bmw/x5-g05`
    - одну карточку товара;
    - `/services`
    - `/delivery`
    - `/admin`
    - отправку заявки;
    - `/robots.txt`
    - `/sitemap.xml` или его отключение/закрытие для тестового домена.

## Важные ограничения

- На тестовом домене не давать поисковикам индексировать сайт.
- Пароли и S3-ключи не коммитить.
- Если используем demo-товары, после деплоя проверить, что изображения, external fallback и `/storage/...` открываются.
- Если сервер уже обслуживает статичный сайт, перед заменой сохранить backup текущего webroot/config.
