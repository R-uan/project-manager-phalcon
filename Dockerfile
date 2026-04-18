FROM php:8.2-fpm-bookworm

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# dependências para compilar phalcon + postgres
RUN apt-get update && apt-get install -y \
    git unzip libpcre2-dev gcc make autoconf pkg-config re2c \
    libpq-dev

# instalar extensões postgres
RUN docker-php-ext-install pdo_pgsql pgsql
RUN mkdir -p /var/www/cache && chown -R www-data:www-data /var/www/cache

# instalar phalcon
RUN git clone --depth=1 --branch v5.3.0 https://github.com/phalcon/cphalcon.git \
    && cd cphalcon/build \
    && ./install

RUN echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/phalcon.ini

WORKDIR /var/www