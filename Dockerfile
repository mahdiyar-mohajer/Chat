FROM php:8.2-apache
RUN docker-php-ext-install pdo pdo_mysql
#RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
#RUN #pecl install redis && docker-php-ext-enable redis