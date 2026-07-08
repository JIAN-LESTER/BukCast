@extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="w-full max-w-8xl mx-auto px-3 sm:px-4 lg:px-6">

    <div class="relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 sm:p-5 md:p-6 mb-4 sm:mb-5 shadow-sm">
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3">
            <div class="flex-1 min-w-0">
                <div class="inline-flex items-center gap-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 text-[11px] sm:text-xs font-semibold mb-2">
                    <i class="fas fa-cloud-sun"></i>
                    <span>Live weather overview</span>
                </div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                    Welcome to BukCast
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    Current conditions, forecast changes, and safety alerts in one place.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-2 w-full sm:w-auto">
                <div class="rounded-lg bg-white dark:bg-gray-800 px-3 py-2 border border-gray-200 dark:border-gray-700">
                    <div class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 font-medium">Status</div>
                    <div class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Monitoring</div>
                </div>
                <div class="rounded-lg bg-white dark:bg-gray-800 px-3 py-2 border border-gray-200 dark:border-gray-700">
                    <div class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 font-medium">Alerts</div>
                    <div id="alertHeroCount" class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Checking</div>
                </div>
            </div>
        </div>
    </div>

    <!-- WEATHER ALERTS SECTION -->
    <div id="weatherAlerts" class="mb-3 sm:mb-4">
        <!-- Alert Summary Banner -->
        <div id="alertSummaryBanner" class="hidden mb-3 sm:mb-4 rounded-lg sm:rounded-xl overflow-hidden shadow-lg">
            <!-- Content will be injected dynamically -->
        </div>

        <!-- Detailed Alerts -->
        <div id="alertsList" class="hidden space-y-2 sm:space-y-3">
            <!-- Alerts will be injected here -->
        </div>

        <div id="allClearBanner" class="hidden rounded-xl border border-emerald-200 dark:border-emerald-900/50 bg-emerald-50 dark:bg-emerald-900/20 p-3 sm:p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-circle-check"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-sm sm:text-base font-bold text-emerald-900 dark:text-emerald-100">No active weather alerts</h3>
                    <p class="text-xs sm:text-sm text-emerald-700 dark:text-emerald-300 truncate">Conditions look stable for your current area.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="weatherDashboard" class="w-full overflow-hidden">
    
        <div id="loadingState" class="space-y-3 sm:space-y-4" aria-busy="true">
            <div class="dashboard-card p-3 sm:p-4">
                <div class="flex items-center gap-3">
                    <div class="skeleton-circle h-10 w-10"></div>
                    <div class="space-y-2 flex-1">
                        <div class="skeleton-bar h-4 w-40"></div>
                        <div class="skeleton-bar h-3 w-56 max-w-full"></div>
                    </div>
                    <div class="hidden sm:block skeleton-bar h-8 w-24"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-2 sm:gap-3 md:gap-4">
                <div class="dashboard-card p-4 sm:p-5 md:p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div class="space-y-2 flex-1">
                            <div class="skeleton-bar h-4 w-44"></div>
                            <div class="skeleton-bar h-3 w-32"></div>
                        </div>
                        <div class="skeleton-circle h-10 w-10"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="skeleton-circle h-16 w-16 sm:h-20 sm:w-20"></div>
                        <div class="space-y-3 flex-1">
                            <div class="skeleton-bar h-8 sm:h-10 w-28"></div>
                            <div class="skeleton-bar h-3 w-36"></div>
                            <div class="skeleton-bar h-3 w-28"></div>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card p-4 sm:p-5 md:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="skeleton-bar h-5 w-36"></div>
                        <div class="skeleton-circle h-9 w-9"></div>
                    </div>
                    <div class="space-y-3">
                        <div class="skeleton-block h-24"></div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="skeleton-block h-20"></div>
                            <div class="skeleton-block h-20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-card p-3 sm:p-4 md:p-5">
                <div class="skeleton-bar h-5 w-44 mb-4"></div>
                <div class="flex gap-2 sm:gap-3 overflow-hidden">
                    @for($i = 0; $i < 8; $i++)
                        <div class="skeleton-block h-28 w-20 sm:w-24 md:w-28 flex-shrink-0"></div>
                    @endfor
                </div>
            </div>
            <div class="dashboard-card p-3 sm:p-4 md:p-5">
                <div class="skeleton-bar h-5 w-36 mb-4"></div>
                <div class="space-y-2 sm:space-y-3">
                    @for($i = 0; $i < 5; $i++)
                        <div class="flex items-center gap-3 rounded-lg">
                            <div class="skeleton-bar h-4 w-14"></div>
                            <div class="skeleton-circle h-9 w-9"></div>
                            <div class="space-y-2 flex-1">
                                <div class="skeleton-bar h-4 w-36 max-w-full"></div>
                                <div class="skeleton-bar h-3 w-20"></div>
                            </div>
                            <div class="skeleton-bar h-6 w-14"></div>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3">
                @for($i = 0; $i < 4; $i++)
                    <div class="dashboard-card p-3 sm:p-4">
                        <div class="skeleton-bar h-3 w-20 mb-4"></div>
                        <div class="skeleton-bar h-6 w-24 mb-2"></div>
                        <div class="skeleton-bar h-3 w-28"></div>
                    </div>
                @endfor
            </div>
        </div>

        <div id="weatherContent" class="hidden space-y-2 sm:space-y-3 md:space-y-4 w-full">
        
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-2 sm:gap-3 md:gap-4">
             
                <div class="dashboard-panel p-4 sm:p-5 md:p-6 w-full overflow-hidden">
             
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 sm:mb-4 pb-2 sm:pb-3 border-b border-gray-200 dark:border-gray-600 gap-2">
                        <div class="w-full sm:w-auto min-w-0 flex-1">
                            <div class="flex items-center text-gray-700 dark:text-gray-300 text-xs sm:text-sm mb-1">
                                <i class="fas fa-map-marker-alt mr-1 sm:mr-1.5 text-blue-500 dark:text-blue-400 text-xs flex-shrink-0"></i>
                                <span id="location" class="font-bold text-gray-900 dark:text-white truncate">Loading location...</span>
                            </div>
                            <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs">
                                <span id="currentDay" class="font-medium"></span>
                                <span class="mx-1 sm:mx-1.5 hidden sm:inline">•</span>
                                <span id="currentDate" class="block sm:inline mt-0.5 sm:mt-0"></span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1 sm:space-x-1.5 text-red-800 dark:text-gray-400 text-xs sm:text-sm flex-shrink-0">
                            <i class="fas fa-temperature-high text-red-500 text-xs"></i>
                            <i class="fas fa-snowflake text-blue-400 text-xs"></i>
                        </div>
                    </div>

             
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-2 sm:space-y-0 gap-3">
                        <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4 w-full sm:w-auto">
                            <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl flex-shrink-0" id="mainWeatherIcon">
                                <i class="fas fa-cloud-rain text-blue-500 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 dark:text-white" id="mainTemp">25°</div>
                                <div class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm md:text-base" id="feelsLike">Feels like 28°</div>
                                <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs md:text-sm mt-0.5 sm:mt-1" id="tempRange">H: 30° L: 20°</div>
                            </div>
                        </div>
                        
                        <div class="text-left sm:text-right w-full sm:w-auto">
                            <p id="weatherDescription" class="text-sm sm:text-base md:text-lg text-gray-800 dark:text-gray-200 capitalize mb-0.5 sm:mb-1">Heavy Rain</p>
                            <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs" id="current-date-display"></div>
                        </div>
                    </div>
                </div>

              
                <div class="dashboard-panel p-4 sm:p-5 md:p-6 w-full overflow-hidden">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h3 class="section-title text-gray-900 dark:text-white">Precipitation</h3>
                        <i class="fas fa-cloud-rain text-blue-500 dark:text-blue-400 text-sm sm:text-base md:text-lg"></i>
                    </div>

                    <div class="space-y-2 sm:space-y-3">
                        <div class="metric-card p-3 md:p-4">
                            <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                                <span class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-medium">Rain Chance</span>
                                <i class="fas fa-tint text-blue-500 dark:text-blue-400 text-xs sm:text-sm"></i>
                            </div>
                            <div class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                                <span id="rainChance">90</span><span class="text-sm sm:text-base">%</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <div class="metric-card p-2.5 md:p-3">
                                <div class="flex items-center justify-between mb-1 sm:mb-1.5">
                                    <span class="text-gray-700 dark:text-gray-300 text-[10px] sm:text-xs">Rainfall</span>
                                    <i class="fas fa-cloud-rain text-blue-500 dark:text-blue-400 text-[10px] sm:text-xs"></i>
                                </div>
                                <div class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 dark:text-white">
                                    <span id="rainfall">2.5</span> <span class="text-[10px] sm:text-xs font-normal">mm/h</span>
                                </div>
                            </div>

                            <div class="metric-card p-2.5 md:p-3">
                                <div class="flex items-center justify-between mb-1 sm:mb-1.5">
                                    <span class="text-gray-700 dark:text-gray-300 text-[10px] sm:text-xs">Humidity</span>
                                    <i class="fas fa-water text-blue-500 dark:text-blue-400 text-[10px] sm:text-xs"></i>
                                </div>
                                <div class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 dark:text-white">
                                    <span id="humidity">85</span><span class="text-[10px] sm:text-xs">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


          <div class="dashboard-panel p-3 sm:p-4 md:p-5 w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-3 md:mb-4">
                    <h3 class="section-title text-gray-900 dark:text-white mb-1 sm:mb-0">Today's Hourly Forecast</h3>
                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-1 sm:hidden">
                        <i class="fas fa-hand-pointer text-blue-500"></i>
                        <span>Swipe to see more</span>
                    </div>
                </div>

                <div class="relative">
                    <div id="hourlyForecast" class="overflow-x-auto overflow-y-hidden scrollbar-thin scroll-smooth pb-2" style="touch-action: pan-x;">
                        <div class="flex space-x-1.5 sm:space-x-2 md:space-x-3"></div>
                    </div>
                </div>
            </div>
        
            <div class="dashboard-panel p-3 sm:p-4 md:p-5 w-full overflow-hidden">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-3 md:mb-4">
                    <h3 class="section-title text-gray-900 dark:text-white mb-1 sm:mb-0">5-Day Forecast</h3>
                </div>

                <div id="dailyForecast" class="space-y-1.5 sm:space-y-2 md:space-y-3"></div>
            </div>

       
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-1.5 sm:gap-2 md:gap-3">
             
                <div class="dashboard-panel stat-card p-3 md:p-4 w-full overflow-hidden">
                    <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                        <span class="stat-title text-gray-800 dark:text-gray-200 truncate">Wind Status</span>
                        <i class="fas fa-wind text-green-500 dark:text-green-400 text-xs sm:text-sm flex-shrink-0"></i>
                    </div>
                    <div class="text-base sm:text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-0.5 sm:mb-1">
                        <span id="windSpeed">7.9</span> <span class="text-[10px] sm:text-xs md:text-sm font-normal">km/h</span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs truncate">
                        <span id="windDirection">SW</span> • <span id="windGust">12.5 km/h</span> gusts
                    </div>
                </div>

            
                <div class="dashboard-panel stat-card p-3 md:p-4 w-full overflow-hidden">
                    <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                        <span class="stat-title text-gray-800 dark:text-gray-200">UV Index</span>
                        <i class="fas fa-sun text-yellow-500 dark:text-yellow-400 text-xs sm:text-sm flex-shrink-0"></i>
                    </div>
                    <div class="text-base sm:text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-0.5 sm:mb-1">
                        <span id="uvIndex">4</span> <span class="text-[10px] sm:text-xs md:text-sm font-normal">UV</span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs" id="uvStatus">Moderate</div>
                </div>

                <div class="dashboard-panel stat-card p-3 md:p-4 w-full overflow-hidden">
                    <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                        <span class="stat-title text-gray-800 dark:text-gray-200">Visibility</span>
                        <i class="fas fa-eye text-purple-500 dark:text-purple-400 text-xs sm:text-sm flex-shrink-0"></i>
                    </div>
                    <div class="text-base sm:text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-0.5 sm:mb-1">
                        <span id="visibility">10</span> <span class="text-[10px] sm:text-xs md:text-sm font-normal">km</span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs">Clear visibility</div>
                </div>

        
                <div class="dashboard-panel stat-card p-3 md:p-4 w-full overflow-hidden">
                    <div class="flex items-center justify-between mb-1.5 sm:mb-2">
                        <span class="stat-title text-gray-800 dark:text-gray-200">Pressure</span>
                        <i class="fas fa-tachometer-alt text-red-500 dark:text-red-400 text-xs sm:text-sm flex-shrink-0"></i>
                    </div>
                    <div class="text-base sm:text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-0.5 sm:mb-1">
                        <span id="pressure">1013</span> <span class="text-[10px] sm:text-xs md:text-sm font-normal">hPa</span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs" id="pressureStatus">Normal</div>
                </div>
            </div>
        </div>

     
        <div id="errorState" class="hidden text-center py-8 sm:py-12">
            <div class="text-red-500 dark:text-red-400 text-3xl sm:text-4xl md:text-5xl mb-2 sm:mb-3">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-gray-900 dark:text-white text-sm sm:text-base md:text-lg mb-2">
                Unable to Load Weather Data
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 text-xs sm:text-sm px-4">
                Please check your internet connection and try again.
            </p>
            <button
                onclick="location.reload()"
                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors shadow-lg text-xs sm:text-sm"
            >
                Try Again
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
let currentWeatherData = null;
let currentLocation = null;

