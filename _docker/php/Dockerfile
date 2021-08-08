ARG PHP_TAG

FROM php:${PHP_TAG}-fpm-alpine

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini \
  && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
  && apk add --update --no-cache \
    htop \
    git \
    libzip-dev \
    mysql-client \
    icu \
    icu-dev \
    libintl \
  && pecl install \
    xdebug-3.0.3 \
  && docker-php-ext-enable \
    xdebug \
  && docker-php-ext-install \
    exif \
    zip \
    pdo_mysql \
    pcntl \
    intl \
  && apk del -f .build-deps \
  && echo ' ==> Main layer build done <=='

# Add composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add Init data
COPY ./ /tmp/init_data

# Add Mozilla CAcert bundle
RUN curl -s https://curl.haxx.se/ca/cacert.pem >> /tmp/init_data/cacert.pem

# Use Init data
RUN cp /tmp/init_data/php/config.ini /usr/local/etc/php/conf.d/config.ini \
  && cp /tmp/init_data/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini \
  && rm -rf /tmp/init_data
