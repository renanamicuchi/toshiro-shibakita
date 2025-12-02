FROM php:8.1-apache

# Atualiza e instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Ativa módulo rewrite para rotas
RUN a2enmod rewrite

# Define o diretório principal
WORKDIR /var/www/html

# Copia arquivos
COPY . .

# Permissão correta
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
