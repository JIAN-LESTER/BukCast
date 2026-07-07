<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function show()
    {

        $locations = Location::all();
        return view('user.maps', [
            'googleKey' => config('services.google_maps.key'),
            'openweatherKey' => config('services.openweather.key'),
            'locations' => $locations,
        ]);
    }

    public function viewMaps(Request $request)
    {

         $locations = Location::all();
        return view('user.maps', [
            'googleKey' => config('services.google_maps.key'),
            'openweatherKey' => config('services.openweather.key'),
            'locations' => $locations,
        ]);
    }
}
