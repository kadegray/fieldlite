FROM businesstools/nginx-php:1.9.3

# set our application folder as an environment variable
ENV APP_HOME /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

RUN apt-get update
# RUN apt-get upgrade -y --allow-unauthenticated

COPY default.conf /etc/nginx/conf.d/default.conf
COPY php.ini /usr/local/etc/php/conf.d/

WORKDIR $APP_HOME

RUN composer install

# change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME

EXPOSE 9000