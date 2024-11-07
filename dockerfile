# Usar una imagen base oficial de PHP
FROM php:8.2-fpm

# Instalar dependencias necesarias para ejecutar PHP con Lumen
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Configuración del directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiar los archivos de la aplicación al contenedor
COPY . .

# Instalar dependencias de PHP usando Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader

# Exponer el puerto en el que el servidor web PHP escuchará
EXPOSE 8080

# Comando que se ejecutará al iniciar el contenedor
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
