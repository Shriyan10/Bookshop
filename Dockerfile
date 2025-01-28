# Use an official PHP image with Apache
FROM php:8.1-apache

# Enable required PHP extensions
RUN docker-php-ext-install mysqli

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container
COPY . /var/www/html/

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose the port that the PHP built-in server will run on
EXPOSE 9900

# Set the command to run the PHP server
CMD ["php", "-S", "0.0.0.0:9900", "-t", "."]
