web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:restart && php artisan queue:listen --tries=3 --timeout=60