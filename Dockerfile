# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install mysqli extension for MySQL database support
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy all application files into the web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Fix file permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose the default Apache port
EXPOSE 80
