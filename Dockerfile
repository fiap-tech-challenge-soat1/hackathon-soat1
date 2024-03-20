FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
	gd \
	intl \
	zip \
	opcache

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /app

EXPOSE 8000

CMD ["php", "artisan", "octane:frankenphp", "--caddyfile", "/app/Caddyfile"]
