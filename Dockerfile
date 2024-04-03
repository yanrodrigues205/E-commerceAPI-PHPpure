FROM php:8.0-apache

# habilita modulos do apache
RUN a2enmod rewrite

# instalando dependencias do php
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# configurando modulo gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# instalando modulos do php
RUN docker-php-ext-install -j$(nproc) gd pdo_mysql mysqli

# copiando arquivos para a pasta do apache
COPY . /var/www/html/

# diretorido de trabalho
WORKDIR /var/www/html

#porta 80
EXPOSE 80

# iniciando servidor apache
CMD ["apache2-foreground"]