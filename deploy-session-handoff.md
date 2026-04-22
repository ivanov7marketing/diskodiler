# Deploy Session Handoff

## Что уже сделали

- Проверили локальную готовность релиза по `deploy-next-handoff.md`.
- Выяснили, что `laravel/` не был в git, а корень репозитория содержит старую статику и служебные файлы.
- Добавили антииндексацию для тестового домена в Laravel:
  - `APP_PREVENT_INDEXING`
  - глобальный `noindex,nofollow`
  - `robots.txt` с `Disallow: /`
- Привели `laravel/.env.example` к первому тестовому деплою:
  - `APP_PREVENT_INDEXING=false`
  - `PRODUCT_MEDIA_DISK=public`
- Добавили тест на антииндексацию и прогнали тесты локально успешно.
- В git включили только `laravel/`, без старой статики в корне.
- Создали и запушили коммиты:
  - `52b4724` - `Add Laravel MVP application`
  - `af9f215` - `Add Laravel Docker deployment setup`
  - `86f5f37` - `Use PHP 8.4 for Laravel app container`

## Что нашли на сервере

- SSH-доступ работает:
  - host: `89.23.102.93`
  - user: `root`
- Домен `diskodiler.shop` сейчас обслуживается Docker-контейнером `chatbot-nginx-1`.
- Текущий публичный сайт статический.
- Конфиг nginx для домена живет на хосте в `/opt/chatbot/nginx/nginx.conf`.
- Текущий root для сайта смотрит в `/opt/diskodiler`.
- На хосте нет готового стека для Laravel (`php`, `composer`, `mysql`), поэтому выбрали деплой Laravel через Docker.

## Что уже подготовили для Docker-деплоя

- Добавили в `laravel/` файлы:
  - `docker-compose.prod.yml`
  - `docker/php/Dockerfile`
  - `docker/php/entrypoint.sh`
  - `docker/nginx/diskodiler.conf.example`
  - `docs/docker-deploy.md`
- Загрузили эти файлы на сервер в `/opt/diskodiler/laravel`.
- Создали production `.env` на сервере для Laravel-контейнеров.
- Подняли контейнеры Laravel:
  - `app`
  - `db`
- Исправили проблему совместимости и перевели PHP-образ на `8.4`.
- Выполнили внутри контейнера:
  - `php artisan key:generate --force`
  - `php artisan migrate --force`

## Где остановились

- Последний шаг в диалоге: запуск сидера
  - `php artisan db:seed --class=CatalogDemoSeeder --force`
- До этого была одна ошибка сидирования по таблице `brands`, но затем таблицы уже были видны в БД.
- После повторного запуска сидера в выводе было только `INFO  Seeding database.`
- Нужно заново проверить, завершилось ли сидирование успешно и появились ли данные каталога.

## Следующие микрошаги

1. Проверить результат сидирования:
   - количество брендов, моделей и товаров в БД
   - последние логи `laravel-app-1`
2. Если сидирование успешно:
   - выполнить cache/optimize-команды Laravel
   - создать admin-пользователя Filament
3. После этого переключить nginx `diskodiler.shop` со статики на Laravel:
   - использовать основу из `/opt/diskodiler/laravel/docker/nginx/diskodiler.conf.example`
   - обновить `/opt/chatbot/nginx/nginx.conf`
   - перезагрузить контейнер nginx
4. Провести smoke-check после переключения:
   - `/`
   - `/diski`
   - `/diski/bmw`
   - карточка товара
   - `/services`
   - `/delivery`
   - `/admin`
   - `/robots.txt`
   - `/sitemap.xml`
5. Проверить отправку заявки и базовую админку.

## Важные замечания для нового диалога

- Пользователь хочет двигаться строго микрошагами, без забегания вперед.
- На сервере `/opt/diskodiler` не является git-репозиторием, поэтому обновление идет через копирование файлов, а не через `git pull`.
- В корне локального репозитория по-прежнему есть незакоммиченная старая статическая версия сайта и служебные файлы; в релизные Laravel-коммиты они не входили.
