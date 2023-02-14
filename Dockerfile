FROM nginx:alpine-slim as nginx
ADD config/nginx/default.conf /etc/nginx/conf.d

FROM php:fpm-alpine as php
RUN docker-php-ext-install mysqli \
  && docker-php-ext-enable mysqli \
  && chmod 777 /tmp \
  && chmod 777 /var/www/html/*/*

