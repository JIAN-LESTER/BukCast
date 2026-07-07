#!/bin/sh
set -e

php artisan migrate --force
php artisan db:seed --class=BukidnonLocationsSeeder --force
php artisan weather:store-forecasts

exec php artisan serve --host=0.0.0.0 --port=8000
