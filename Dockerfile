# PHP
FROM richarvey/nginx-php-fpm:3.1.6 AS LARAVEL_BUILD
COPY . .
# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1
# Laravel Deps
RUN ["composer install --no-dev --working-dir=/var/www/html"]
# Start
CMD ["/start.sh"]

# NODE
FROM node:lts-alpine AS INERTIA_BUILD
COPY . .
#Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
RUN ["npm install --no-dev --save"]
RUN ["npm run build"]
