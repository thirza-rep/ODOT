FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/admin admin
RUN mkdir -p /home/admin/.composer && \
    chown -R admin:admin /home/admin

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
RUN chown -R www-data:www-data /var/www/html

# Switch to standard user
USER admin

# Install PHP and Node dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

USER root
RUN chown -R www-data:www-data /var/www/html/public/build
USER admin

EXPOSE 9000
CMD ["php-fpm"]
