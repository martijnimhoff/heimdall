FROM php:7.4-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP extensions
RUN rm /etc/apt/preferences.d/no-debian-php \
    && apt-get update \
    && apt-get install -y sudo zip unzip git curl gnupg libpq-dev libzip-dev libpng-dev \
        libwebp-dev libjpeg62-turbo-dev libxpm-dev libfreetype6-dev libxml2-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip pdo_mysql

# Install and configure xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install composer
RUN curl --silent --show-error https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Configure entry point
ADD docker-php-entrypoint.sh /opt/docker-php-entrypoint.sh
RUN chmod a+x /opt/docker-php-entrypoint.sh

ADD www.conf /usr/local/etc/php-fpm.d/www.conf

# Add a file that changes php ini values
ADD custom-php-conf.ini /usr/local/etc/php/conf.d/custom-php-conf.ini

ENTRYPOINT ["/opt/docker-php-entrypoint.sh"]

CMD ["php-fpm"]
