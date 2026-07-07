    <?php

    use App\Http\Controllers\AlertController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\EmailVerificationController;
    use App\Http\Controllers\LogsController;
    use App\Http\Controllers\ProfileController;

    use App\Http\Controllers\TwoFactorAuthController;
    use App\Http\Controllers\UserManagementController;
    use App\Http\Controllers\WeatherController;
    use App\Http\Controllers\WeatherReportsController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\MapsController;

    Route::get('/', [DashboardController::class, 'viewDashboard'])->name('home');
    Route::get('/login', fn () => redirect()->route('dashboard'))->name('loginForm');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', fn () => redirect()->route('dashboard'))->name('registerForm');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    Route::get('/dashboard', [DashboardController::class, 'viewDashboard'])->name('dashboard');
    Route::get('/admin/dashboard', fn () => redirect()->route('dashboard'))->name('admin.dashboard');

    Route::get('/user/dashboard', [DashboardController::class, 'viewDashboard'])->name('user.dashboard');


    Route::group([], function () {
        Route::get('/map', [MapsController::class, 'show'])->name('map.show');
        Route::get('/weather_reports', [WeatherReportsController::class, 'viewWeatherReports'])->name('weather_reports.show');
        Route::get('/weather-reports', [WeatherReportsController::class, 'viewWeatherReports']);

        Route::get('/user/map', [MapsController::class, 'show'])->name('user.map.show');
        Route::get('/user/weather_reports', [WeatherReportsController::class, 'viewWeatherReports'])->name('user.weather_reports.show');
    });

    Route::prefix('admin/user_crud')->name('admin.')->group(function () {
        Route::fallback(fn () => redirect()->route('dashboard'));
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.profile');
        Route::get('/profile/edit/{userID}', [ProfileController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    });

    Route::middleware(['auth'])->group(function () {
        // Main weather storage route (JSON-based for full day snapshots)
        Route::post('/weather/store-full-day-snapshots', [WeatherController::class, 'storeFullDayForecastSnapshots'])
            ->name('weather.store-full-day-snapshots');
        
        // Single time period storage (for "Save Current Time" functionality)
        Route::post('/weather/store-current-snapshot', [WeatherController::class, 'storeCurrentTimeSnapshot'])
            ->name('weather.store-current-snapshot');
        
        // Data retrieval routes
        Route::get('/weather/todays-snapshots', [WeatherController::class, 'getTodaysWeatherSnapshots'])
            ->name('weather.todays-snapshots');
        
        Route::get('/weather/location-history/{locID}', [WeatherController::class, 'getLocationWeatherHistory'])
            ->name('weather.location-history');
    });

   

    Route::middleware(['auth'])->group(function () {
        // Store forecasts NOW (instant storage)
        Route::post('/weather-reports/store-now', [WeatherReportsController::class, 'storeNow'])
            ->name('weather_reports.store_now');
        
        // Manual cleanup endpoint
        Route::post('/weather-reports/cleanup', [WeatherReportsController::class, 'triggerCleanup'])
            ->name('weather_reports.cleanup');
        
        // Delete specific snapshot
        Route::delete('/weather-reports/snapshots/{snapshotID}', [WeatherReportsController::class, 'deleteSnapshot'])
            ->name('weather_reports.delete_snapshot');
    });

    // API endpoints for real-time data
    Route::prefix('api/weather')->group(function () {
        Route::get('/location/{locID}/current/{period?}', [WeatherReportsController::class, 'getRealTimeWeather'])
            ->name('api.weather.current_period');
    });

    // Add this route to your routes/web.php
Route::post('/weather-reports/refresh-all', [WeatherReportsController::class, 'refreshAll'])
    ->name('weather.refresh.all');





// Web routes for alert pages (if you need them)
Route::middleware(['auth'])->group(function () {
    Route::get('/alerts/location/{locID}', function ($locID) {
        $location = \App\Models\Location::findOrFail($locID);
        return view('alerts.location', ['location' => $location]);
    })->name('alerts.location');
});
