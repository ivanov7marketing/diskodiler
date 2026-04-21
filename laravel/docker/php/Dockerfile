FROM php:8.4-fpm-alpine

RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev libzip-dev postgresql-dev; \
    apk add --no-cache bash git icu-libs libpq libzip unzip zip; \
    docker-php-ext-configure intl; \
    docker-php-ext-install -j"$(nproc)" bcmath intl opcache pdo_pgsql zip; \
    apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY docker/php/entrypoint.sh /usr/local/bin/diskodiler-entrypoint

RUN chmod +x /usr/local/bin/diskodiler-entrypoint

ENTRYPOINT ["diskodiler-entrypoint"]
CMD ["php-fpm"]
