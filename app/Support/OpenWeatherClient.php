<?php

namespace App\Support;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class OpenWeatherClient
{
    public static function get(string $endpoint, array $query = [], int $timeout = 15): Response
    {
        $apiKey = config('services.openweather.key');

        if (!$apiKey) {
            throw new \Exception('OpenWeatherMap API key not configured');
        }

        $url = 'https://api.openweathermap.org/data/2.5/' . ltrim($endpoint, '/');

        try {
            return Http::withOptions(self::options())
                ->timeout($timeout)
                ->get($url, array_merge($query, [
                    'units' => 'metric',
                    'appid' => $apiKey,
                ]));
        } catch (ConnectionException $e) {
            throw new \Exception(self::sanitizeMessage($e->getMessage()), 0, $e);
        }
    }

    private static function options(): array
    {
        $caBundle = config('services.openweather.ca_bundle');

        if ($caBundle) {
            return ['verify' => $caBundle];
        }

        return ['verify' => (bool) config('services.openweather.verify_ssl')];
    }

    private static function sanitizeMessage(string $message): string
    {
        return preg_replace('/appid=[^&\s]+/', 'appid=[hidden]', $message);
    }
}
