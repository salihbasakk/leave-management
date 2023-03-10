FROM php:8.1-fpm
WORKDIR /var/www/symfony

RUN apt-get update && apt-get install -y \
    g++ \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libmemcached-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev

RUN pecl install xdebug
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql intl exif mbstring -j$(nproc) gd zip
RUN docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN ln -snf /usr/share/zoneinfo/Europe/Istanbul /etc/localtime && echo Europe/Istanbul > /etc/timezone \
    && printf '[Date]\ndate.timezone = "%s"\n', Europe/Istanbul > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

COPY . .

RUN composer install
