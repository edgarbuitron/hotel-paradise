FROM php:8.1-apache

# Copiar todo al directorio web
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