document.addEventListener("DOMContentLoaded", function () {
    const weatherDashboard = document.getElementById("weatherDashboard");
    const loadingState = document.getElementById("loadingState");
    const weatherContent = document.getElementById("weatherContent");
    const errorState = document.getElementById("errorState");

    const OPENWEATHER_API_KEY = @json(config('services.openweather.key', ''));
    const OPENWEATHER_BASE_URL = "https://api.openweathermap.org/data/2.5";
    const OPENMETEO_BASE_URL = "https://api.open-meteo.com/v1";

    const weatherIcons = {
        "01d": "fas fa-sun text-yellow-500 dark:text-yellow-400",
        "01n": "fas fa-moon text-blue-400 dark:text-blue-300",
        "02d": "fas fa-cloud-sun text-yellow-500 dark:text-yellow-400",
        "02n": "fas fa-cloud-moon text-blue-400 dark:text-blue-300",
        "03d": "fas fa-cloud text-gray-500 dark:text-gray-400",
        "03n": "fas fa-cloud text-gray-500 dark:text-gray-400",
        "04d": "fas fa-cloud text-gray-600 dark:text-gray-400",
        "04n": "fas fa-cloud text-gray-600 dark:text-gray-400",
        "09d": "fas fa-cloud-showers-heavy text-blue-500 dark:text-blue-400",
        "09n": "fas fa-cloud-showers-heavy text-blue-500 dark:text-blue-400",
        "10d": "fas fa-cloud-rain text-blue-500 dark:text-blue-400",
        "10n": "fas fa-cloud-rain text-blue-500 dark:text-blue-400",
        "11d": "fas fa-bolt text-yellow-600 dark:text-yellow-500",
        "11n": "fas fa-bolt text-yellow-600 dark:text-yellow-500",
        "13d": "fas fa-snowflake text-blue-200 dark:text-blue-300",
        "13n": "fas fa-snowflake text-blue-200 dark:text-blue-300",
        "50d": "fas fa-smog text-gray-500 dark:text-gray-400",
        "50n": "fas fa-smog text-gray-500 dark:text-gray-400",
    };

    const wmoToIcon = {
        0: "01d", 1: "02d", 2: "02d", 3: "03d",
        45: "50d", 48: "50d", 51: "09d", 53: "09d", 55: "09d",
        61: "10d", 63: "10d", 65: "10d",
        71: "13d", 73: "13d", 75: "13d",
        80: "09d", 81: "09d", 82: "09d",
        95: "11d", 96: "11d", 99: "11d",
    };

    const wmoDescriptions = {
        0: "Clear sky", 1: "Mainly clear", 2: "Partly cloudy", 3: "Overcast",
        45: "Foggy", 48: "Depositing rime fog",
        51: "Light drizzle", 53: "Moderate drizzle", 55: "Dense drizzle",
        61: "Slight rain", 63: "Moderate rain", 65: "Heavy rain",
        71: "Slight snow", 73: "Moderate snow", 75: "Heavy snow",
        80: "Slight rain showers", 81: "Moderate rain showers", 82: "Violent rain showers",
        95: "Thunderstorm", 96: "Thunderstorm with slight hail", 99: "Thunderstorm with heavy hail",
    };

    const now = new Date();
    const currentDateOptions = { weekday: "long", day: "2-digit", month: "short", year: "numeric" };
    document.getElementById("current-date-display").textContent = now.toLocaleDateString("en-US", currentDateOptions);
    document.getElementById("currentDay").textContent = now.toLocaleDateString("en-US", { weekday: "long" });
    document.getElementById("currentDate").textContent = now.toLocaleDateString("en-US", { day: "2-digit", month: "short", year: "numeric" });

    function getWeatherIcon(iconCode, isNight = false) {
        if (isNight && iconCode.endsWith('d')) {
            iconCode = iconCode.replace('d', 'n');
        }
        return weatherIcons[iconCode] || "fas fa-question text-gray-500 dark:text-gray-400";
    }

    function getWindDirection(degrees) {
        const directions = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];
        return directions[Math.round(degrees / 22.5) % 16];
    }

    function getUVStatus(uvIndex) {
        if (uvIndex <= 2) return "Low";
        if (uvIndex <= 5) return "Moderate";
        if (uvIndex <= 7) return "High";
        if (uvIndex <= 10) return "Very High";
        return "Extreme";
    }

    function getPressureStatus(pressure) {
        if (pressure < 1000) return "Low";
        if (pressure > 1020) return "High";
        return "Normal";
    }

    async function fetchLocationName(lat, lon) {
        try {
            const response = await fetch(
                `${OPENWEATHER_BASE_URL}/weather?lat=${lat}&lon=${lon}&appid=${OPENWEATHER_API_KEY}`
            );
            const data = await response.json();
            return {
                name: data.name || "Unknown Location",
                country: data.sys?.country || ""
            };
        } catch (error) {
            console.error("Error fetching location name:", error);
            return { name: "Unknown Location", country: "" };
        }
    }

    async function fetchOpenMeteoData(lat, lon) {
        try {
            const forecastUrl = `${OPENMETEO_BASE_URL}/forecast?` +
                `latitude=${lat}&longitude=${lon}` +
                `&current=temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,rain,weather_code,wind_speed_10m,wind_direction_10m,wind_gusts_10m,pressure_msl,surface_pressure` +
                `&hourly=temperature_2m,precipitation_probability,precipitation,weather_code,wind_speed_10m,wind_gusts_10m,uv_index` +
                `&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max,precipitation_sum,uv_index_max,wind_speed_10m_max,wind_gusts_10m_max` +
                `&timezone=auto&forecast_days=5`;

            const response = await fetch(forecastUrl);
            const data = await response.json();

            const location = await fetchLocationName(lat, lon);

            currentLocation = {
                latitude: lat,
                longitude: lon,
                name: location.name,
                country: location.country
            };

            displayOpenMeteoWeather(data, location);
            
            loadOpenMeteoAlerts(data, location);

            loadingState.classList.add("hidden");
            weatherContent.classList.remove("hidden");

        } catch (error) {
            console.error("Error fetching Open-Meteo data:", error);
            showError();
        }
    }

    function displayOpenMeteoWeather(data, location) {
        const current = data.current;
        const hourly = data.hourly;
        const daily = data.daily;

        const temp = Math.round(current.temperature_2m);
        const feelsLike = Math.round(current.apparent_temperature);
        const humidity = current.relative_humidity_2m;
        const pressure = Math.round(current.pressure_msl || current.surface_pressure);
        const windSpeed = Math.round(current.wind_speed_10m * 3.6);
        const windDirection = current.wind_direction_10m;
        const windGust = Math.round(current.wind_gusts_10m * 3.6);
        const weatherCode = current.weather_code;
        const precipitation = current.precipitation || 0;
        const rain = current.rain || 0;

        const isNight = new Date().getHours() < 6 || new Date().getHours() > 18;
        const iconCode = wmoToIcon[weatherCode] || "01d";
        const description = wmoDescriptions[weatherCode] || "Unknown";

        const tempMax = Math.round(daily.temperature_2m_max[0]);
        const tempMin = Math.round(daily.temperature_2m_min[0]);

        document.getElementById("location").textContent = `${location.name}${location.country ? ', ' + location.country : ''}`;
        
        document.getElementById("mainTemp").textContent = `${temp}°`;
        document.getElementById("feelsLike").textContent = `Feels like ${feelsLike}°`;
        document.getElementById("tempRange").textContent = `H: ${tempMax}° L: ${tempMin}°`;
        document.getElementById("weatherDescription").textContent = description;
        document.getElementById("mainWeatherIcon").innerHTML = `<i class="${getWeatherIcon(iconCode, isNight)}"></i>`;

        const rainChance = daily.precipitation_probability_max[0] || 0;
        document.getElementById("rainChance").textContent = rainChance;
        document.getElementById("rainfall").textContent = rain.toFixed(1);
        document.getElementById("humidity").textContent = humidity;

        document.getElementById("windSpeed").textContent = windSpeed.toFixed(1);
        document.getElementById("windDirection").textContent = getWindDirection(windDirection);
        document.getElementById("windGust").textContent = windGust.toFixed(1);

        document.getElementById("pressure").textContent = pressure;
        document.getElementById("pressureStatus").textContent = getPressureStatus(pressure);

        const uvIndex = Math.round(daily.uv_index_max[0] || 0);
        document.getElementById("uvIndex").textContent = uvIndex;
        document.getElementById("uvStatus").textContent = getUVStatus(uvIndex);

        document.getElementById("visibility").textContent = "10";

        currentWeatherData = {
            temperature: temp,
            rain_amount: rain,
            rain_chance: rainChance,
            wind_speed: windSpeed,
            wind_direction: windDirection,
            humidity: humidity,
            precipitation: precipitation,
            weather_code: weatherCode
        };

        displayHourlyForecast(hourly);
        displayDailyForecast(daily);
    }

    function displayHourlyForecast(hourlyData) {
        const hourlyForecast = document.getElementById("hourlyForecast").querySelector(".flex");

        const hourlyHTML = [];
        for (let i = 0; i < 12; i++) {
            const time = new Date(hourlyData.time[i]);
            const temp = Math.round(hourlyData.temperature_2m[i]);
            const weatherCode = hourlyData.weather_code[i];
            const iconCode = wmoToIcon[weatherCode] || "01d";
            const pop = hourlyData.precipitation_probability[i] || 0;
            const isNight = time.getHours() < 6 || time.getHours() > 18;

            hourlyHTML.push(`
                <div class="forecast-chip p-2 sm:p-3 md:p-4 text-center flex-shrink-0 w-20 sm:w-24 md:w-28 cursor-pointer">
                    <div class="text-gray-600 dark:text-gray-400 text-[10px] sm:text-xs md:text-sm mb-1 sm:mb-2">${i === 0 ? "Now" : time.getHours().toString().padStart(2, "0") + ":00"}</div>
                    <div class="text-xl sm:text-2xl md:text-3xl mb-1 sm:mb-2">
                        <i class="${getWeatherIcon(iconCode, isNight)}"></i>
                    </div>
                    <div class="text-gray-900 dark:text-white text-sm sm:text-base md:text-lg font-semibold mb-0.5 sm:mb-1">${temp}°</div>
                    ${pop > 0 ? `<div class="text-blue-500 dark:text-blue-400 text-[10px] sm:text-xs"><i class="fas fa-tint"></i> ${pop}%</div>` : ""}
                </div>
            `);
        }

        hourlyForecast.innerHTML = hourlyHTML.join("");
    }

    function displayDailyForecast(dailyData) {
        const dailyForecast = document.getElementById("dailyForecast");

        const dailyHTML = [];
        for (let i = 0; i < 5; i++) {
            const date = new Date(dailyData.time[i]);
            const dayName = i === 0 ? "Today" : date.toLocaleDateString("en-US", { weekday: "short" });
            const tempMax = Math.round(dailyData.temperature_2m_max[i]);
            const tempMin = Math.round(dailyData.temperature_2m_min[i]);
            const weatherCode = dailyData.weather_code[i];
            const iconCode = wmoToIcon[weatherCode] || "01d";
            const description = wmoDescriptions[weatherCode] || "Unknown";
            const pop = dailyData.precipitation_probability_max[i] || 0;

            dailyHTML.push(`
                <div class="forecast-row flex items-center justify-between p-3 md:p-4 cursor-pointer">
                    <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4 flex-1 min-w-0">
                        <div class="w-12 sm:w-14 md:w-16 text-gray-900 dark:text-white font-medium text-xs sm:text-sm md:text-base flex-shrink-0">${dayName}</div>
                        <div class="text-xl sm:text-2xl md:text-3xl flex-shrink-0">
                            <i class="${getWeatherIcon(iconCode)}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-gray-900 dark:text-white capitalize text-xs sm:text-sm md:text-base truncate">${description}</div>
                            ${pop > 0 ? `<div class="text-blue-500 dark:text-blue-400 text-[10px] sm:text-xs md:text-sm"><i class="fas fa-tint"></i> ${pop}%</div>` : ""}
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 ml-2">
                        <div class="text-gray-900 dark:text-white text-base sm:text-lg md:text-xl font-semibold">${tempMax}°</div>
                        <div class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm md:text-base">${tempMin}°</div>
                    </div>
                </div>
            `);
        }

        dailyForecast.innerHTML = dailyHTML.join("");
    }

    function showError() {
        loadingState.classList.add("hidden");
        weatherContent.classList.add("hidden");
        errorState.classList.remove("hidden");
    }

    if (!navigator.geolocation) {
        showError();
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            fetchOpenMeteoData(lat, lng);
        },
        (error) => {
            console.error("Geolocation error:", error);
            fetchOpenMeteoData(6.1164, 125.1716);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000,
        }
    );
});

