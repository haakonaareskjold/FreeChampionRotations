FROM ubuntu:latest

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -y nginx

RUN apt-get update \
    && apt-get install -y apt-transport-https lsb-release ca-certificates curl software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update

RUN apt-get update \
    && apt-get install -y \
    php7.4-fpm php7.4-zip cron vim-tiny

RUN mkdir -p /run/php/

# Install composer and put binary into $PATH
RUN curl -sS https://getcomposer.org/installer | php \
	&& mv composer.phar /usr/local/bin/ \
	&& ln -s /usr/local/bin/composer.phar /usr/local/bin/composer


COPY default.nginx /etc/nginx/sites-enabled/default

# Runs PHP-FPM and NGINX, executes through bash the composer install, chown the cache dir and then infinite loop to keep container alive
CMD /usr/sbin/php-fpm7.4 && /usr/sbin/nginx && /bin/bash -c "chmod -R 775 ./ && chown :www-data resources/Cache && \
composer install --no-dev && composer dumpautoload \
&& while true; do sleep 30; done;"
