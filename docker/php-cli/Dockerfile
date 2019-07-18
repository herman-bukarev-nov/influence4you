ARG FROM_NAME
FROM ${FROM_NAME}

ARG APP_ROOT_DIR
ARG APP_UID
ARG APP_GID
ARG DEBIAN_FRONTEND=noninteractive

WORKDIR ${APP_ROOT_DIR}

ENV LANG=en_US.utf8 \
    LC_ALL=C.UTF-8 \
    TERM=xterm \
    DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y \
    && apt-get -y --no-install-recommends install \
        nano \
        curl \
        git \
        patch \
        postgresql-client \
        software-properties-common \
        wget \
        unzip \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

ENV PATH "$PATH:$APP_ROOT_DIR:$APP_ROOT_DIR/vendor/bin"

RUN userdel www-data \
    && groupadd -o --gid $APP_GID application \
    && useradd --uid $APP_UID --gid $APP_GID --shell /bin/bash --home /home/application -m application

RUN chmod o+w /run
