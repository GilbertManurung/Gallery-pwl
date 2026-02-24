FROM dunglas/frankenphp:php8.4

# Install PHP extensions termasuk GD dan Imagick
RUN install-php-extensions \
    pdo_pgsql \
    opcache \
    gd \
    imagick

# Install PostgreSQL client permanen
RUN apt-get update && apt-get install -y postgresql-client && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .

CMD ["frankenphp", "run", "--config", "/app/docker/Caddyfile"]
