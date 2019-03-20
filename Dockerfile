FROM php:7.3.3-fpm as php-prod

# Make commands more silent
ENV DEBIAN_FRONTEND=noninteractive

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /var/www/.composer
COPY --from=composer:1.8.0 /usr/bin/composer /usr/bin/composer

RUN apt-get update -qq && \
    apt-get install -qq \
        git \
        libicu-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
        zip \
        zlib1g-dev && \
    rm -r /var/lib/apt/lists/* && \
    apt-get clean -qq && \
    (docker-php-ext-install \
        intl \
        json \
        mbstring \
        opcache \
         > /dev/null) && \
    (pecl install apcu > /dev/null) && \
    (docker-php-ext-enable apcu > /dev/null) && \
    composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress \
        --no-suggest --optimize-autoloader --classmap-authoritative  --no-interaction -q

COPY . .

RUN composer install --no-dev --prefer-dist --no-progress \
    --no-suggest --optimize-autoloader --classmap-authoritative  --no-interaction && \
    bin/console cache:clear -e prod

FROM php-prod as php-dev

RUN composer install --no-progress -q && \
    # Init (install) phpunit
    bin/phpunit --version && \
    curl -sSL https://github.com/xdebug/xdebug/archive/master.zip -o /tmp/xdebug.zip && \
        unzip /tmp/xdebug.zip -d /tmp && \
        cd /tmp/xdebug-* && \
        (./rebuild.sh > /dev/null) && \
        rm -rf /tmp/xdebug* && \
        rm -rf /tmp/pear && \
    echo "xdebug.remote_host=172.17.0.1" > /usr/local/etc/php/conf.d/xdebug-host.ini && \
    echo "xdebug.remote_enable=On" >> /usr/local/etc/php/conf.d/xdebug-host.ini && \
    (docker-php-ext-enable xdebug > /dev/null)

FROM nginx:1.15.9-alpine as web

COPY docker/nginx/conf.d /etc/nginx/conf.d/

COPY ./public /var/www/html/public
COPY --from=php-prod /var/www/html/public/bundles /var/www/html/public/bundles
