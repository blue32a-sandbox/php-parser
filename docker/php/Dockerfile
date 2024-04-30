FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y \
        git \
        zip \
        unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
