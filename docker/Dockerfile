FROM php:8.1-apache
WORKDIR /var/www/html/IMSExport
RUN apt-get update  \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        libzip-dev \
        nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip
RUN a2enmod rewrite \
    && /etc/init.d/apache2 restart
