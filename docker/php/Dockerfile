FROM php:8.2-apache

RUN echo "ServerName localhost" >> /etc/apache/apache2.conf

RUN apt-get update \
    && apt-get install -qq -y --no-install-recommends \
    cron \
    locales coreutils apt-utils git libicu-dev g++ libpng-dev libxml-dev libzlib-dev libonig-dev libxslt-dev;

RUN curl -sSk https://getcomposer.org/installer/ | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql mysqli gd intl zip calendar dom mbstring zip gd xsl && a2enmod rewrite
RUN pecl install apcu && docker-php-ext-enable apcu 

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

WORKDIR /var/www