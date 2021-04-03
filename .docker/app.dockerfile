FROM php:7.3-apache

MAINTAINER Alugbin LordRahl Abiodun

COPY . /app
COPY .docker/conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/conf/php.ini /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /app
RUN mv .env.stub .env

RUN apt-get update && apt-get install -y \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql json zip


RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --quiet --optimize-autoloader && composer update --quiet --optimize-autoloader

RUN chown -R www-data:www-data /app && a2enmod rewrite
# RUN  php artisan jwt:secret
# RUN php artisan key:generate
RUN php artisan config:clear
