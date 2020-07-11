FROM php:7.4-fpm
ARG uid=1000
ARG user=nemesis
RUN apt-get update && apt-get install -y cron
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/ && \
    chown -R $user:$user /home/$user

WORKDIR /var/www/app

USER $user
