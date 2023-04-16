# Version argument
ARG MYSQL_VERSION
FROM mysql:${MYSQL_VERSION}

# Set timezone to UTC
RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && echo UTC > /etc/timezone
