FROM dunglas/frankenphp

# Install the necessary tools and extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    iputils-ping \
    && docker-php-ext-install pdo_pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis

# Install redis-cli
RUN apt-get install -y redis-tools

# Clean up to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
