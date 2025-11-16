FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# CREAR index.php si no existe
RUN if [ ! -f "/var/www/html/index.php" ]; then \
    echo '<?php header("Location: public/index.php"); exit(); ?>' > /var/www/html/index.php; \
    fi

# DIAGNÓSTICO
RUN echo "=== VERIFICACIÓN ===" && \
    echo "Archivos en raíz:" && ls -la /var/www/html/ | head -10 && \
    echo "¿Existe index.php?" && ls -la /var/www/html/index.php 2>/dev/null || echo "NO existe index.php" && \
    echo "¿Existe public/?" && ls -la /var/www/html/public/ 2>/dev/null | head -5 || echo "NO existe public/"

# Configurar Apache para RAÍZ
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Forzar index.php
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
