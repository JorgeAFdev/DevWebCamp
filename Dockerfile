FROM php:8.2-apache

# Start from the production ini template: the base image ships no php.ini, so the
# compiled defaults (display_errors=On, expose_php=On) would leak DB host/user in
# an uncaught mysqli exception. The production template turns those off.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# System libs for GD (WebP/PNG/JPEG) required by intervention/image, plus curl
# for the healthcheck and unzip for composer.
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg62-turbo-dev libfreetype6-dev libwebp-dev \
        unzip curl \
    && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
    && docker-php-ext-install -j"$(nproc)" gd mysqli \
    && rm -rf /var/lib/apt/lists/*

# Default upload_max_filesize is 2M, which rejects most phone photos before PHP
# sees them. memory_limit covers GD decompressing the full image for fit(800,800).
RUN printf 'upload_max_filesize=10M\npost_max_size=12M\nmemory_limit=256M\n' \
      > "$PHP_INI_DIR/conf.d/uploads.ini"

# Apache: DocumentRoot to public/, mod_rewrite for the front controller, and a
# global ServerName to silence the FQDN warning on every start.
RUN a2enmod rewrite \
    && sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
        > /etc/apache2/conf-available/devwebcamp.conf \
    && a2enconf devwebcamp \
    && echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Manifests first so this layer caches until a dependency actually changes.
# composer.lock is required: installing without it turns install into a de-facto
# update, resolving different versions on every build.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
  CMD curl -fsS http://localhost/ >/dev/null || exit 1

EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
