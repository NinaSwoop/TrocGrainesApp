FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    zip unzip git \
    && docker-php-ext-install \
    pdo_pgsql intl opcache \
    && pecl install redis && docker-php-ext-enable redis

COPY --from=composer/composer:2-bin /composer /usr/bin/composer

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini \
    && echo "short_open_tag = Off" >> /usr/local/etc/php/php.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/php.ini

WORKDIR /app/backend

COPY ./composer.json /app/backend/composer.json
COPY . /app/backend

RUN ls -al /app/backend


RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

EXPOSE 9000

CMD ["php-fpm"]