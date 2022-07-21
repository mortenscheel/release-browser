FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN apt-get update && \
    apt-get install -y libzip-dev libpng-dev supervisor cron gosu && \
    docker-php-ext-install pdo_mysql bcmath zip sockets pcntl gd && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    docker-php-source delete && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN usermod -u 1000 www-data
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY cron /root/cron
RUN crontab -u www-data /root/cron
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN mkdir -p /var/www/.config/psysh && chown -R www-data:www-data /var/www/.config

ENTRYPOINT ["/entrypoint.sh"]