// WEATHER ALERTS FUNCTIONS
function loadOpenMeteoAlerts(data, location) {
    console.log('🔄 Loading weather alerts...');
    
    if (!data || !location || !currentWeatherData) {
        console.warn('Missing data for alert analysis');
        return;
    }
    
    try {
        const alerts = analyzeOpenMeteoForAlerts(data, location, currentWeatherData);
        
        console.log(`📊 Generated ${alerts.length} alerts`);

        if (alerts && alerts.length > 0) {
            displayAlertSummary(alerts);
            displayDetailedAlerts(alerts);
        } else {
            displayAllClearState();
            console.log('ℹ️ No alerts - weather conditions normal');
        }
    } catch (error) {
        console.error('❌ Error analyzing alerts:', error);
    }
}

function analyzeOpenMeteoForAlerts(data, location, currentWeather) {
    const alerts = [];
    
    if (!data || !data.hourly || !data.daily) {
        return alerts;
    }

    const current = currentWeather;
    const hourly = data.hourly;
    const daily = data.daily;

    const temp = current.temperature;
    const rain = current.rain_amount;
    const wind = current.wind_speed;
    const humidity = current.humidity;

    let maxRainNext24h = 0;
    let maxWindNext24h = wind;
    let thunderstormDetected = false;
    let heavyRainPeriods = 0;
    let strongWindPeriods = 0;

    for (let i = 0; i < 24 && i < hourly.time.length; i++) {
        const hourRain = hourly.precipitation[i] || 0;
        const hourWind = (hourly.wind_speed_10m[i] || 0) * 3.6;
        const hourWeatherCode = hourly.weather_code[i];

        if (hourRain > maxRainNext24h) maxRainNext24h = hourRain;
        if (hourWind > maxWindNext24h) maxWindNext24h = hourWind;
        if (hourWeatherCode >= 95) thunderstormDetected = true;
        if (hourRain > 5) heavyRainPeriods++;
        if (hourWind > 40) strongWindPeriods++;
    }

    // TEMPERATURE ALERTS
    if (temp >= 35) {
        alerts.push({
            alertID: Date.now() + Math.random(),
            alert_type: temp >= 40 ? 'extreme_heat' : 'heat',
            severity: temp >= 40 ? 'extreme' : 'high',
            title: temp >= 40 ? 'Extreme Heat Warning' : 'High Temperature Alert',
            description: `Current temperature is ${temp}°C. ${temp >= 40 ? 'Extreme heat poses serious health risks.' : 'High temperatures may cause discomfort and health issues.'}`,
            warning: {
                title: temp >= 40 ? 'IMMEDIATE HEALTH DANGER' : 'HEAT HEALTH ADVISORY',
                content: temp >= 40 
                    ? 'Life-threatening heat conditions exist. Heat stroke and heat exhaustion are imminent risks.'
                    : 'High temperatures increase risk of heat-related illness.',
                impact: [
                    temp >= 40 ? 'Heat stroke risk - EXTREME' : 'Heat exhaustion risk - HIGH',
                    temp >= 40 ? 'Infrastructure stress' : 'Increased energy demand'
                ],
                timing: 'Peak danger: 10 AM - 4 PM',
                affected_areas: 'All outdoor areas'
            },
            recommendations: [
                'Stay indoors during peak heat',
                'Drink plenty of water',
                'Avoid strenuous activities'
            ],
            weather_conditions: {
                'Current Temperature': `${temp}°C`,
                'Threshold': '35°C'
            },
            location: location,
            issued_at: new Date().toISOString(),
            expires_at: new Date(Date.now() + 6 * 60 * 60 * 1000).toISOString(),
     
        });
    }

    if (thunderstormDetected || current.weather_code >= 95) {
        alerts.push({
            alertID: Date.now() + Math.random(),
            alert_type: 'storm',
            severity: 'extreme',
            title: 'Thunderstorm Warning',
            description: 'Thunderstorm activity detected in your area.',
            warning: {
                title: 'SEVERE THUNDERSTORM WARNING',
                content: 'Dangerous thunderstorm with lightning, heavy rain possible.',
                impact: ['Lightning strikes', 'Flash flooding possible'],
                timing: 'Next 6-12 hours',
                affected_areas: 'Entire area'
            },
            recommendations: [
                'Seek shelter immediately',
                'Stay away from windows',
                'Avoid electronics'
            ],
            weather_conditions: {
                'Status': 'Thunderstorm Detected'
            },
            location: location,
            issued_at: new Date().toISOString(),
            expires_at: new Date(Date.now() + 12 * 60 * 60 * 1000).toISOString(),
       
        });
    }

    if (maxRainNext24h > 10 || heavyRainPeriods >= 3) {
        alerts.push({
            alertID: Date.now() + Math.random(),
            alert_type: 'heavy_rain',
            severity: maxRainNext24h > 20 ? 'extreme' : 'high',
            title: 'Heavy Rain Alert',
            description: `Heavy rainfall expected: ${maxRainNext24h.toFixed(1)}mm peak.`,
            warning: {
                title: 'HEAVY RAINFALL ADVISORY',
                content: 'Heavy rain will create hazardous conditions.',
                impact: ['Localized flooding', 'Road flooding'],
                timing: `${heavyRainPeriods} hours`,
                affected_areas: 'Low-lying areas'
            },
            recommendations: [
                'Avoid unnecessary travel',
                'Stay away from flood-prone areas'
            ],
            weather_conditions: {
                'Peak Expected': `${maxRainNext24h.toFixed(1)} mm`,
                'Humidity': `${humidity}%`
            },
            location: location,
            issued_at: new Date().toISOString(),
            expires_at: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString(),
           
        });
    }

    if (maxWindNext24h >= 50) {
        alerts.push({
            alertID: Date.now() + Math.random(),
            alert_type: 'strong_wind',
            severity: maxWindNext24h >= 70 ? 'extreme' : 'high',
            title: 'Strong Wind Alert',
            description: `Strong winds expected: ${maxWindNext24h.toFixed(1)} km/h.`,
            warning: {
                title: 'STRONG WIND ADVISORY',
                content: 'Strong winds will create hazardous conditions.',
                impact: ['Tree branches breaking', 'Power outages'],
                timing: `${strongWindPeriods}+ hours`,
                affected_areas: 'All areas'
            },
            recommendations: [
                'Secure loose outdoor objects',
                'Stay away from trees'
            ],
            weather_conditions: {
                'Expected Peak': `${maxWindNext24h.toFixed(1)} km/h`
            },
            location: location,
            issued_at: new Date().toISOString(),
            expires_at: new Date(Date.now() + 12 * 60 * 60 * 1000).toISOString(),
         
        });
    }

    return alerts;
}

