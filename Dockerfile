FROM php:8.2-fpm-alpine

RUN apk --no-cache update && apk --no-cache add bash git

RUN docker-php-ext-install pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && php -r "unlink('composer-setup.php');" && mv composer.phar /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mkdir -p /root/.config \
    && mv /root/.symfony5 /root/.config/symfony-cli \
    && mv /root/.config/symfony-cli/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html