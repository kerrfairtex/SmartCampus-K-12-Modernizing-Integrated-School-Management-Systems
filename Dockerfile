FROM php:8.1-apache

# System deps for PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip curl \
    libpq-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev libicu-dev libonig-dev libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions (Laravel 8 requirements + Postgres + image/Excel)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql pgsql mbstring gd zip exif bcmath intl opcache pcntl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Apache rewrite (for Laravel public/.htaccess)
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html

# --no-scripts: no artisan commands run during build (no .env yet);
# the entrypoint writes .env and runs package:discover / passport:keys / migrate / cache
# --prefer-source: clone via git instead of downloading tarballs from
# codeload.github.com, which rate-limits unauthenticated builds (HTTP 429 ->
# "Failed to download ... from dist") and makes every build fail ~60 packages in.
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts --prefer-source

# Writable dirs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
