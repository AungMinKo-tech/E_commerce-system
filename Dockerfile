FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev

# Install Node.js (Version 20)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# PHP Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# NPM install & Build assets (CSS ပေါ်ဖို့အတွက်)
# အကယ်၍ npm build error တက်ရင် ဒီ line ကို ခဏပိတ်ထားနိုင်ပါတယ်
RUN npm install && npm run build

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
