FROM php:7.4-fpm-alpine
WORKDIR /var/www/app
ARG USER=FCRuser
ARG ID=1000

RUN adduser \
    --disabled-password \
    --gecos "" \
    --home "$(pwd)" \
    --no-create-home \
    --uid ${ID} \
    ${USER}


USER ${ID}:${ID}