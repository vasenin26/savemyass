#syntax=docker/dockerfile:1.4

FROM httpd:2.4-alpine3.18 AS local_httpd

ARG USER_ID
ARG GROUP_ID
ARG XDEBUG_CLIENT_HOST
ARG XDEBUG_CLIENT_PORT

RUN apk update && apk upgrade

RUN apk add php81 \
    php81-apache2 \
    php81-curl \
    php81-fileinfo  \
    php81-tokenizer  \
    php81-pecl-xdebug  \
    php81-dom  \
    php81-xmlwriter  \
    php81-xml  \
    php81-session

RUN apk add composer

RUN mv /etc/apache2/conf.d/php81-module.conf /usr/local/apache2/conf/extra/php81-module.conf
RUN mv /usr/lib/apache2/mod_php81.so /usr/local/apache2/modules/mod_php81.so

RUN sed '/mpm_prefork_module/s/^#//' -i /usr/local/apache2/conf/httpd.conf \
    && sed '/mpm_event_module/s/^/#/' -i /usr/local/apache2/conf/httpd.conf \
    && sed '/rewrite_module/s/^#//' -i /usr/local/apache2/conf/httpd.conf \
    && sed '/AllowOverride/s/None/All/' -i /usr/local/apache2/conf/httpd.conf \
    && sed 's/www-data/local/' -i /usr/local/apache2/conf/httpd.conf \
    && sed '/^Listen 80/s/80/8080/' -i /usr/local/apache2/conf/httpd.conf \
    && sed 's%/usr/local/apache2/htdocs%/app/httpd/public%' -i /usr/local/apache2/conf/httpd.conf \
    && echo "Include conf/extra/php81-module.conf" >> /usr/local/apache2/conf/httpd.conf

RUN sed '/error_reporting/s/^/#/' -i /etc/php81/php.ini  \
    && sed '/^#error_reporting/a error_reporting= E_ALL' -i /etc/php81/php.ini \
    && sed '/^display_errors/s/Off/On/' -i /etc/php81/php.ini

RUN printf " \
zend_extension=xdebug.so \n \
xdebug.mode=debug \n \
xdebug.start_with_request=yes \n \
xdebug.client_host=${XDEBUG_CLIENT_HOST} \n \
xdebug.client_post=${XDEBUG_CLIENT_PORT} \n \
xdebug.server_name=savemyass \n \
\n" >> /etc/php81/conf.d/50_xdebug.ini

RUN mkdir /app/httpd --parents --mode=0777

RUN addgroup --gid $GROUP_ID local
RUN adduser --disabled-password -u $USER_ID local -G local

WORKDIR /app/httpd