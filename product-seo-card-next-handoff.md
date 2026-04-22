# DiskoDiler Laravel MVP: handoff на следующий шаг

Дата: 2026-04-19

## Цель следующего диалога

Следующий практический шаг: **довести карточку товара как продающую SEO-страницу**.

Техническая база для этого уже подготовлена: у товара есть SEO-поля, изображения, видео, poster, параметры дисков, статус наличия, состояние комплекта, JSON-LD Product и похожие товары. Теперь нужно улучшить саму публичную страницу товара: структура, продающие блоки, внутренняя перелинковка, доверие, CTA и SEO-текст.

## Что уже выполнено

- Laravel-приложение находится в `laravel/`.
- Каталог переведен на серверный Blade-рендер.
- Работают SEO-страницы:
  - `/diski`
  - `/diski/{brand}`
  - `/diski/{brand}/{vehicleModel}`
  - `/product/{product:slug}`
- Не нужно ломать текущие URL товаров. Особенно важно сохранить существующие slug-адреса.
- Filament-админка работает.
- Есть модели:
  - `Brand`
  - `VehicleModel`
  - `Product`
  - `ProductImage`
- Есть сидер `CatalogDemoSeeder` с демо-каталогом.
- Главная страница и карточки популярных моделей уже ведут на отдельные посадочные страницы моделей.

## Что добавлено в последнем этапе

- Добавлены SEO-поля товара:
  - `meta_title`
  - `meta_description`
  - `h1`
  - `seo_text`
- Добавлен JSON-LD `Product` на странице товара.
- Добавлен JSON-LD `BreadcrumbList`.
- Добавлена загрузка изображений через Filament в S3-compatible storage.
- Для S3 используется настройка через `.env`, без хардкода ключей.
- Ориентир для Timeweb S3-compatible storage:
  - endpoint: `https://s3.twcstorage.ru`
  - `PRODUCT_MEDIA_DISK=s3`
  - `AWS_ENDPOINT=https://s3.twcstorage.ru`
- Сохранена возможность добавлять изображения внешней ссылкой.
- `alt` для изображений сделан обязательным.
- Добавлены поля для видео:
  - загружаемый файл видео
  - внешний URL видео
  - poster/превью для видео
- Добавлены отдельные параметры дисков:
  - диаметр
  - ширина передняя
  - ширина задняя
  - ET передний
  - ET задний
  - PCD
  - DIA
- Добавлены похожие товары и внутренняя перелинковка.
- Добавлены нормальные статусы наличия и состояния комплекта.
- Добавлены динамические `/sitemap.xml` и `/robots.txt`.
- Удалены старые статические `public/sitemap.xml` и `public/robots.txt`, чтобы работали Laravel routes.
- Исправлен исторический mojibake в старых SEO-текстах каталога и сидера.
- Локальная база обновлена через `CatalogDemoSeeder`.
- Тесты обновлены и проходят.

Последняя проверка:

```powershell
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan test
```

Результат:

```text
14 passed, 127 assertions
```

## Важные файлы

- `laravel/app/Models/Product.php`
- `laravel/app/Models/ProductImage.php`
- `laravel/app/Http/Controllers/CatalogController.php`
- `laravel/app/Http/Controllers/SeoController.php`
- `laravel/app/Filament/Resources/Products/Schemas/ProductForm.php`
- `laravel/app/Filament/Resources/Products/Tables/ProductsTable.php`
- `laravel/resources/views/products/show.blade.php`
- `laravel/resources/views/catalog/index.blade.php`
- `laravel/resources/views/seo/sitemap.blade.php`
- `laravel/resources/views/seo/robots.blade.php`
- `laravel/config/filesystems.php`
- `laravel/database/migrations/2026_04_19_090000_extend_products_for_seo_media_and_specs.php`
- `laravel/database/seeders/CatalogDemoSeeder.php`
- `laravel/tests/Feature/LeanSeoMvpTest.php`
- `.env.example`
- `laravel/composer.json`
- `laravel/composer.lock`

## Важные ограничения

- Не ломать текущие URL товаров.
- Не удалять fallback на внешние URL медиа.
- Не хардкодить S3-ключи, bucket, region, endpoint в коде.
- Для Timeweb S3-compatible storage использовать `.env`.
- Не откатывать чужие изменения в рабочем дереве.
- В PowerShell старые `Get-Content`-выводы могут показывать mojibake из-за кодировки консоли, даже если файл сохранен корректно в UTF-8. Проверять лучше тестами, браузером или чтением через UTF-8.
- Локально может отсутствовать `ext-intl`; ранее зависимости ставились с учетом этого ограничения. Тесты при этом проходят.

