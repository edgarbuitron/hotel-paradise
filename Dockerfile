FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# Configurar Apache para servir desde la raíz directamente
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Crear .htaccess en raíz para redirecciones
RUN echo "RewriteEngine On" > /var/www/html/.htaccess
RUN echo "RewriteCond %{REQUEST_FILENAME} !-f" >> /var/www/html/.htaccess
RUN echo "RewriteCond %{REQUEST_FILENAME} !-d" >> /var/www/html/.htaccess
RUN echo "RewriteRule ^(.*)$ index.php [QSA,L]" >> /var/www/html/.htaccess

# Permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
