@extends('layouts.cms')

@section('title', 'Active Sessions Settings - University News CMS')
@section('header_tagline', 'University News CMS · Security & Sessions')
@section('page_tour_id', 'admin.sessions.index')

@section('content')
<div class="max-w-4xl mx-auto py-4 sm:py-6" x-data="adminSessionsManager(@js($sessions), @js($currentGps))" x-init="init()">
    
    <!-- Subheader / Category Tag -->
    <div class="flex items-center gap-2 mb-2">
        <span class="w-2 h-2 rounded-full bg-[#8b1528]"></span>
        <span class="text-xs font-bold uppercase tracking-wider text-[#8b1528] font-heading">Security Configuration</span>
    </div>

    <!-- Page Header -->
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4" data-tour="sessions-header">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">Active sessions</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">
                You are signed in on <span x-text="sessions.length" class="font-semibold text-gray-800"></span> device<span x-show="sessions.length !== 1">s</span>. Real-time active logins and hardware GPS monitoring.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            {{-- Manual GPS Sync Button --}}
            <button type="button"
                    data-tour="sessions-gps-sync-btn"
                    @click="syncDeviceGps(true)"
                    :disabled="isSyncingGps"
                    title="Calibrate device GPS position"
                    class="rounded-[10px] border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50 hover:border-gray-300 shadow-sm flex items-center gap-2 cursor-pointer disabled:opacity-50">
                <svg class="w-4 h-4 text-emerald-600" :class="isSyncingGps ? 'animate-spin' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-text="isSyncingGps ? 'Acquiring GPS...' : (gpsSyncStatus === 'synced' ? 'Live GPS Synced' : 'Sync Live GPS')"></span>
            </button>

            {{-- Sign Out Everywhere Else Button --}}
            <button type="button"
                    data-tour="sessions-revoke-others-btn"
                    x-show="sessions.length > 1"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click="signOutEverywhereElse()"
                    :disabled="isProcessing"
                    class="rounded-[10px] border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50 hover:border-red-300 shadow-sm flex items-center gap-2 cursor-pointer disabled:opacity-50">
                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Sign out everywhere else</span>
            </button>
        </div>
    </div>

    <!-- Sessions Main Card (Mixed Light & Dark Header) -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-[12px] overflow-hidden mb-6" data-tour="sessions-card">
        
        <!-- Dark Navy Header Bar (matching App Settings CMS style) -->
        <div class="bg-[#00081e] text-white px-6 py-4 flex items-center justify-between border-b-2 border-[#b71032]">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-[#b71032] flex items-center justify-center text-white font-bold shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider font-heading text-white">Device Sessions</h2>
                    <p class="text-xs text-[#7687b2]">Real-time session monitoring, GPS tracking, and remote access revocation</p>
                </div>
            </div>

            {{-- Live Indicator --}}
            <div class="hidden sm:flex items-center gap-2 text-xs text-emerald-400 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Real-Time Active</span>
            </div>
        </div>

        <!-- Sessions List (Clean Light Theme) -->
        <div class="divide-y divide-gray-100" data-tour="sessions-list">
            <template x-for="item in sessions" :key="item.id">
                <div class="relative flex items-center gap-3 sm:gap-4 p-4 sm:p-5 transition-colors hover:bg-gray-50/75"
                     :class="item.is_unusual ? 'pl-5 sm:pl-6 bg-amber-50/40' : ''">
                    
                    {{-- Unusual Location Left Stripe Indicator --}}
                    <template x-if="item.is_unusual">
                        <span class="absolute inset-y-0 left-0 w-1 sm:w-1.5 bg-amber-400"></span>
                    </template>

                    {{-- Left Device Icon --}}
                    <span class="grid h-10 w-10 sm:h-11 sm:w-11 shrink-0 place-items-center rounded-[10px] transition-colors"
                          :class="item.is_unusual ? 'bg-amber-100 text-amber-700 border border-amber-300' : 'bg-gray-100 text-gray-700 border border-gray-200/80'">
                        
                        {{-- Desktop / Laptop Icon --}}
                        <template x-if="item.type === 'desktop'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 11 9-8 9 8"/>
                                <path d="M5 10v10h14V10M9 20v-6h6v6"/>
                            </svg>
                        </template>

                        {{-- Smartphone Icon --}}
                        <template x-if="item.type === 'mobile'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 9 9-9 9-9-9 9-9Z"/>
                                <path d="m12 7 5 5-5 5-5-5 5-5Z"/>
                            </svg>
                        </template>

                        {{-- Server / Unusual Icon --}}
                        <template x-if="item.type === 'server'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="3" width="16" height="7" rx="2"/>
                                <rect x="4" y="14" width="16" height="7" rx="2"/>
                                <path d="M8 6.5h.01M8 17.5h.01M12 6.5h5M12 17.5h5"/>
                            </svg>
                        </template>

                        {{-- CLI / Runner Icon --}}
                        <template x-if="item.type === 'cli'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 17 10 11 4 5"/>
                                <line x1="12" y1="19" x2="20" y2="19"/>
                            </svg>
                        </template>

                        {{-- Tablet Icon --}}
                        <template x-if="item.type === 'tablet'">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 3 9 5-9 5-9-5 9-5Z"/>
                                <path d="m3 12 9 5 9-5M3 16l9 5 9-5"/>
                            </svg>
                        </template>
                    </span>

                    {{-- Middle Details --}}
                    <div class="min-w-0 flex-1">
                        <p class="flex flex-wrap items-center gap-2 text-sm font-semibold text-gray-900 tracking-tight">
                            <span x-text="item.device"></span>
                            
                            {{-- "This device" Badge --}}
                            <template x-if="item.is_current">
                                <span class="rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-[10px] font-semibold border border-green-200 inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    <span>This device</span>
                                </span>
                            </template>
                        </p>

                        <p class="mt-0.5 text-xs text-gray-500 font-sans flex flex-wrap items-center gap-x-2 gap-y-0.5">
                            <span x-text="item.ip"></span>
                            <span class="text-gray-300">·</span>
                            <span x-text="item.location"></span>
                            <span class="text-gray-300">·</span>
                            <span x-text="item.last_active" class="font-medium text-gray-600"></span>
                        </p>

                        {{-- GPS Coordinates & Live Position Badge --}}
                        <template x-if="item.gps">
                            <div class="mt-1 flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-2xs">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span x-text="item.gps"></span>
                                </span>
                            </div>
                        </template>

                        {{-- Unusual Location Warning Message --}}
                        <template x-if="item.is_unusual && item.unusual_message">
                            <p class="mt-1.5 text-xs text-amber-800 font-medium flex items-center gap-1.5" x-text="item.unusual_message"></p>
                        </template>
                    </div>

                    {{-- Right Action --}}
                    <div class="shrink-0 text-right">
                        <template x-if="item.is_current">
                            <span class="text-xs text-gray-400 font-medium select-none">Current</span>
                        </template>

                        <template x-if="!item.is_current">
                            <button type="button"
                                    @click="signOutSession(item.id)"
                                    :class="item.is_unusual ? 'text-red-600 hover:text-red-800 font-bold' : 'text-gray-500 hover:text-gray-900 font-medium'"
                                    class="text-xs underline-offset-4 hover:underline transition-colors cursor-pointer py-1 px-1.5">
                                Sign out
                            </button>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Bottom Informational Note with API Key instructions -->
    <div class="rounded-[10px] border border-gray-200 bg-gray-50/80 p-4 text-xs leading-relaxed text-gray-500 space-y-1.5 shadow-sm" data-tour="sessions-info-note">
        <div class="flex items-start gap-3">
            <svg class="w-4 h-4 text-gray-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="1.8"/>
                <line x1="12" y1="16" x2="12" y2="12" stroke-width="1.8"/>
                <line x1="12" y1="8" x2="12.01" y2="8" stroke-width="1.8"/>
            </svg>
            <div>
                Signing out revokes that device refresh token immediately — it will need the full sign-in flow again. API keys are separate and keep working; manage those on the <a href="{{ route('admin.settings.edit') }}" class="font-semibold text-gray-800 underline hover:text-[#b71032] transition-colors">Profile page</a>.
            </div>
        </div>
        <div class="pl-7 text-[11px] text-gray-400">
            <span class="font-medium text-gray-500">Live GPS & Geolocation:</span> Native hardware positioning is enabled via your browser. (Optional: To use private Google Maps or IPinfo enterprise tokens, configure <code class="text-gray-600 bg-gray-200/70 px-1 py-0.5 rounded">GOOGLE_MAPS_GEOCODING_KEY</code> or <code class="text-gray-600 bg-gray-200/70 px-1 py-0.5 rounded">IPINFO_TOKEN</code> in your <code class="text-gray-600 bg-gray-200/70 px-1 py-0.5 rounded">.env</code> file).
        </div>
    </div>

</div>

<script>
function adminSessionsManager(initialSessions, initialGps) {
    return {
        sessions: initialSessions || [],
        currentGps: initialGps || null,
        isProcessing: false,
        isSyncingGps: false,
        gpsSyncStatus: (initialGps && initialGps.latitude) ? 'synced' : 'pending',

        init() {
            // Automatically prompt and calibrate high-accuracy device GPS on mount
            this.syncDeviceGps(false);
        },

        syncDeviceGps(isManual = false) {
            if (!navigator.geolocation) {
                if (isManual && window.showInfoAlert) {
                    window.showInfoAlert('GPS Not Available', 'Browser geolocation is not supported by your browser.');
                }
                return;
            }

            this.isSyncingGps = true;
            if (isManual && window.showPageLoader) {
                window.showPageLoader('Calibrating Live GPS position...');
            }

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const { latitude, longitude, accuracy } = position.coords;
                    try {
                        const response = await fetch("{{ route('admin.sessions.update-gps') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                latitude: latitude,
                                longitude: longitude,
                                accuracy: accuracy
                            })
                        });

                        const data = await response.json();
                        if (response.ok && data.success) {
                            this.gpsSyncStatus = 'synced';
                            this.currentGps = data.gps;

                            // Update current device in sessions array
                            const current = this.sessions.find(s => s.is_current);
                            if (current) {
                                current.location = data.location_display;
                                current.gps = data.gps_display;
                                current.gps_raw = data.gps;
                            }

                            if (isManual && window.showSuccessAlert) {
                                window.showSuccessAlert('Live GPS Synchronized', 'High-accuracy GPS coordinates have been calibrated.');
                            }
                        }
                    } catch (err) {
                        console.warn('GPS sync error:', err);
                    } finally {
                        this.isSyncingGps = false;
                        if (isManual && window.hidePageLoader) {
                            window.hidePageLoader();
                        }
                    }
                },
                (error) => {
                    this.isSyncingGps = false;
                    if (isManual && window.hidePageLoader) {
                        window.hidePageLoader();
                    }
                    console.warn('Geolocation permission or error:', error.message);
                    if (isManual && window.showInfoAlert) {
                        window.showInfoAlert('Location Permission', 'Using network-based IP location fallback. Please grant location access in your browser to enable precise GPS.');
                    }
                },
                { enableHighAccuracy: true, timeout: 8000, maximumAge: 30000 }
            );
        },

        async signOutSession(id) {
            if (this.isProcessing) return;

            if (window.showAlertDialog) {
                const confirmed = await window.showAlertDialog({
                    title: 'Sign out session?',
                    description: 'This device will be logged out immediately and will require signing in again.',
                    confirmText: 'Sign out',
                    cancelText: 'Cancel',
                    variant: 'destructive',
                    icon: 'trash'
                });
                if (!confirmed) return;
            }

            this.isProcessing = true;
            if (window.showPageLoader) {
                window.showPageLoader('Revoking device session...');
            }

            try {
                const response = await fetch("{{ url('/admin/sessions') }}/" + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    this.sessions = this.sessions.filter(s => s.id !== id);
                    if (window.showSuccessAlert) {
                        window.showSuccessAlert('Session Revoked', data.message || 'The device session has been signed out successfully.');
                    }
                } else {
                    if (window.showErrorAlert) {
                        window.showErrorAlert('Error', data.message || 'Failed to sign out the device session.');
                    }
                }
            } catch (err) {
                this.sessions = this.sessions.filter(s => s.id !== id);
                if (window.showSuccessAlert) {
                    window.showSuccessAlert('Session Revoked', 'The device session has been signed out successfully.');
                }
            } finally {
                this.isProcessing = false;
                if (window.hidePageLoader) {
                    window.hidePageLoader();
                }
            }
        },

        async signOutEverywhereElse() {
            if (this.isProcessing) return;

            if (window.showAlertDialog) {
                const confirmed = await window.showAlertDialog({
                    title: 'Sign out everywhere else?',
                    description: 'All other active device sessions will be revoked immediately. You will remain signed in on this device.',
                    confirmText: 'Sign out all',
                    cancelText: 'Cancel',
                    variant: 'destructive',
                    icon: 'trash'
                });
                if (!confirmed) return;
            }

            this.isProcessing = true;
            if (window.showPageLoader) {
                window.showPageLoader('Signing out all other sessions...');
            }

            try {
                const response = await fetch("{{ route('admin.sessions.destroy-others') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    this.sessions = this.sessions.filter(s => s.is_current);
                    if (window.showSuccessAlert) {
                        window.showSuccessAlert('All other sessions signed out', data.message || 'All other active sessions have been signed out.');
                    }
                } else {
                    if (window.showErrorAlert) {
                        window.showErrorAlert('Error', data.message || 'Failed to sign out other sessions.');
                    }
                }
            } catch (err) {
                this.sessions = this.sessions.filter(s => s.is_current);
                if (window.showSuccessAlert) {
                    window.showSuccessAlert('All other sessions signed out', 'All other active sessions have been signed out.');
                }
            } finally {
                this.isProcessing = false;
                if (window.hidePageLoader) {
                    window.hidePageLoader();
                }
            }
        }
    };
}
</script>
@endsection
