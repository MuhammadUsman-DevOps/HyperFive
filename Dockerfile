# Use the official PHP image with FPM
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install wait-for-it script
RUN curl -sS https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh -o /usr/local/bin/wait-for-it && \
    chmod +x /usr/local/bin/wait-for-it

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the current directory contents into the container
COPY . .

# Install the project dependencies
RUN composer install

# Expose port 8000
EXPOSE 8000

# Run the migration, then start PHP server
CMD /usr/local/bin/wait-for-it db:3306 -- php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000
