FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Define build arguments
ARG user=composer
ARG uid=1000

# Install system dependencies and PHP extensions in a single RUN step
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    ffmpeg \
    unzip && \
    docker-php-ext-install pdo pdo_mysql && \
    rm -rf /var/lib/apt/lists/*

# Ensure proper ownership and permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www

# Copy custom php.ini configuration
COPY php.ini /usr/local/etc/php/

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create a user and set permissions
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Optionally set the user for the container (if running as a non-root user is desired)
# USER $user