function getSeverityConfig(severity) {
    const configs = {
        'extreme': {
            borderClass: 'border-red-600',
            badgeClass: 'bg-red-600 text-white',
            bgClass: 'bg-red-50 dark:bg-red-900/20',
            iconClass: 'bg-red-600 text-white',
            ringClass: 'ring-red-100 dark:ring-red-900/40',
            dotClass: 'bg-red-500',
            summaryClass: 'from-red-600 to-rose-700'
        },
        'high': {
            borderClass: 'border-orange-600',
            badgeClass: 'bg-orange-600 text-white',
            bgClass: 'bg-orange-50 dark:bg-orange-900/20',
            iconClass: 'bg-orange-500 text-white',
            ringClass: 'ring-orange-100 dark:ring-orange-900/40',
            dotClass: 'bg-orange-500',
            summaryClass: 'from-orange-500 to-amber-600'
        },
        'moderate': {
            borderClass: 'border-yellow-600',
            badgeClass: 'bg-yellow-600 text-white',
            bgClass: 'bg-yellow-50 dark:bg-yellow-900/20',
            iconClass: 'bg-yellow-500 text-white',
            ringClass: 'ring-yellow-100 dark:ring-yellow-900/40',
            dotClass: 'bg-yellow-500',
            summaryClass: 'from-yellow-500 to-amber-500'
        }
    };
    return configs[severity] || configs['moderate'];
}

