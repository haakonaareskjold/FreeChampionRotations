FROM composer:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN chown -R www-data:www-data ./

RUN chmod -R 775 ./