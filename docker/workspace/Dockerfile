# Versioning arguments
ARG ALPINE_VERSION
ARG COMPOSER_VERSION

# Prepare Composer multi stage build
FROM composer:${COMPOSER_VERSION} as composer
FROM alpine:${ALPINE_VERSION}

# Use root user for setup
USER root

# Copy Composer in from official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install Laravel packages
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
    php${PHP_PACKAGES_VERSION}-phar \
    php${PHP_PACKAGES_VERSION}-session \
    php${PHP_PACKAGES_VERSION}-tokenizer \
    php${PHP_PACKAGES_VERSION}-xml \
    php${PHP_PACKAGES_VERSION}-xmlwriter

# Set working directory
ARG WORKDIR
WORKDIR ${WORKDIR}

# Create and use new user to match host
RUN addgroup -g 1000 workspace && adduser -u 1000 -G workspace -D workspace
USER workspace