function getAlertTypeIcon(type) {
    const iconClasses = {
        'extreme_heat': 'fas fa-temperature-full',
        'heat': 'fas fa-sun',
        'heavy_rain': 'fas fa-cloud-showers-heavy',
        'strong_wind': 'fas fa-wind',
        'storm': 'fas fa-cloud-bolt'
    };
    return iconClasses[type] || 'fas fa-triangle-exclamation';
}

function toggleAlertsPanel() {
    const alertsList = document.getElementById('alertsList');
    alertsList.classList.toggle('hidden');
}

function cleanAlertText(value) {
    return String(value || '').replace(/[^\x20-\x7E]+/g, '').replace(/^[^A-Za-z0-9]+/, '').trim();
}

function displayAllClearState() {
    document.getElementById('alertSummaryBanner')?.classList.add('hidden');
    document.getElementById('alertsList')?.classList.add('hidden');
    document.getElementById('allClearBanner')?.classList.remove('hidden');
    const alertHeroCount = document.getElementById('alertHeroCount');
    if (alertHeroCount) {
        alertHeroCount.textContent = 'All clear';
    }
}

function displayAlertSummary(alerts) {
    const banner = document.getElementById('alertSummaryBanner');
    const allClearBanner = document.getElementById('allClearBanner');
    const alertHeroCount = document.getElementById('alertHeroCount');
    const totalAlerts = alerts.length;
    
    if (totalAlerts === 0) {
        displayAllClearState();
        return;
    }

    const extremeCount = alerts.filter(a => a.severity === 'extreme').length;
    const highCount = alerts.filter(a => a.severity === 'high').length;
    const topSeverity = extremeCount > 0 ? 'extreme' : highCount > 0 ? 'high' : 'moderate';
    const severityConfig = getSeverityConfig(topSeverity);

    if (alertHeroCount) {
        alertHeroCount.textContent = `${totalAlerts} active`;
    }

    banner.innerHTML = `
        <div class="bg-gradient-to-r ${severityConfig.summaryClass} text-white p-3 sm:p-4 rounded-xl shadow-lg alert-glow">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <div class="h-11 w-11 rounded-lg bg-white/20 flex items-center justify-center animate-soft-pulse flex-shrink-0">
                        <i class="fas fa-triangle-exclamation text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base sm:text-lg font-bold truncate">Active Weather Alerts</h3>
                        <p class="text-xs sm:text-sm opacity-90">
                            ${totalAlerts} alert${totalAlerts > 1 ? 's' : ''}
                            ${extremeCount > 0 ? ` - ${extremeCount} Extreme` : ''}
                            ${highCount > 0 ? ` - ${highCount} High` : ''}
                        </p>
                    </div>
                </div>
                <button onclick="toggleAlertsPanel()" 
                        class="w-full sm:w-auto bg-white/20 hover:bg-white/30 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors whitespace-nowrap">
                    View Details
                </button>
            </div>
        </div>
    `;
    allClearBanner?.classList.add('hidden');
    banner.classList.remove('hidden');
}

