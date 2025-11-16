FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# CREAR index.php FUNCIONAL en raíz
RUN echo '<?php echo "<!DOCTYPE html><html lang=\"es\"><head><meta charset=\"UTF-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><title>Hotel Paradise</title><link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\"><link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\"></head><body style=\"background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;\"><div class=\"container\"><div class=\"row justify-content-center align-items-center\" style=\"min-height: 100vh;\"><div class=\"col-md-6 text-center text-white\"><h1><i class=\"fas fa-hotel fa-3x mb-4\"></i></h1><h2 class=\"mb-3\">Hotel Paradise Cancún</h2><p class=\"lead mb-4\">Sistema funcionando correctamente</p><div class=\"d-grid gap-3\"><a href=\"public/index.php\" class=\"btn btn-light btn-lg\"><i class=\"fas fa-home me-2\"></i>Ir al Sitio Público</a><a href=\"admin/login.php\" class=\"btn btn-outline-light btn-lg\"><i class=\"fas fa-lock me-2\"></i>Administración</a></div></div></div></div></body></html>"; ?>' > /var/www/html/index.php

# VERIFICAR archivos
RUN echo "=== ARCHIVOS PHP ===" && find /var/www/html -name "*.php" | head -10

# Configurar Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
