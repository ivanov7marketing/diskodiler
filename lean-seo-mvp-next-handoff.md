# DiskoDiler Lean SEO MVP: Handoff на следующий диалог

Дата: 2026-04-19

## Что уже сделано в этом диалоге

- Изучен контекст `laravel-mvp-handoff.md` и продолжена Laravel-часть проекта в `laravel/`.
- Установлен и настроен Filament для админки `/admin`.
- Добавлены управляемые сущности каталога:
  - `Brand`
  - `VehicleModel`
  - `Product`
  - `ProductImage`
- Добавлены Filament-разделы:
  - Бренды
  - Модели авто
  - Товары
  - Заявки
- Добавлен dev-admin:
  - `admin@diskodiler.local`
  - `password`
- Настроен доступ в Filament только для admin-пользователей с подтвержденным email.
- Перенесены demo-товары из JS в БД через `CatalogDemoSeeder`.
- Публичный каталог переведен на серверный Blade-рендер:
  - `/diski`
  - `/diski/{brand}`
  - `/diski/{brand}/{vehicleModel}`
  - `/product/{product:slug}`
- Старый demo-slug товара сохранен:
  - `/product/19-style-793-individual-oem-36118089896`
- Главная страница теперь получает активные бренды из БД.
- Добавлены бренды:
  - BMW
  - Mercedes-Benz
  - Porsche
  - Range Rover
  - Lamborghini
  - Rolls-Royce
  - RAM
- На главной карточки брендов сделаны в 4 колонки на desktop.
- Карточки блока “Чаще всего подбираем” на главной теперь ведут на отдельные SEO-страницы моделей, а не на query-фильтры:
  - `/diski/bmw/x5-g05`
  - `/diski/bmw/x3-g01`
  - `/diski/bmw/3-4-g20`
  - `/diski/bmw/m3-m4-g80-g82`
  - `/diski/porsche/cayenne`
  - `/diski/mercedes-benz/gle-w167`
  - `/diski/range-rover/sport`
- Добавлена отдельная модель BMW M3 / M4 G80 G82 в сидер.
- Общая страница `/diski` получила корректный общий заголовок:
  - title: `Оригинальные диски купить в Санкт-Петербурге | ДискоДилер`
  - h1: `Каталог оригинальных дисков`
- Страницы брендов доработаны под SEO на основе файла `Семантическое ядро Яндекс.xlsx`.
- В публичных SEO-текстах убраны внутренние фразы вроде “семантическое ядро”, “кластеры”, “спрос”, “брендовые запросы”.
- Добавлены покупательские SEO-блоки:
  - популярные варианты подбора
  - цена и наличие
  - Санкт-Петербург и доставка
  - подбор без ошибки по VIN
  - FAQ
  - BreadcrumbList JSON-LD
- Исправлены визуальные проблемы блока `OEM-проверка` на страницах брендов/моделей.
- Исправлена проблема Filament без `ext-intl`: таблицы админки открываются без ошибок.
- Текущая проверка после последних изменений:
  - `php artisan test` проходит
  - последний результат: `11 passed`, `98 assertions`

## Важные текущие файлы

- `laravel/app/Http/Controllers/CatalogController.php`
- `laravel/app/Http/Controllers/HomeController.php`
- `laravel/database/seeders/CatalogDemoSeeder.php`
- `laravel/resources/views/catalog/index.blade.php`
- `laravel/resources/views/pages/home.blade.php`
- `laravel/resources/views/products/show.blade.php`
- `laravel/app/Filament/Resources/Products/Schemas/ProductForm.php`
- `laravel/app/Filament/Resources/Products/Tables/ProductsTable.php`
- `laravel/public/assets/css/styles.css`
- `laravel/tests/Feature/LeanSeoMvpTest.php`

## Что важно помнить

- Основной Laravel-проект находится в папке `laravel/`.
- В корне репозитория есть старый статичный сайт. Его сейчас не трогаем.
- Каталог должен оставаться серверно рендеримым, чтобы HTML был доступен поисковикам без JS.
- JS оставляем для модалок, форм, галереи, trade-in и recently-viewed, но не для клиентского рендера каталога.
- Для SEO ориентируемся на Яндекс, но не превращаем страницы в “SEO-простыни”. Тексты должны быть покупательскими.
- Timeweb S3 планируется использовать для изображений и видео товаров.
- Сейчас `ProductImage` хранит только URL, alt, sort, is_primary.
- В админке товара медиа сейчас добавляются только ссылкой.

## Следующий запрос для нового диалога

Скопируй текст ниже в новый диалог:

```text
Продолжи разработку DiskoDiler Laravel MVP по файлам:
- lean-seo-mvp-plan.md
- laravel-mvp-handoff.md
- lean-seo-mvp-next-handoff.md

Контекст:
Laravel-приложение находится в папке laravel/. Каталог уже переведен на серверный Blade-рендер, Filament-админка работает, есть модели Brand, VehicleModel, Product, ProductImage, сидер CatalogDemoSeeder, SEO-страницы /diski, /diski/{brand}, /diski/{brand}/{vehicleModel}, /product/{product:slug}. Главная страница и карточки популярных моделей уже ведут на отдельные посадочные страницы.

Нужно продолжить с улучшения раздела “Товары” в админке и SEO карточек товара.

Первый шаг, быстрый и полезный:
- добавить SEO-поля товара;
- добавить JSON-LD Product;
- добавить загрузку изображений в S3 через Filament;
- оставить внешние URL как запасной вариант;
- сделать alt обязательным для изображений.

Второй шаг:
- добавить видео;
- добавить poster/превью для видео;
- расширить параметры дисков отдельными полями;
- добавить похожие товары и внутреннюю перелинковку;
- сделать нормальный статус наличия и состояния комплекта.

Требования:
- Сначала изучи текущие файлы Product, ProductImage, ProductResource, ProductForm, ProductsTable, products/show.blade.php, config/filesystems.php и миграции каталога.
- Используй существующие паттерны проекта.
- Не ломай текущие URL товаров.
- Сохрани возможность добавлять медиа внешней ссылкой.
- Для S3 ориентируйся на Timeweb S3-compatible storage: endpoint https://s3.twcstorage.ru, настройки через .env, без хардкода ключей.
- После реализации обнови тесты и проверь php artisan test.
```

