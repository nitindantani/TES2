# Use official PHP image with Apache
FROM php:8.2-apache

# Install mysqli for MySQL support
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy all your app files to the Apache root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Optional: Set permissions
RUN chown -R www-data:www-data /var/www/html
