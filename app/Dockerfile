FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y git curl zip unzip libxslt1-dev zlib1g-dev libpng-dev libonig-dev libzip-dev && \
    docker-php-ext-install pdo_mysql exif pcntl bcmath gd intl xsl zip && \
    apt-get remove -y libxslt1-dev icu-devtools libicu-dev libxml2-dev && \
    rm -rf /var/lib/apt/lists/*

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json /var/www/
COPY database /var/www/database

# Set working directory
WORKDIR /var/www

COPY . /var/www

RUN composer install

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache

RUN php artisan optimize
