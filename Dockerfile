FROM php:8.1-apache

# Copiar archivos al directorio del servidor web
COPY public/ /var/www/html/
COPY includes/ /var/www/html/includes/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html
