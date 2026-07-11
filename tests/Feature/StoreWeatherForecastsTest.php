<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Snapshot;
use App\Models\WeatherReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class StoreWeatherForecastsTest extends TestCase
{
    use RefreshDatabase;

    public function test_refresh_replaces_old_data_and_remains_duplicate_free_when_rerun(): void
    {
        config(['services.openweather.key' => 'test-key']);
        $oldLocation = Location::create([
            'name' => 'Old test location', 'latitude' => 8.0, 'longitude' => 125.0,
        ]);
        $oldReport = WeatherReport::create([
            'locID' => $oldLocation->locID,
            'report_date' => now()->subDay()->toDateString(),
        ]);
        Snapshot::create(['wrID' => $oldReport->wrID, 'snapshots' => ['old' => []]]);

        $temperature = 20.0;
        Http::fake(function () use (&$temperature) {
            return Http::response($this->forecastResponse($temperature));
        });

        $this->artisan('weather:store-forecasts --refresh')->assertSuccessful();
        $locationCount = Location::count();
        $this->assertDatabaseMissing('weather_reports', ['wrID' => $oldReport->wrID]);

        $temperature = 31.5;
        $this->artisan('weather:store-forecasts --refresh')->assertSuccessful();

        $this->assertSame($locationCount, WeatherReport::count());
        $this->assertSame($locationCount, Snapshot::count());

        foreach (Snapshot::all() as $snapshot) {
            $this->assertSame(['auto_forecast'], array_keys($snapshot->snapshots));
            $forecast = $snapshot->snapshots['auto_forecast'];
            $this->assertSame('auto_forecast', $forecast['snapshot_identifier']);
            $this->assertSame(
                ['morning', 'noon', 'afternoon', 'evening'],
                array_keys($forecast['time_slots'])
            );
            $this->assertSame(31.5, $forecast['time_slots']['morning']['temperature']);
        }
    }

    public function test_failed_requests_leave_no_stale_or_incomplete_reports(): void
    {
        config(['services.openweather.key' => 'test-key']);
        Log::spy();
        $location = Location::create([
            'name' => 'Failed location', 'latitude' => 8.0, 'longitude' => 125.0,
        ]);
        $report = WeatherReport::create([
            'locID' => $location->locID,
            'report_date' => now()->subDay()->toDateString(),
        ]);
        Snapshot::create(['wrID' => $report->wrID, 'snapshots' => ['old' => []]]);
        Http::fake(fn () => Http::response([], 503));

        $this->artisan('weather:store-forecasts --refresh')->assertSuccessful();

        $this->assertSame(0, WeatherReport::count());
        $this->assertSame(0, Snapshot::count());
        Log::shouldHaveReceived('error')->withArgs(
            fn (string $message, array $context) =>
                $message === 'OpenWeatherMap API request failed' && $context['status'] === 503
        )->atLeast()->once();
    }

    private function forecastResponse(float $temperature): array
    {
        $entries = [];

        foreach ([6, 12, 15, 18] as $hour) {
            $entries[] = [
                'dt_txt' => now()->startOfDay()->addHours($hour)->format('Y-m-d H:i:s'),
                'main' => [
                    'temp' => $temperature, 'feels_like' => $temperature,
                    'humidity' => 80, 'pressure' => 1010,
                ],
                'weather' => [['main' => 'Clouds', 'description' => 'cloudy', 'icon' => '03d']],
                'wind' => ['speed' => 2.5, 'deg' => 90],
                'clouds' => ['all' => 50],
                'pop' => 0.2,
            ];
        }

        return ['list' => $entries];
    }
}
