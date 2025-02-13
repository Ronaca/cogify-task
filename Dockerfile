FROM php:8.2-fpm

# Install required dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libicu-dev \
    && docker-php-ext-install intl pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

# Run Composer install
RUN composer install

CMD ["php-fpm"]
