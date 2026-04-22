# DiskoDiler Laravel MVP handoff

Дата: 18 апреля 2026

## Контекст проекта

Изначально в репозитории был статичный макет сайта DiskoDiler:

- `index.html`
- `catalog.html`
- `product.html`
- `services.html`
- `about.html`
- `proposal.html`
- `assets/css/styles.css`
- `assets/js/app.js`
- `assets/img/...`

Бизнес-цель описана в `lean-seo-mvp-plan.md`: сделать Lean SEO MVP, где основная логика:

**SEO-страница -> доверие -> заявка -> менеджер**

MVP не должен сразу быть полноценным интернет-магазином. В первой версии не делаем оплату, корзину, автоматическую бронь, amoCRM и Excel-импорт. Фокус: SEO-страницы, каталог, заявки, менеджерская обработка.

## Домены и адреса

Старый серверный адрес, по которому раньше был доступен сайт:

```text
https://ai-chat-lend.ru/diskodiler/index.html
```

Новый домен:

```text
https://diskodiler.shop/
```

Все дальнейшие production-настройки нужно делать под новый домен `diskodiler.shop`.

При подготовке к выкладке нужно будет:

- настроить `APP_URL=https://diskodiler.shop`;
- проверить canonical URL;
- обновить `sitemap.xml`;
- обновить `robots.txt`;
- настроить web root на `laravel/public`;
- продумать редиректы со старого адреса, если есть доступ к старому серверу.

## Что уже сделано

### 1. Установлено окружение

Через официальный Laravel `php.new` установлен локальный набор:

```text
C:\Users\maxim\.config\herd-lite\bin
```

Там находятся:

- `php.exe`
- `composer.bat`
- `laravel.bat`

Проверенные версии:

- PHP 8.4.0
- Composer 2.8.12
- Laravel Installer 5.25.3

В текущей PowerShell-сессии команды `php`, `composer`, `laravel` могут не находиться по PATH, поэтому рабочий способ запуска:

```powershell
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan test
```

или временно добавить в PATH:

```powershell
$env:Path = 'C:\Users\maxim\.config\herd-lite\bin;' + $env:Path
```

### 2. Создан Laravel-проект

Laravel-приложение создано внутри текущего репозитория:

```text
C:\dev\web-remont\laravel
```

Статичный сайт в корне репозитория сохранен и не удалялся. Он остается как референс и fallback.

### 3. Перенесены ассеты

Статичные ассеты скопированы в Laravel:

```text
laravel/public/assets/css/styles.css
laravel/public/assets/js/app.js
laravel/public/assets/img/...
```

Laravel layout подключает их через `asset()`.

### 4. Сделан Blade layout

Основной layout:

```text
laravel/resources/views/layouts/app.blade.php
```

Он содержит:

- `meta charset="utf-8"`;
- `csrf-token`;
- `title`;
- `description`;
- optional `robots`;
- optional `canonical`;
- подключение CSS/JS;
- placeholders для текущего общего JS:
  - `data-shared-header`;
  - `data-shared-footer`;
  - `data-shared-floating`;
  - `data-shared-modals`.

Пока header/footer/modals все еще рендерятся через `public/assets/js/app.js`. Позже лучше перенести их в Blade partials.

### 5. Перенесены основные страницы в Blade

Страницы Laravel:

```text
laravel/resources/views/pages/home.blade.php
laravel/resources/views/catalog/index.blade.php
laravel/resources/views/services/index.blade.php
laravel/resources/views/services/premium-tire-fitting.blade.php
laravel/resources/views/services/wheel-restoration.blade.php
laravel/resources/views/services/vin-selection.blade.php
laravel/resources/views/pages/contacts.blade.php
laravel/resources/views/pages/delivery.blade.php
laravel/resources/views/pages/warranty.blade.php
laravel/resources/views/pages/privacy.blade.php
laravel/resources/views/pages/about.blade.php
laravel/resources/views/products/show.blade.php
laravel/resources/views/admin/leads.blade.php
```

Важно: после первой укороченной миграции были возвращены полные блоки из статического макета для:

- главной;
- услуг;
- about;
- карточки товара;
- каталога.

Была проблема с `????` в `<title>` и `description` из-за неверной кодировки при генерации Blade. Она исправлена.

### 6. Настроены маршруты

Файл:

```text
laravel/routes/web.php
```

Основные маршруты:

```text
GET  /
GET  /diski
GET  /services
GET  /services/premium-tire-fitting
GET  /services/wheel-restoration
GET  /services/vin-selection
GET  /contacts
GET  /delivery
GET  /warranty
GET  /privacy
GET  /about.html
GET  /product/19-style-793-individual-oem-36118089896
POST /leads
GET  /admin/leads
```

### 7. Добавлены заявки в SQLite

Создана модель:

```text
laravel/app/Models/Lead.php
```

Создан контроллер:

```text
laravel/app/Http/Controllers/LeadController.php
```

Создана миграция:

```text
laravel/database/migrations/2026_04_18_101629_create_leads_table.php
```

Поля `leads`:

- `type`
- `status`
- `name`
- `phone`
- `telegram`
- `vin`
- `message`
- `source_page`
- `goal`
- `utm`
- `payload`
- timestamps

Заявки отправляются из JS в:

```text
POST /leads
```

При этом localStorage-прототип в JS оставлен как запасной слой.

