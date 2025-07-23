FROM php:8.2-apache

WORKDIR /var/www/html

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP necessárias para o Laravel
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd zip intl

# Habilita mod_rewrite do Apache
RUN a2enmod rewrite

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura o VirtualHost do Apache para Laravel
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# Adiciona ServerName para evitar warnings do Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Cria a estrutura de diretórios do Laravel com permissões corretas
# Essas permissões são importantes para o cache, sessions, logs, etc.
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

# Copia todo o conteúdo do Laravel para o container
# Esta linha deve vir depois da instalação de dependências para melhor aproveitamento do cache do Docker
COPY . .

# Configura permissões finais para o Laravel
# Garante que o Apache (www-data) possa ler e escrever nos diretórios necessários
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/html/storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Comando para iniciar o Apache (já é o default da imagem base php:apache)
# CMD ["apache2-foreground"]