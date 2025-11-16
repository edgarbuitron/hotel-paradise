FROM php:8.1-apache

# Copiar el contenido de public al directorio web de Apache
COPY public/ /var/www/html/

# Copiar includes al directorio web
COPY includes/ /var/www/html/includes/

# Copiar admin (si quieres acceder vía web)
COPY admin/ /var/www/html/admin/

# Copiar imágenes
COPY imagenes/ /var/www/html/imagenes/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
