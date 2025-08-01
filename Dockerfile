FROM php:8.2-apache

# Asenna tarvittavat paketit Composerin käyttöön
RUN apt-get update && apt-get install -y zip unzip git

# Asenna PHP-laajennukset
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ota rewrite käyttöön
RUN a2enmod rewrite

# Kopioi Composer virallisesta imagesta
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Kopioi vain composer-tiedostot ensin
COPY composer.json composer.lock /var/www/html/

WORKDIR /var/www/html/

# Varmista composer validointi ja asennus
RUN composer validate --strict
RUN composer install --no-dev --optimize-autoloader

# Kopioi loput tiedostot vasta sen jälkeen
COPY . /var/www/html/

# Aseta oikeudet
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
