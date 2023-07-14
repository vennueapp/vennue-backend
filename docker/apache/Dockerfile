# Versioning arguments
ARG APACHE_VERSION
ARG ALPINE_VERSION
FROM httpd:${APACHE_VERSION}-alpine${ALPINE_VERSION}

# Use root user for setup
USER root

# Install Laravel and Apache packages
ARG PHP_PACKAGES_VERSION
RUN apk add --no-cache \
    php${PHP_PACKAGES_VERSION} \
    php${PHP_PACKAGES_VERSION}-ctype \
    php${PHP_PACKAGES_VERSION}-curl \
    php${PHP_PACKAGES_VERSION}-dom \
    php${PHP_PACKAGES_VERSION}-fileinfo \
    php${PHP_PACKAGES_VERSION}-mbstring \
    php${PHP_PACKAGES_VERSION}-openssl \
    php${PHP_PACKAGES_VERSION}-pdo \
    php${PHP_PACKAGES_VERSION}-pdo_mysql \
    php${PHP_PACKAGES_VERSION}-session \
    php${PHP_PACKAGES_VERSION}-tokenizer \
    php${PHP_PACKAGES_VERSION}-xml

# Configure Apache
COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf

# TODO Copy in hardened php.ini

# Set working directory
ARG WORKDIR
WORKDIR ${WORKDIR}

# Create and use new user to match host
RUN addgroup -g 1000 apache && adduser -u 1000 -G apache -D apache
ENV APACHE_RUN_USER=apache
ENV APACHE_RUN_GROUP=apache
USER apache

# Start service
CMD ["apachectl", "-D", "FOREGROUND", "-C", "PidFile /tmp/httpd.pid"]
