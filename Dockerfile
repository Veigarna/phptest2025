FROM php:8.2-apache

# Asenna tarvittavat PHP-laajennukset
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ota käyttöön Apache rewrite-moduuli (jos käytät URL-rewriteä)
RUN a2enmod rewrite

# Kopioi tiedostot konttiin
COPY . /var/www/html/

# Aseta työskentelykansio
WORKDIR /var/www/html/

# Asenna Composer ja riippuvuudet
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

# Aseta oikeudet
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
