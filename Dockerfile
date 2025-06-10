# Use official PHP image with Apache
FROM php:8.2-apache

# Install mysqli and GD for image functions
RUN apt-get update && apt-get install -y libpng-dev \
    && docker-php-ext-install mysqli gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy all your app files to the Apache root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Expose Apache default port
EXPOSE 80
