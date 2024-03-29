# Use an official PHP runtime as a parent image
FROM php:8.2-apache as base

# Set the working directory
WORKDIR /var/www/html

# Copy composer.lock and composer.json to the working directory
COPY composer.lock composer.json /var/www/html/

# Set the proper permissions
RUN chown -R www-data:www-data /var

# Install any needed packages
RUN apt-get update
RUN apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    acl \
    openssl
RUN docker-php-ext-install -j$(nproc) intl zip pdo_pgsql

# Enable Apache modules
RUN a2enmod rewrite
RUN a2enmod headers

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Symfony application files to the container
COPY . .

# Run Composer install
RUN composer install

# Run Composer autoloader
RUN composer dump-autoload --no-scripts --optimize

# Set permissions for JWT keys
RUN mkdir -p config/jwt
RUN chown -R www-data:www-data config/jwt
RUN chmod -R ug+rwx config/jwt

COPY apache.conf /etc/apache2/sites-available/000-default.conf


FROM base

RUN php bin/console lexik:jwt:generate-keypair
RUN php bin/console assets:install

# Expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]
