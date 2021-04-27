FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    && pecl install xdebug-3.0.4 \
	&& docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo pdo_mysql

ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /symfony