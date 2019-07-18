FROM nginx:stable-alpine

ARG APP_UID
ARG APP_GID

# Forcing to run all web components with the same static UID/GID for preventing files owning issues
RUN apk --no-cache add shadow \
    && usermod -u $APP_UID nginx \
    && groupmod -o -g $APP_GID nginx
