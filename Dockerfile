FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# DIAGNÓSTICO COMPLETO
RUN echo "=== DIAGNÓSTICO INICIO ==="
RUN echo "1. LISTANDO RAÍZ:" && ls -la /var/www/html/
RUN echo "2. ¿EXISTE PUBLIC?:" && ls -la /var/www/html/public/ 2>/dev/null || echo "NO EXISTE public/"
RUN echo "3. CONTENIDO DE PUBLIC:" && ls -la /var/www/html/public/ 2>/dev/null || echo "No se puede listar public"
RUN echo "4. BUSCANDO INDEX.PHP:" && find /var/www/html -name "index.php" 2>/dev/null | head -10
RUN echo "=== DIAGNÓSTICO FIN ==="

# Configurar Apache para usar PUBLIC como document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
