FROM php:7.2-alpine

RUN apk add --update --no-cache curl zlib-dev autoconf pcre-dev ${PHPIZE_DEPS}
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN apk del pcre-dev ${PHPIZE_DEPS}
COPY ./.docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN mv composer.phar /usr/bin/composer
RUN php -r "unlink('composer-setup.php');"
