# Production Launch Checklist

## SEO and Routing

- `APP_URL` points to the production domain with the correct protocol.
- `/sitemap.xml` returns `200`, includes home, catalog, brand, model, product and service URLs, and does not include redirected URLs such as `/contacts`.
- `/robots.txt` returns `200`, allows public pages, blocks `/admin`, and points to `/sitemap.xml`.
- Canonical URLs are present on home, catalog, brand, model, product, service, delivery, warranty, privacy and about pages.
- Invalid catalog and product slugs return `404`.
- `/contacts` keeps a `301` redirect to `/about.html`.

## Laravel Production Config

- `APP_ENV=production`.
- `APP_DEBUG=false`.
- `APP_KEY` is set and not shared publicly.
- `CACHE_STORE`, `SESSION_DRIVER` and `QUEUE_CONNECTION` are selected for the production host.
- `LOG_CHANNEL` and log retention are configured for the server.
- `php artisan config:cache`, `php artisan route:cache` and `php artisan view:cache` are run after deploy.

## Media and Storage

- Public storage link exists if the `public` disk is used for uploaded media.
- S3 credentials are configured when `FILESYSTEM_DISK=s3`.
- Product images render from uploaded `/storage/...` paths and external fallback URLs.
- Video URLs and posters are reachable for product pages that use them.

## Admin and Leads

- `/admin` is available only to admin users.
- At least one verified admin user exists with a strong password.
- Lead forms save name, phone, contact method, source page and payload.
- Managers can filter new, in-progress and unhandled leads in Filament.

## Final Smoke Check

- Run `php artisan test`.
- Open `/`, `/diski`, one brand page, one model page, one product page and all service pages.
- Submit one test lead from a product page and one from a service page.
- Check mobile viewport for hero, catalog cards, product gallery, service forms and modal forms.
