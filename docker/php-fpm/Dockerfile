FROM phpdockerio/php72-fpm:latest

ARG DEBIAN_FRONTEND=noninteractive
ARG APP_ROOT_DIR
ARG APP_UID
ARG APP_GID

WORKDIR ${APP_ROOT_DIR}

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php-xdebug \
        php7.2-curl \
        php7.2-dom \
        php7.2-xml \
        php7.2-xmlrpc \
        php7.2-json \
        php7.2-gd \
        php-imagick \
        php7.2-mbstring \
        php7.2-pgsql \
        php-yaml \
        php-memcached \
        php-oauth \
        libcurl4-openssl-dev \
        libxml2-dev \
        php7.2-bcmath \
        php7.2-bz2 \
        php7.2-enchant \
        php7.2-gmp \
        php-igbinary \
        php7.2-intl \
        php-ssh2 \
        postgresql-server-dev-all \
        postgresql-client \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN usermod -u $APP_UID www-data \
    && groupmod -o -g $APP_GID www-data
