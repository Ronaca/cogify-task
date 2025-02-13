FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl pdo pdo_mysql

WORKDIR /var/www/html

COPY . .

RUN composer install

CMD ["php-fpm"]
