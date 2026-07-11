<?php

namespace Tests\Feature;

use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

class WeatherScheduleTest extends TestCase
{
    public function test_the_six_am_refresh_is_scheduled_once_without_overlap(): void
    {
        $events = collect($this->app->make(Schedule::class)->events())
            ->filter(fn ($event) => str_contains($event->command ?? '', 'weather:store-forecasts --refresh'));

        $this->assertCount(1, $events);

        $event = $events->first();
        $this->assertSame('0 6 * * *', $event->expression);
        $this->assertSame('Asia/Manila', $event->timezone);
        $this->assertSame('refresh-weather-forecasts', $event->description);
        $this->assertTrue($event->withoutOverlapping);
    }
}
