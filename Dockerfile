FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar el código al contenedor
COPY . /var/www/html/

# Configurar Apache para usar la carpeta public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Puerto expuesto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
