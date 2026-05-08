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

WORKDIR /var/www/html

CMD ["php-fpm"]
