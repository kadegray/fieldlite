FROM businesstools/nginx-php:1.9.3

# set our application folder as an environment variable
ENV APP_HOME /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

RUN apt-get update
# RUN apt-get upgrade -y --allow-unauthenticated

COPY default.conf /etc/nginx/conf.d/default.conf
COPY php.ini /usr/local/etc/php/conf.d/

# copy source files and run composer
COPY api $APP_HOME

WORKDIR $APP_HOME

# install all PHP dependencies
RUN composer install --no-interaction

# change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME

EXPOSE 80