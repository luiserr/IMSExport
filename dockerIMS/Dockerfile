FROM php:5.6-apache
WORKDIR /var/www/html/IMSExport
RUN apt-get update  \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        libzip-dev \
        nano \
        cron \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip
RUN a2enmod rewrite \
    && /etc/init.d/apache2 restart \
    && service cron start \
    && service apache2 start

COPY ./root /etc/cron.d/root-cron

# Give execution rights on the cron job
RUN chmod 0644  /etc/cron.d/root-cron

# Apply cron job
RUN crontab /etc/cron.d/root-cron

# Create the log file to be able to run tail
#RUN touch /var/log/cron.log

# Run the command on container startup
#CMD cron && tail -f /var/log/cron.log

