#!/bin/sh
set -e

php artisan migrate --force
php artisan db:seed --class=BukidnonLocationsSeeder --force || true
php artisan weather:store-forecasts || true
php artisan schedule:work >> storage/logs/scheduler.log 2>&1 &

exec php artisan serve --host=0.0.0.0 --port=8000
