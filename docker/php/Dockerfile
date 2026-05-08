FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
        git \
        unzip \
        icu-dev \
        libzip-dev \
        libpng-dev \
        postgresql-dev \
        oniguruma-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        intl \
        mbstring \
        gd \
        zip \
        opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dev-only: run php-fpm as root so phpunit (executed via `docker compose exec`
# as root) and the php-fpm worker share the same uid, avoiding Permission
# denied on tmp/cache/ files. NEVER use this image in production.
RUN sed -i 's/^user = www-data/user = root/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^group = www-data/group = root/' /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

CMD ["php-fpm", "-R"]