## Готовый запрос для нового диалога

```text
Продолжи разработку DiskoDiler Laravel MVP по файлу product-seo-card-next-handoff.md.

Контекст:
Laravel-приложение находится в папке laravel/. Каталог уже переведен на серверный Blade-рендер, Filament-админка работает, есть модели Brand, VehicleModel, Product, ProductImage, сидер CatalogDemoSeeder, SEO-страницы /diski, /diski/{brand}, /diski/{brand}/{vehicleModel}, /product/{product:slug}. Главная страница и карточки популярных моделей уже ведут на отдельные посадочные страницы.

Последний этап уже выполнен:
- добавлены SEO-поля товара;
- добавлен JSON-LD Product;
- добавлена загрузка изображений в S3 через Filament;
- сохранены внешние URL как запасной вариант;
- alt обязателен для изображений;
- добавлены видео и poster;
- расширены параметры дисков отдельными полями;
- добавлены похожие товары и внутренняя перелинковка;
- сделаны нормальные статусы наличия и состояния комплекта;
- вычищен исторический mojibake в старых SEO-текстах каталога/сидера;
- php artisan test проходит.

Новый шаг:
Довести карточку товара как продающую SEO-страницу.

Сначала изучи текущие файлы:
- laravel/app/Models/Product.php
- laravel/app/Models/ProductImage.php
- laravel/app/Http/Controllers/CatalogController.php
- laravel/resources/views/products/show.blade.php
- laravel/resources/views/catalog/index.blade.php
- laravel/public/assets/css/styles.css
- laravel/tests/Feature/LeanSeoMvpTest.php
- миграции каталога и сидер CatalogDemoSeeder

Что нужно сделать:
1. Улучшить структуру публичной страницы товара /product/{product:slug}.
2. Сделать первый экран более продающим: фото/видео, H1, бренд, модель авто, OEM, цена, наличие, состояние, CTA на заявку.
3. Добавить понятные блоки доверия: проверка оригинальности, помощь по VIN, доставка, самовывоз/осмотр, состояние комплекта.
4. Лучше вывести характеристики дисков: диаметр, ширина, ET, PCD, DIA, OEM, год, совместимость с моделью авто.
5. Усилить SEO-текст товара без переспама: нормальный H2/H3, текст для покупателя, внутренние ссылки на бренд, модель, каталог и похожие товары.
6. Улучшить похожие товары: заголовок, карточки, ссылка на релевантную посадочную страницу.
7. Сохранить JSON-LD Product и BreadcrumbList, при необходимости расширить их аккуратно.
8. Сохранить поддержку S3-медиа и внешних URL.
9. Не ломать текущие URL товаров.
10. Обновить/добавить тесты и проверить php artisan test.

Используй существующие паттерны проекта. Не делай корзину, оплату, бронирование и тяжелый интернет-магазин: MVP остается SEO -> доверие -> заявка -> менеджер.
```

## Предлагаемый план работ для следующего шага

1. Провести короткий аудит текущего `products/show.blade.php`: какие данные уже есть, какие блоки дублируются, где слабый CTA.
2. Пересобрать layout карточки товара:
   - медиа-галерея;
   - ключевая информация;
   - цена и наличие;
   - CTA-заявка;
   - блок характеристик;
   - видео, если есть;
   - SEO-текст;
   - похожие товары и перелинковка.
3. Доработать CSS только в пределах публичной карточки товара и существующей дизайн-системы.
4. При необходимости добавить небольшие helper-методы в `Product`, но без лишних абстракций.
5. Обновить feature-тесты:
   - страница товара открывается;
   - H1/SEO-текст выводятся;
   - JSON-LD Product остается валидным по ключевым полям;
   - CTA и внутренние ссылки присутствуют;
   - похожие товары выводятся;
   - S3/external media fallback не сломан.
6. Запустить:

```powershell
& 'C:\Users\maxim\.config\herd-lite\bin\php.exe' artisan test
```

## Ожидаемый результат следующего шага

Карточка товара должна восприниматься не как техническая страница из каталога, а как посадочная SEO-страница конкретного комплекта дисков: пользователь быстро видит, что это за комплект, подойдет ли он его авто, в каком состоянии товар, есть ли он в наличии, сколько стоит и как оставить заявку.

