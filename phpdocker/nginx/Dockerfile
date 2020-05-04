FROM nginx:alpine


RUN apk update \
    && apk add vim

COPY nginx.conf /etc/nginx/conf.d/default.conf

