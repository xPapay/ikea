FROM php:7.0-apache
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo pdo_mysql	

#arguments below will be overriden by docker-compose file
ARG SERVER_NAME=default
ARG DOCUMENT_ROOT=/var/www/html

#copy apache host file config
COPY default.conf /etc/apache2/sites-available/${SERVER_NAME}.conf

#enable site
RUN ln -s /etc/apache2/sites-available/${SERVER_NAME}.conf /etc/apache2/sites-enabled/${SERVER_NAME}.conf

#copy config_apache.sh script into image
COPY config_apache.sh /config_apache.sh

#set the config template
RUN /config_apache.sh && a2enmod rewrite
WORKDIR /var/www/html

RUN chmod 777 -R .

EXPOSE 80
CMD ["apache2-foreground"]
##</autogenerated>##