Временная менеджерская страница:

```text
http://127.0.0.1:8000/admin/leads
```

### 8. Добавлены базовые SEO-файлы

В корне статичного проекта:

```text
robots.txt
sitemap.xml
```

В Laravel они также скопированы:

```text
laravel/public/robots.txt
laravel/public/sitemap.xml
```

Перед production нужно обновить URL на `https://diskodiler.shop/`.

### 9. Добавлены тесты

Файл:

```text
laravel/tests/Feature/LeanSeoMvpTest.php
```

Проверяет:

- что публичные MVP-страницы доступны;
- что `POST /leads` сохраняет заявку.

Команда проверки:

```powershell
cd C:\dev\web-remont\laravel
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan test
```

Последний результат:

```text
4 passed, 16 assertions
```

### 10. Локальный сервер

Сайт проверялся локально:

```text
http://127.0.0.1:8000
```

Запуск:

```powershell
cd C:\dev\web-remont\laravel
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan serve --host=127.0.0.1 --port=8000
```

Полезные локальные URL:

```text
http://127.0.0.1:8000/
http://127.0.0.1:8000/diski
http://127.0.0.1:8000/services
http://127.0.0.1:8000/about.html
http://127.0.0.1:8000/product/19-style-793-individual-oem-36118089896
http://127.0.0.1:8000/admin/leads
```

## Важные замечания по текущему состоянию

1. Laravel-версия уже работает, но это еще не полноценный управляемый каталог.
2. Каталог товаров пока все еще в значительной степени зависит от `public/assets/js/app.js`, где демо-товары захардкожены в массиве.
3. Для SEO лучше, чтобы карточки каталога рендерились сервером через Blade, а не только JS.
4. Header/footer/modals пока рендерятся JS-ом. Лучше перенести их в Blade partials.
5. Админка заявок временная. Нужен Filament.
6. Товары, бренды и модели пока не заведены в БД.
7. Production-домен теперь `https://diskodiler.shop/`, а не старый `ai-chat-lend.ru/diskodiler`.

## Что делать следующим шагом

Рекомендуемый следующий этап:

### Этап 1. Filament и модели каталога

Поставить Filament:

```powershell
cd C:\dev\web-remont\laravel
$env:Path = 'C:\Users\maxim\.config\herd-lite\bin;' + $env:Path
composer require filament/filament
php artisan filament:install --panels
php artisan make:filament-user
```

Затем создать модели и миграции:

- `Brand`
- `VehicleModel`
- `Product`
- `ProductImage`

Минимальные таблицы:

```text
brands
vehicle_models
products
product_images
```

Затем сделать Filament resources:

```text
BrandResource
VehicleModelResource
ProductResource
LeadResource
```

### Этап 2. Перевести каталог на БД

Сейчас `/diski` должен перейти с JS-данных на серверные данные:

- фильтры читают query params;
- Laravel выбирает товары из БД;
- Blade рендерит карточки товаров;
- страницы доступны поисковику сразу в HTML.

### Этап 3. Реальный маршрут товара

Вместо одной демо-страницы:

```text
/product/19-style-793-individual-oem-36118089896
```

сделать:

```text
/product/{slug}
```

и рендерить товар из БД.

### Этап 4. SEO-страницы брендов и моделей

Добавить маршруты:

```text
/diski/{brand}
/diski/{brand}/{model}
```

Примеры:

```text
/diski/bmw
/diski/bmw/x5-g05
/diski/mercedes-benz
/diski/porsche/cayenne
```

Каждая страница должна иметь:

- title;
- description;
- H1;
- SEO-текст;
- список подходящих товаров;
- canonical.

### Этап 5. Уведомления по заявкам

Добавить уведомление менеджеру:

- email;
- или Telegram bot.

В заявке уже есть поля `type`, `goal`, `source_page`, `utm`, `payload`.

### Этап 6. Подготовка к staging на новом домене

Когда локальный MVP будет цельным, выкатывать не сразу на боевой сайт, а на staging.

Нужно проверить:

- PHP version на сервере;
- Composer;
- права на `storage` и `bootstrap/cache`;
- web root должен смотреть в `laravel/public`;
- `.env` production;
- `APP_URL=https://diskodiler.shop`;
- HTTPS;
- `robots.txt`;
- `sitemap.xml`;
- canonical;
- формы;
- админку;
- загрузку фото;
- редиректы со старого адреса.

## Production `.env` ориентир

Для будущего production:

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
```

Локально сейчас используется SQLite, созданный Laravel installer.

## Команды для нового диалога

Начать работу можно с:

```powershell
cd C:\dev\web-remont\laravel
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan test
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan route:list
```

Если сервер не запущен:

```powershell
cd C:\dev\web-remont\laravel
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan serve --host=127.0.0.1 --port=8000
```

Потом открыть:

```text
http://127.0.0.1:8000
```

## Рекомендуемая формулировка для нового диалога

```text
Продолжи разработку Laravel MVP для DiskoDiler по файлу laravel-mvp-handoff.md.
Следующий шаг: поставить Filament, создать модели brands / vehicle_models / products / product_images, сделать Filament resources и перевести /diski с JS-данных на серверный Blade-рендер из БД.
Новый production-домен: https://diskodiler.shop/.
Старый адрес был: https://ai-chat-lend.ru/diskodiler/index.html.
```