function displayDetailedAlerts(alerts) {
    const container = document.getElementById('alertsList');
    
    if (!alerts || alerts.length === 0) {
        container.classList.add('hidden');
        return;
    }
    
    container.innerHTML = alerts.map(alert => {
        const severityConfig = getSeverityConfig(alert.severity);
        const typeIcon = getAlertTypeIcon(alert.alert_type);
        const alertTitle = cleanAlertText(alert.title);
        const alertDescription = cleanAlertText(alert.description);
        const warningTitle = cleanAlertText(alert.warning?.title);
        const warningContent = cleanAlertText(alert.warning?.content);
        const locationName = cleanAlertText(alert.location?.name || 'Current area');
        
        return `
            <div class="bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 border border-gray-200 dark:border-gray-700 border-l-4 ${severityConfig.borderClass} shadow-sm hover:shadow-md transition-all duration-300 w-full overflow-hidden alert-card alert-card-polished">
                <div class="flex items-start justify-between mb-2 gap-3">
                    <div class="flex items-center space-x-2.5 sm:space-x-3 flex-1 min-w-0">
                        <div class="${severityConfig.iconClass} h-9 w-9 sm:h-10 sm:w-10 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm alert-icon">
                            <i class="${typeIcon} text-sm"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="alert-title text-gray-950 dark:text-white">
                                    ${alertTitle}
                                </h4>
                                <span class="${severityConfig.badgeClass} px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wide flex-shrink-0">
                                    ${alert.severity}
                                </span>
                            </div>
                            <p class="alert-meta text-gray-500 dark:text-gray-400 mt-0.5 truncate">
                                ${locationName} - Just now
                            </p>
                        </div>
                    </div>
                </div>

                <p class="alert-description text-gray-700 dark:text-gray-300 mb-2 sm:mb-3">
                    ${alertDescription}
                </p>

                ${alert.warning ? `
                    <div class="mb-2.5 sm:mb-3 p-2.5 sm:p-3 ${severityConfig.bgClass} rounded-lg overflow-hidden alert-warning-panel">
                        <div class="flex items-center space-x-2 mb-1.5 sm:mb-2">
                            <span class="${severityConfig.iconClass} h-6 w-6 rounded-md flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                            </span>
                            <h5 class="alert-warning-title text-gray-950 dark:text-white uppercase truncate">
                                ${warningTitle}
                            </h5>
                        </div>
                        <p class="alert-warning-copy text-gray-700 dark:text-gray-200 mb-2">
                            ${warningContent}
                        </p>
                        
                        ${alert.warning.impact && alert.warning.impact.length > 0 ? `
                            <div>
                                <h6 class="alert-section-label text-gray-600 dark:text-gray-300 mb-1.5 uppercase">Expected Impacts</h6>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                                    ${alert.warning.impact.map(impact => `
                                        <li class="alert-list-item text-gray-700 dark:text-gray-300 flex items-start space-x-2">
                                            <span class="mt-1.5 h-1 w-1 rounded-full ${severityConfig.dotClass} flex-shrink-0"></span>
                                            <span class="break-words">${cleanAlertText(impact)}</span>
                                        </li>
                                    `).join('')}
                                </ul>
                            </div>
                        ` : ''}
                    </div>
                ` : ''}

                ${alert.recommendations && alert.recommendations.length > 0 ? `
                    <details class="cursor-pointer group">
                        <summary class="alert-recommendation-summary text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center space-x-2 list-none">
                            <i class="fas fa-info-circle text-xs flex-shrink-0"></i>
                            <span>Safety Recommendations (${alert.recommendations.length})</span>
                            <i class="fas fa-chevron-down group-open:rotate-180 transition-transform ml-auto text-xs flex-shrink-0"></i>
                        </summary>
                        <ul class="mt-1.5 space-y-1 text-xs text-gray-600 dark:text-gray-400 pl-3 sm:pl-4">
                            ${alert.recommendations.map(rec => `
                                <li class="flex items-start space-x-1.5 sm:space-x-2">
                                    <span class="text-blue-500 mt-1 flex-shrink-0">•</span>
                                    <span>${rec}</span>
                                </li>
                            `).join('')}
                        </ul>
                    </details>
                ` : ''}
            </div>
        `;
    }).join('');
    
    container.classList.remove('hidden');
}
    </script>
