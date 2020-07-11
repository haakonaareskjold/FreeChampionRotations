FROM php:7.4-fpm
ARG UID=1000
ARG GID=1000
RUN useradd -G www-data,root -u 1000 FCRuser
WORKDIR /var/www/app
USER ${UID}:${GID}
