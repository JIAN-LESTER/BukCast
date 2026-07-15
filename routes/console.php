<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('weather:store-forecasts --refresh')
    ->dailyAt('6:00')
    ->timezone('Asia/Manila')
    ->withoutOverlapping()
    ->name('refresh-weather-forecasts');
