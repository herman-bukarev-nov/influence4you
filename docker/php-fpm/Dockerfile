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
        libxrender1 \
        libssl-dev \
        wget \
        fontconfig \
        xfonts-base \
        xfonts-75dpi \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN cd /tmp && wget "https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox_0.12.5-1.bionic_amd64.deb" \
    && apt-get -f install -y  ./wkhtmltox_0.12.5-1.bionic_amd64.deb && rm ./wkhtmltox_0.12.5-1.bionic_amd64.deb

RUN usermod -u $APP_UID www-data \
    && groupmod -o -g $APP_GID www-data
