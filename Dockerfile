FROM php:8.2-apache

# Install GD and MySQLi
RUN apt-get update && apt-get install -y libpng-dev && \
    docker-php-ext-install gd mysqli

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy your app files
COPY . /var/www/html/

WORKDIR /var/www/html

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html
