# still used?

FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y apt-utils\
    && apt-get upgrade -y\
    && apt-get install -y apt-utils zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpng-dev libonig-dev\
    && docker-php-ext-install intl opcache pdo pdo_mysql gd mbstring bcmath\
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-enable gd \
    && docker-php-ext-enable bcmath

RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9050" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN ln -fs /usr/share/zoneinfo/Europe/Berlin /etc/localtime && \
     dpkg-reconfigure -f noninteractive tzdata

RUN apt-get install -y wkhtmltopdf

WORKDIR /var/www/menukarte

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "m.kittel@coolvegan.de" \
    && git config --global user.name "Marco Kittel"