@endpush

@push('styles')
    <style>
        /* Prevent horizontal scroll */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        .backdrop-blur-xl {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 0.75rem;
            box-shadow: 0 14px 35px -24px rgba(15, 23, 42, 0.45);
        }

        .dark .dashboard-card {
            background: rgba(31, 41, 55, 0.92);
            border-color: rgba(55, 65, 81, 0.95);
            box-shadow: 0 18px 40px -28px rgba(0, 0, 0, 0.9);
        }

        .dashboard-panel {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            letter-spacing: 0;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(226, 232, 240, 0.95);
            border-radius: 0.75rem;
            box-shadow: 0 12px 30px -24px rgba(15, 23, 42, 0.45);
            transition: box-shadow 220ms ease, transform 220ms ease, border-color 220ms ease;
        }

        .dashboard-panel:hover {
            transform: translateY(-1px);
            border-color: rgba(203, 213, 225, 1);
            box-shadow: 0 18px 36px -26px rgba(15, 23, 42, 0.55);
        }

        .dark .dashboard-panel {
            background: rgba(31, 41, 55, 0.96);
            border-color: rgba(55, 65, 81, 0.95);
            box-shadow: 0 18px 40px -30px rgba(0, 0, 0, 0.9);
        }

        .section-title {
            font-size: 0.9375rem;
            line-height: 1.35;
            font-weight: 800;
            letter-spacing: 0;
        }

        .metric-card,
        .forecast-chip,
        .forecast-row {
            background: rgba(248, 250, 252, 0.92);
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 0.625rem;
            transition: background-color 220ms ease, border-color 220ms ease, transform 220ms ease;
        }

        .metric-card:hover,
        .forecast-chip:hover,
        .forecast-row:hover {
            background: rgba(241, 245, 249, 0.96);
            border-color: rgba(203, 213, 225, 1);
        }

        .forecast-chip:hover,
        .forecast-row:hover {
            transform: translateY(-1px);
        }

        .dark .metric-card,
        .dark .forecast-chip,
        .dark .forecast-row {
            background: rgba(55, 65, 81, 0.58);
            border-color: rgba(75, 85, 99, 0.72);
        }

        .dark .metric-card:hover,
        .dark .forecast-chip:hover,
        .dark .forecast-row:hover {
            background: rgba(75, 85, 99, 0.64);
            border-color: rgba(107, 114, 128, 0.78);
        }

        .stat-card {
            min-height: 112px;
        }

        .stat-title {
            font-size: 0.75rem;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: 0;
        }

        .skeleton-bar,
        .skeleton-block,
        .skeleton-circle {
            position: relative;
            overflow: hidden;
            background: #e5e7eb;
        }

        .dark .skeleton-bar,
        .dark .skeleton-block,
        .dark .skeleton-circle {
            background: #374151;
        }

        .skeleton-bar,
        .skeleton-block {
            border-radius: 0.5rem;
        }

        .skeleton-circle {
            border-radius: 9999px;
        }

        .skeleton-bar::after,
        .skeleton-block::after,
        .skeleton-circle::after {
            content: "";
            position: absolute;
            inset: 0;
            transform: translateX(-100%);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.62), transparent);
            animation: skeleton-shimmer 1.35s infinite;
        }

        .dark .skeleton-bar::after,
        .dark .skeleton-block::after,
        .dark .skeleton-circle::after {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.12), transparent);
        }

        @keyframes skeleton-shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        @keyframes softPulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.86;
            }
        }

        .animate-soft-pulse {
            animation: softPulse 1.8s ease-in-out infinite;
        }

        .alert-glow {
            box-shadow: 0 18px 40px -24px rgba(239, 68, 68, 0.75);
        }

        .alert-card:hover {
            transform: translateY(-1px);
        }

        .alert-card-polished {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            letter-spacing: 0;
        }

        .alert-icon {
            box-shadow: 0 10px 24px -16px rgba(15, 23, 42, 0.75);
        }

        .alert-title {
            font-size: clamp(0.9375rem, 0.9rem + 0.18vw, 1.125rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: 0;
        }

        .alert-meta {
            font-size: 0.75rem;
            line-height: 1.25;
            font-weight: 500;
        }

        .alert-description,
        .alert-warning-copy {
            font-size: 0.8125rem;
            line-height: 1.45;
            font-weight: 450;
        }

        .alert-warning-panel {
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .dark .alert-warning-panel {
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
        }

        .alert-warning-title {
            font-size: 0.75rem;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: 0.025em;
        }

        .alert-section-label {
            font-size: 0.625rem;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: 0.04em;
        }

        .alert-list-item {
            font-size: 0.75rem;
            line-height: 1.35;
            font-weight: 500;
        }

        .alert-recommendation-summary {
            font-size: 0.8125rem;
            line-height: 1.3;
            font-weight: 700;
        }

        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        /* Custom scrollbar for horizontal scroll areas only */
        .scrollbar-thin::-webkit-scrollbar {
            height: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Vertical scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .weather-card {
            animation: slideInUp 0.6s ease-out forwards;
        }

        /* Improve touch targets on mobile */
        @media (max-width: 640px) {
            button, a, summary {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* Ensure text truncates properly */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Ensure content wraps on small screens */
        .break-words {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
@endpush
