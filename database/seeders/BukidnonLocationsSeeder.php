<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class BukidnonLocationsSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Baungon, Bukidnon', 'latitude' => 8.3125, 'longitude' => 124.6871],
            ['name' => 'Cabanglasan, Bukidnon', 'latitude' => 8.0765, 'longitude' => 125.3011],
            ['name' => 'Damulog, Bukidnon', 'latitude' => 7.4813, 'longitude' => 124.9388],
            ['name' => 'Dangcagan, Bukidnon', 'latitude' => 7.6099, 'longitude' => 125.0041],
            ['name' => 'Don Carlos, Bukidnon', 'latitude' => 7.6838, 'longitude' => 124.9946],
            ['name' => 'Impasugong, Bukidnon', 'latitude' => 8.3033, 'longitude' => 125.0008],
            ['name' => 'Kadingilan, Bukidnon', 'latitude' => 7.6001, 'longitude' => 124.9099],
            ['name' => 'Kalilangan, Bukidnon', 'latitude' => 7.7468, 'longitude' => 124.7480],
            ['name' => 'Kibawe, Bukidnon', 'latitude' => 7.5678, 'longitude' => 124.9903],
            ['name' => 'Kitaotao, Bukidnon', 'latitude' => 7.6390, 'longitude' => 125.0074],
            ['name' => 'Lantapan, Bukidnon', 'latitude' => 8.0262, 'longitude' => 124.9880],
            ['name' => 'Libona, Bukidnon', 'latitude' => 8.3346, 'longitude' => 124.7435],
            ['name' => 'Malaybalay City, Bukidnon', 'latitude' => 8.1553, 'longitude' => 125.1304],
            ['name' => 'Malitbog, Bukidnon', 'latitude' => 8.5363, 'longitude' => 124.8792],
            ['name' => 'Manolo Fortich, Bukidnon', 'latitude' => 8.3659, 'longitude' => 124.8637],
            ['name' => 'Maramag, Bukidnon', 'latitude' => 7.7611, 'longitude' => 125.0047],
            ['name' => 'Pangantucan, Bukidnon', 'latitude' => 7.8322, 'longitude' => 124.8282],
            ['name' => 'Quezon, Bukidnon', 'latitude' => 7.7309, 'longitude' => 125.1000],
            ['name' => 'San Fernando, Bukidnon', 'latitude' => 7.9168, 'longitude' => 125.3287],
            ['name' => 'Sumilao, Bukidnon', 'latitude' => 8.3270, 'longitude' => 124.9779],
            ['name' => 'Talakag, Bukidnon', 'latitude' => 8.2322, 'longitude' => 124.6035],
            ['name' => 'Valencia City, Bukidnon', 'latitude' => 7.9028, 'longitude' => 125.0898],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['name' => $location['name']],
                [
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                ]
            );
        }
    }
}
