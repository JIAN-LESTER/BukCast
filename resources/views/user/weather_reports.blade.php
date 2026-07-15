@extends('layouts.app')

@section('title', 'Weather Reports')
@section('header', 'Weather Reports')
@section('main-class', 'flex-1 overflow-y-auto overflow-x-hidden p-0 bg-slate-50 dark:bg-gray-900')

@section('content')
@php
$hasWeatherReports = isset($snapshots) && !$snapshots->isEmpty();
@endphp
<div class="weather-reports-page relative min-h-full px-3 sm:px-4 lg:px-6 py-4 sm:py-5">

    {{-- Notification stack --}}
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 flex flex-col gap-1.5 max-w-xs w-full pointer-events-none"></div>

    {{-- Page header --}}
    <div class="weather-report-panel flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 sm:p-5 mb-4">
        <div class="min-w-0">
            <div class="inline-flex items-center gap-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-3 py-1 text-[11px] sm:text-xs font-bold mb-2">
                <i class="fas fa-cloud-sun"></i>
                <span>Weather reports</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-gray-950 dark:text-white">Bukidnon weather</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Location snapshots, forecast periods, and current conditions.</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            @if($hasWeatherReports)
            <button id="refreshData"
                class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-sync-alt text-xs"></i>
                Refresh
            </button>
            @else
            <button id="storeNow"
                class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto px-3 py-2 rounded-lg bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 text-xs font-bold hover:bg-gray-700 dark:hover:bg-gray-300 transition-colors">
                <i class="fas fa-cloud-download-alt text-xs"></i>
                Fetch weather in Bukidnon
            </button>
            @endif
        </div>
    </div>

    {{-- Search --}}
    <div class="relative mb-4">
        <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-xs pointer-events-none"></i>
        <input
            id="locationSearch"
            type="text"
            placeholder="Search locations..."
            class="w-full pl-8 pr-3 py-2.5 text-sm rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900 focus:border-blue-400 dark:focus:border-blue-500 transition-colors shadow-sm" />
    </div>

    @if($hasWeatherReports)

    {{-- Cards grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2.5 sm:gap-3 pb-6" id="weatherCardsContainer">
        @foreach($snapshots as $snapshot)
        @php
        $location = $snapshot->weatherReport->location ?? null;
        if (!$location) continue;

        $summary = $snapshot->getSummary();
        $periods = $snapshot->getAvailableTimePeriods();
        $status = $summary['storm_status'] ?? 'clear';

        $badgeClass = match($status) {
        'clear' => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800',
        'possible_rain', 'light_rain' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
        default => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
        };

        $periodMeta = [
        'morning' => [
        'icon' => 'fas fa-cloud-sun',
        'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800',
        ],
        'noon' => [
        'icon' => 'fas fa-sun',
        'class' => 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-800',
        ],
        'afternoon' => [
        'icon' => 'fas fa-cloud-sun-rain',
        'class' => 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-900/30 dark:text-sky-400 dark:border-sky-800',
        ],
        'evening' => [
        'icon' => 'fas fa-moon',
        'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
        ],
        ];

        @endphp

        <div class="weather-card weather-report-card group overflow-hidden cursor-pointer"
            onclick="openWeatherModal('{{ $location->locID }}')"
            data-location-name="{{ strtolower($location->name) }}">

            {{-- Card header --}}
            <div class="flex items-center justify-between px-3 py-2.5 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                <div class="flex items-center gap-1.5 text-sm font-bold tracking-tight text-gray-950 dark:text-white truncate">
                    <i class="fas fa-map-marker-alt text-red-400 text-xs flex-shrink-0"></i>
                    <span class="truncate">{{ $location->name }}</span>
                </div>
                @if($summary)
                <span class="flex-shrink-0 ml-2 text-[11px] px-2 py-0.5 rounded-full border {{ $badgeClass }}">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </span>
                @endif
            </div>

            {{-- Card body --}}
            @if($summary)
            <div class="px-3 py-2.5">
                <div class="flex items-baseline gap-2 mb-0.5">
                    <span class="text-2xl font-bold text-gray-950 dark:text-white leading-none">
                        {{ number_format($summary['temperature'], 1) }}°
                    </span>
                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                        {{ ucfirst($summary['weather_desc'] ?? 'N/A') }}
                    </span>
                </div>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mb-2.5">
                    Status: {{ ucfirst(str_replace('_', ' ', $status)) }}
                </p>
                <div class="flex flex-wrap gap-1">
                    @foreach($periods as $period)
                    @php
                    $meta = $periodMeta[$period] ?? [
                    'icon' => 'fas fa-clock',
                    'class' => 'bg-gray-100 text-gray-600 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
                    ];
                    @endphp

                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full border text-[11px] font-semibold {{ $meta['class'] }}">
                        <i class="{{ $meta['icon'] }} text-[10px]"></i>
                        {{ ucfirst($period) }}
                    </span>
                    @endforeach
                </div>
            </div>
            @else
            <div class="px-3 py-4 text-center">
                <i class="fas fa-exclamation-circle text-gray-300 dark:text-gray-600 mb-1"></i>
                <p class="text-xs text-gray-400 dark:text-gray-500">No data available</p>
            </div>
            @endif

            {{-- Card footer --}}
            <div class="px-3 py-1.5 border-t border-gray-100 dark:border-gray-700 flex items-center justify-center gap-1 text-[11px] text-gray-400 dark:text-gray-500">
                <i class="fas fa-mouse-pointer text-[10px]"></i>
                Click for detailed view
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <i class="fas fa-cloud-sun text-5xl text-gray-200 dark:text-gray-700 mb-4"></i>
        <h3 class="text-base font-medium text-gray-600 dark:text-gray-400 mb-1">No weather reports available</h3>
        <p class="text-sm text-gray-400 dark:text-gray-500 mb-5 max-w-sm">No weather data has been collected yet. Fetch Bukidnon weather to add all locations.</p>
        <button onclick="document.getElementById('storeNow').click()"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-md bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 text-sm hover:bg-gray-700 dark:hover:bg-gray-300 transition-colors">
            <i class="fas fa-cloud-download-alt text-xs"></i>
            Fetch weather in Bukidnon
        </button>
    </div>
    @endif

</div>

{{-- Weather detail modal --}}
<div id="weatherModal" class="fixed inset-0 bg-black/30 backdrop-blur-[2px] hidden z-50 overflow-y-auto overscroll-contain">
    <div class="min-h-dvh flex items-start justify-center p-3 sm:p-4 sm:pt-10">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl w-full max-w-5xl max-h-[calc(100dvh-2rem)] sm:max-h-[calc(100dvh-5rem)] flex flex-col overflow-hidden">

            {{-- Modal header --}}
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-t-xl">
                <div class="flex items-center gap-2 text-sm font-bold tracking-tight text-gray-950 dark:text-white min-w-0">
                    <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                    <span id="modalLocationName" class="truncate">Location</span>
                </div>
                <button onclick="closeWeatherModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-md text-gray-400 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="p-3 sm:p-4 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5 sm:gap-3" id="modalWeatherContent">
                    {{-- Populated by JS --}}
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Confirmation modal --}}
<div id="confirmModal" class="fixed inset-0 bg-black/40 backdrop-blur-[2px] hidden z-[60] flex items-center justify-center p-4">
    <div class="w-full max-w-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center gap-2 text-sm font-bold text-gray-950 dark:text-white">
                <i class="fas fa-circle-question text-blue-400"></i>
                <span id="confirmModalTitle">Confirm action</span>
            </div>
        </div>
        <div class="px-4 py-4">
            <p id="confirmModalMessage" class="text-sm leading-relaxed text-gray-600 dark:text-gray-300"></p>
        </div>
        <div class="px-4 py-3 flex items-center justify-end gap-2 bg-gray-50 dark:bg-gray-700/50">
            <button id="confirmModalCancel" type="button"
                class="inline-flex items-center justify-center px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Cancel
            </button>
            <button id="confirmModalConfirm" type="button"
                class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-gray-900 dark:bg-gray-100 text-xs font-bold text-white dark:text-gray-900 hover:bg-gray-700 dark:hover:bg-gray-300 transition-colors">
                Continue
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .weather-reports-page {
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        letter-spacing: 0;
    }

    .weather-report-panel,
    .weather-report-card,
    .report-period-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(226, 232, 240, 0.95);
        border-radius: 0.75rem;
        box-shadow: 0 12px 30px -24px rgba(15, 23, 42, 0.45);
    }

    .dark .weather-report-panel,
    .dark .weather-report-card,
    .dark .report-period-card {
        background: rgba(31, 41, 55, 0.96);
        border-color: rgba(55, 65, 81, 0.95);
        box-shadow: 0 18px 40px -30px rgba(0, 0, 0, 0.9);
    }

    .weather-report-card {
        transition: box-shadow 220ms ease, transform 220ms ease, border-color 220ms ease;
    }

    .weather-report-card:hover {
        transform: translateY(-1px);
        border-color: rgba(203, 213, 225, 1);
        box-shadow: 0 18px 36px -26px rgba(15, 23, 42, 0.55);
    }

    .report-period-card {
        border-radius: 0.625rem;
    }

    .report-metric-row+.report-metric-row {
        border-top: 1px solid rgba(226, 232, 240, 0.9);
    }

    .dark .report-metric-row+.report-metric-row {
        border-top-color: rgba(55, 65, 81, 0.95);
    }

    @media (max-width: 640px) {
        #notificationContainer {
            left: 0.75rem;
            right: 0.75rem;
            max-width: none;
            width: auto;
        }

        #weatherModal>div>div {
            max-height: calc(100dvh - 1.5rem);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const weatherData = @json($todaySnapshots ?? []);

    // ─── Notifications ────────────────────────────────────────────────────────────
    function showNotification(message, type = 'info') {
        const icons = {
            info: 'fa-info-circle text-blue-400',
            success: 'fa-check-circle text-green-400',
            warning: 'fa-exclamation-circle text-amber-400',
            error: 'fa-exclamation-triangle text-red-400',
        };

        const el = document.createElement('div');
        el.className = 'pointer-events-auto flex items-start gap-2.5 px-3 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm text-xs text-gray-700 dark:text-gray-300 transition-opacity duration-300';
        el.innerHTML = `
        <i class="fas ${icons[type] ?? icons.info} text-sm mt-0.5 flex-shrink-0"></i>
        <span class="flex-1 leading-relaxed">${message}</span>
        <button onclick="this.closest('[class*=pointer-events]').remove()" class="flex-shrink-0 text-gray-300 hover:text-gray-500 dark:hover:text-gray-400 mt-0.5">
            <i class="fas fa-times text-xs"></i>
        </button>
    `;

        const container = document.getElementById('notificationContainer');
        container.appendChild(el);

        setTimeout(() => {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }, 5000);
    }

    function confirmModal(options = {}) {
        const modal = document.getElementById('confirmModal');
        const title = document.getElementById('confirmModalTitle');
        const message = document.getElementById('confirmModalMessage');
        const cancelButton = document.getElementById('confirmModalCancel');
        const confirmButton = document.getElementById('confirmModalConfirm');

        title.textContent = options.title || 'Confirm action';
        message.textContent = options.message || 'Do you want to continue?';
        confirmButton.textContent = options.confirmText || 'Continue';
        confirmButton.className = options.confirmClass || 'inline-flex items-center justify-center px-3 py-2 rounded-lg bg-gray-900 dark:bg-gray-100 text-xs font-bold text-white dark:text-gray-900 hover:bg-gray-700 dark:hover:bg-gray-300 transition-colors';

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        return new Promise(resolve => {
            const finish = confirmed => {
                modal.classList.add('hidden');
                document.body.style.overflow = document.getElementById('weatherModal').classList.contains('hidden') ? '' : 'hidden';
                cancelButton.removeEventListener('click', onCancel);
                confirmButton.removeEventListener('click', onConfirm);
                modal.removeEventListener('click', onBackdrop);
                resolve(confirmed);
            };

            const onCancel = () => finish(false);
            const onConfirm = () => finish(true);
            const onBackdrop = event => {
                if (event.target === modal) finish(false);
            };

            cancelButton.addEventListener('click', onCancel);
            confirmButton.addEventListener('click', onConfirm);
            modal.addEventListener('click', onBackdrop);
            confirmButton.focus();
        });
    }

    async function readJsonResponse(response) {
        let data;

        try {
            data = await response.json();
        } catch (error) {
            throw {
                message: response.status === 419
                    ? 'Your session expired. Please refresh the page and try again.'
                    : 'The server returned an invalid response.'
            };
        }

        if (!response.ok || data.success !== true) {
            throw data;
        }

        return data;
    }

    // ─── Search ───────────────────────────────────────────────────────────────────
    document.getElementById('locationSearch')?.addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.weather-card').forEach(card => {
            card.style.display = card.dataset.locationName.includes(q) ? '' : 'none';
        });
    });

    // ─── Modal ────────────────────────────────────────────────────────────────────
    function openWeatherModal(locID) {
        const data = weatherData[locID];
        if (!data) {
            showNotification('No weather data available for this location.', 'error');
            return;
        }

        document.getElementById('modalLocationName').textContent = data.location.name;
        document.getElementById('modalWeatherContent').innerHTML = generateModalContent(data);
        document.getElementById('weatherModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeWeatherModal() {
        document.getElementById('weatherModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.getElementById('weatherModal').addEventListener('click', function(e) {
        if (e.target === this) closeWeatherModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;

        const confirm = document.getElementById('confirmModal');
        if (confirm && !confirm.classList.contains('hidden')) {
            document.getElementById('confirmModalCancel').click();
            return;
        }

        closeWeatherModal();
    });

    // ─── Modal content builder ────────────────────────────────────────────────────
    const PERIOD_CONFIG = {
        morning: {
            icon: 'fas fa-cloud-sun',
            label: 'Morning',
            time: '6-10 AM',
            iconClass: 'bg-yellow-50 text-yellow-600 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800',
            headerClass: 'bg-yellow-50/70 dark:bg-yellow-900/20',
        },
        noon: {
            icon: 'fas fa-sun',
            label: 'Noon',
            time: '11 AM-2 PM',
            iconClass: 'bg-orange-50 text-orange-600 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-800',
            headerClass: 'bg-orange-50/70 dark:bg-orange-900/20',
        },
        afternoon: {
            icon: 'fas fa-cloud-sun-rain',
            label: 'Afternoon',
            time: '3-5 PM',
            iconClass: 'bg-sky-50 text-sky-600 border-sky-200 dark:bg-sky-900/30 dark:text-sky-400 dark:border-sky-800',
            headerClass: 'bg-sky-50/70 dark:bg-sky-900/20',
        },
        evening: {
            icon: 'fas fa-moon',
            label: 'Evening',
            time: '6-10 PM',
            iconClass: 'bg-indigo-50 text-indigo-600 border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
            headerClass: 'bg-indigo-50/70 dark:bg-indigo-900/20',
        },
    };

    const STATUS_BADGE = {
        clear: 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800',
        possible_rain: 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
        light_rain: 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
        moderate_rain: 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
        heavy_rain: 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
    };

    function generateModalContent(locationData) {
        return Object.entries(PERIOD_CONFIG).map(([period, cfg]) => {
            const d = getPeriodData(locationData, period);

            if (!d) {
                return `
                <div class="report-period-card overflow-hidden">
                    <div class="flex items-center gap-2 px-3 py-2 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <span class="h-8 w-8 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-blue-500 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                            <i class="${cfg.icon} text-xs"></i>
                        </span>
                        <div>
                            <div class="text-xs font-bold text-gray-800 dark:text-gray-100">${cfg.label}</div>
                            <div class="text-[11px] text-gray-400 dark:text-gray-500">${cfg.time}</div>
                        </div>
                    </div>
                    <div class="px-3 py-6 text-center">
                        <i class="fas fa-cloud text-gray-200 dark:text-gray-600 text-xl mb-1.5 block"></i>
                        <p class="text-xs text-gray-400 dark:text-gray-500">No data available</p>
                    </div>
                </div>`;
            }

            const status = d.storm_status || 'clear';
            const badgeClass = STATUS_BADGE[status] || STATUS_BADGE.clear;
            const temp = parseFloat(d.temperature || 0).toFixed(1);
            const feelsLike = parseFloat(d.feels_like || d.temperature || 0).toFixed(1);
            const rainChance = parseFloat(d.rain_chance || 0).toFixed(0);
            const rainAmount = parseFloat(d.rain_amount || 0).toFixed(2);
            const wind = parseFloat(d.wind_speed || 0).toFixed(1);

            return `
            <div class="report-period-card overflow-hidden">

                {{-- Period header --}}
                <div class="flex items-center justify-between px-3 py-2 border-b border-gray-100 dark:border-gray-700 ${cfg.headerClass}">
                    <div class="flex items-center gap-2">
                       <span class="h-8 w-8 rounded-lg border flex items-center justify-center flex-shrink-0 ${cfg.iconClass}">
    <i class="${cfg.icon} text-xs"></i>
</span>
                        <div>
                            <div class="text-xs font-bold text-gray-800 dark:text-gray-100">${cfg.label}</div>
                            <div class="text-[11px] text-gray-400 dark:text-gray-500">${cfg.time}</div>
                        </div>
                    </div>
                    <span class="text-[11px] px-2 py-0.5 rounded-full border ${badgeClass}">
                        ${capitalizeWords(status.replace(/_/g, ' '))}
                    </span>
                </div>

                {{-- Period body --}}
                <div class="px-3 py-2.5">
                    <div class="flex items-center gap-2 mb-0.5">
                        ${d.weather_icon ? `<img src="https://openweathermap.org/img/wn/${d.weather_icon}.png" alt="" class="w-8 h-8 -ml-1">` : ''}
                        <span class="text-2xl font-bold text-gray-950 dark:text-white leading-none">${temp}°C</span>
                    </div>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mb-3">
                        Feels like ${feelsLike}°C - ${capitalizeWords(d.weather_desc || 'N/A')}
                    </p>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="report-metric-row flex justify-between items-center py-1.5 text-xs">
                            <span class="flex items-center gap-1.5 font-bold text-gray-600 dark:text-gray-300">
                                <i class="fas fa-tint text-[11px]"></i> Rain chance
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">${rainChance}%</span>
                        </div>
                        <div class="report-metric-row flex justify-between items-center py-1.5 text-xs">
                            <span class="flex items-center gap-1.5 font-bold text-gray-600 dark:text-gray-300">
                                <i class="fas fa-cloud-rain text-[11px]"></i> Amount
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">${rainAmount} mm</span>
                        </div>
                        <div class="report-metric-row flex justify-between items-center py-1.5 text-xs">
                            <span class="flex items-center gap-1.5 font-bold text-gray-600 dark:text-gray-300">
                                <i class="fas fa-wind text-[11px]"></i> Wind
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">${wind} m/s</span>
                        </div>
                        <div class="report-metric-row flex justify-between items-center py-1.5 text-xs">
                            <span class="flex items-center gap-1.5 font-bold text-gray-600 dark:text-gray-300">
                                <i class="fas fa-droplet text-[11px]"></i> Humidity
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">${d.humidity || 0}%</span>
                        </div>
                        <div class="report-metric-row flex justify-between items-center py-1.5 text-xs">
                            <span class="flex items-center gap-1.5 font-bold text-gray-600 dark:text-gray-300">
                                <i class="fas fa-gauge text-[11px]"></i> Pressure
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">${d.pressure || 0} hPa</span>
                        </div>
                        <div class="report-metric-row flex justify-between items-center py-1.5 text-xs">
                            <span class="flex items-center gap-1.5 font-bold text-gray-600 dark:text-gray-300">
                                <i class="fas fa-cloud text-[11px]"></i> Clouds
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">${d.cloudiness || 0}%</span>
                        </div>
                    </div>

                    ${d.forecast_time ? `
                    <p class="mt-2 text-center text-[11px] text-gray-300 dark:text-gray-600">
                        <i class="fas fa-clock mr-1"></i>${d.forecast_time}
                    </p>` : ''}
                </div>
            </div>`;
        }).join('');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────────
    function getPeriodData(locationData, period) {
        if (locationData.periods?.[period]?.data) {
            return locationData.periods[period].data;
        }
        if (locationData.raw_snapshots) {
            for (const snapshot of locationData.raw_snapshots) {
                for (const key in snapshot.snapshots ?? {}) {
                    const data = snapshot.snapshots[key];
                    if (data?.time_slots?.[period]) return data.time_slots[period];
                }
            }
        }
        if (locationData.periods?.[period]?.snapshot?.snapshots) {
            for (const key in locationData.periods[period].snapshot.snapshots) {
                const data = locationData.periods[period].snapshot.snapshots[key];
                if (data?.time_slots?.[period]) return data.time_slots[period];
            }
        }
        return null;
    }

    function capitalizeWords(str) {
        return str.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
    }

    // ─── Fetch Bukidnon weather ───────────────────────────────────────────────────
    document.getElementById('storeNow')?.addEventListener('click', async function() {
        const confirmed = await confirmModal({
            title: 'Fetch weather forecasts',
            message: 'Fetch Bukidnon weather forecasts for all locations right now?',
            confirmText: 'Fetch weather',
        });

        if (!confirmed) return;

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> Fetching…';

        fetch('/weather-reports/store-now', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(readJsonResponse)
            .then(data => {
                if (data.success) {
                    const d = data.details;
                    showNotification(data.message, 'success');
                    showNotification(`Total: ${d.total_locations} · Successful: ${d.successful} · Failed: ${d.failed}`, 'info');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to store: ' + data.message, 'error');
                }
            })
            .catch(error => showNotification(error.message || 'An error occurred while storing forecasts.', 'error'))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-cloud-download-alt text-xs"></i> Fetch weather in Bukidnon';
            });
    });

    // ─── Refresh ──────────────────────────────────────────────────────────────────
    document.getElementById('refreshData')?.addEventListener('click', async function() {
        const confirmed = await confirmModal({
            title: 'Refresh weather reports',
            message: 'Fetch fresh Bukidnon weather forecasts and update the current reports?',
            confirmText: 'Refresh',
        });

        if (!confirmed) return;

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> Refreshing…';

        fetch('/weather-reports/refresh-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(readJsonResponse)
            .then(data => {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 2000);
            })
            .catch(error => {
                showNotification(error.message || 'An error occurred during refresh.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync-alt text-xs"></i> Refresh';
            });
    });

    // ─── Cleanup (optional button — wire up if you have one in your layout) ───────
    document.getElementById('cleanupOld')?.addEventListener('click', async function() {
        const confirmed = await confirmModal({
            title: 'Delete old reports',
            message: 'Delete all weather reports from previous days?',
            confirmText: 'Delete',
            confirmClass: 'inline-flex items-center justify-center px-3 py-2 rounded-lg bg-red-600 text-xs font-bold text-white hover:bg-red-700 transition-colors',
        });

        if (!confirmed) return;

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i> Cleaning…';

        fetch('/weather-reports/cleanup', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(readJsonResponse)
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Cleanup failed: ' + data.message, 'error');
                }
            })
            .catch(error => showNotification(error.message || 'An error occurred during cleanup.', 'error'))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-trash-alt text-xs"></i> Cleanup old reports';
            });
    });
</script>
@endpush
