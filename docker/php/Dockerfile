FROM php:8.3-fpm

ARG HOST_UID
ARG HOST_GID

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y \
  git unzip

RUN groupadd -g ${HOST_GID} taichi \
  && useradd -m -u ${HOST_UID} -g ${HOST_GID} taichi

RUN apt-get update && apt-get install -y \
  git unzip libpng-dev libjpeg-dev libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd
