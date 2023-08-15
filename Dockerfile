#syntax=docker/dockerfile:1.4

FROM httpd:2.4-alpine3.14 AS local_httpd

ARG USER_ID
ARG GROUP_ID

#ENV PHP_XDEBUG_MODE ${PHP_XDEBUG_MODE:-"off"}
#ENV PHP_XDEBUG_IDEKEY ${PHP_XDEBUG_IDEKEY:-docker}
#ENV PHP_XDEBUG_CLIENT_HOST ${PHP_XDEBUG_CLIENT_HOST:-"gateway.docker.internal"}
#ENV PHP_XDEBUG_CLIENT_PORT ${PHP_XDEBUG_CLIENT_PORT:-9003}
#ENV PHP_XDEBUG_OUTPUT_DIR ${PHP_XDEBUG_PROFILER_OUTPUT_DIR:-"/tmp"}
#ENV PHP_XDEBUG_START_WITH_REQUEST ${PHP_XDEBUG_START_WITH_REQUEST:-"yes"}

RUN apk update && apk upgrade

RUN apk add php7 php7-apache2
RUN apk add php7-gd php7-zlib php7-curl php7-tokenizer php7-fileinfo php7-dom php7-xmlwriter php7-xml php7-session php7-pdo php7-pdo_mysql php7-pecl-xdebug
RUN apk add composer

RUN mv /etc/apache2/conf.d/php7-module.conf /usr/local/apache2/conf/extra/php7-module.conf
RUN mv /usr/lib/apache2/mod_php7.so /usr/local/apache2/modules/mod_php7.so

RUN sed '/mpm_prefork_module/s/^#//' -i /usr/local/apache2/conf/httpd.conf \
    && sed '/mpm_event_module/s/^/#/' -i /usr/local/apache2/conf/httpd.conf

RUN sed '/error_reporting/s/^/#/' -i /usr/local/apache2/conf/httpd.conf  \
    && sed '/^#error_reporting/a error_reporting= E_ALL' -i /etc/php7/php.ini \
    && sed '/^display_errors/s/Off/On/' -i /etc/php7/php.ini

RUN echo "Include conf/extra/php7-module.conf" >> /usr/local/apache2/conf/httpd.conf

#COPY ./docker/httpd/httpd.conf /usr/local/apache2/conf/httpd.conf
#COPY ./docker/httpd/httpd-vhosts.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf
#COPY ./docker/httpd/php/php.ini /etc/php7/php.ini
#COPY ./docker/httpd/php/xdebug.ini /etc/php7/conf.d/xdebug.ini

#RUN mkdir /app/logs --parents --mode=0777
RUN mkdir /app/httpd --parents --mode=0777

RUN addgroup --gid $GROUP_ID local
RUN adduser --disabled-password -u $USER_ID local -G local

WORKDIR /app/httpd

#USER local