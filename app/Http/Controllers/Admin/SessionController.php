<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SessionController extends Controller
{
    /**
     * Display a listing of active admin sessions with real-time database and GPS data.
     */
    public function index(Request $request): View
    {
        $currentSessionId = $request->session()->getId();
        $adminId = Auth::guard('admin')->id();

        // 1. Synchronize current admin session record in database
        DB::table('sessions')
            ->where('id', $currentSessionId)
            ->update(['user_id' => $adminId]);

        // 2. Fetch all database sessions belonging to this admin
        $dbSessions = DB::table('sessions')->get();

        // Find sessions belonging to admin
        $adminDbSessions = collect();
        foreach ($dbSessions as $row) {
            $isOwner = false;
            if ($row->user_id == $adminId) {
                $isOwner = true;
            } else {
                $payload = @unserialize(base64_decode($row->payload));
                if (is_array($payload)) {
                    foreach ($payload as $key => $val) {
                        if (str_starts_with($key, 'login_admin_') && $val == $adminId) {
                            $isOwner = true;
                            // Synchronize user_id column
                            DB::table('sessions')->where('id', $row->id)->update(['user_id' => $adminId]);
                            break;
                        }
                    }
                }
            }

            if ($isOwner) {
                $adminDbSessions->push($row);
            }
        }

        // 3. Resolve Current Device Real-Time Location & GPS
        $currentGps = $this->getCurrentGps($request, $currentSessionId);

        // 4. Transform Real Database Sessions
        $realSessions = collect();
        foreach ($adminDbSessions as $dbSess) {
            $isCurrent = ($dbSess->id === $currentSessionId);
            $parsedInfo = $this->parseDeviceInfo($dbSess->user_agent ?? $request->userAgent());
            $ip = $dbSess->ip_address ?? $request->ip();

            // Resolve location details for this session
            if ($isCurrent) {
                $displayIp = ($ip === '127.0.0.1' || $ip === '::1') 
                    ? ($currentGps['public_ip'] ?? '127.0.0.1 (Localhost)')
                    : $ip;
                $location = !empty($currentGps['city']) 
                    ? $currentGps['city'] . ', ' . ($currentGps['country'] ?? 'ID')
                    : 'Localhost · Private Network';
                $gpsDisplay = !empty($currentGps['latitude']) 
                    ? 'GPS: ' . round($currentGps['latitude'], 4) . '°, ' . round($currentGps['longitude'], 4) . '°' 
                      . (!empty($currentGps['accuracy']) ? ' (±' . round($currentGps['accuracy']) . 'm)' : '')
                    : null;
                $lastActive = 'active now';
                $isUnusual = false;
                $unusualMessage = null;
            } else {
                $displayIp = $ip;
                $geo = $this->resolveIpLocation($ip);
                $location = $geo['city'] . ', ' . $geo['country'];
                $gpsDisplay = (!empty($geo['latitude'])) 
                    ? 'GPS: ' . round($geo['latitude'], 4) . '°, ' . round($geo['longitude'], 4) . '°'
                    : null;
                $lastActive = Carbon::createFromTimestamp($dbSess->last_activity)->diffForHumans();
                $currentCountry = !empty($currentGps['country']) ? $currentGps['country'] : 'Indonesia';
                $sessionCountry = $geo['country'] ?? '';
                $isUnusual = (!empty($sessionCountry) && $sessionCountry !== 'Localhost' && strcasecmp($sessionCountry, $currentCountry) !== 0);
                $unusualMessage = $isUnusual ? "Unusual location — signed in from {$sessionCountry}." : null;
            }

            $realSessions->push([
                'id' => $dbSess->id,
                'device' => $parsedInfo['device'],
                'is_current' => $isCurrent,
                'type' => $parsedInfo['type'],
                'ip' => $displayIp,
                'location' => $location,
                'gps' => $gpsDisplay,
                'gps_raw' => $isCurrent ? $currentGps : null,
                'last_active' => $lastActive,
                'is_unusual' => $isUnusual,
                'unusual_message' => $unusualMessage,
                'is_real' => true,
            ]);
        }

        // 5. Ensure current session is always at the top
        $currentDeviceSession = $realSessions->firstWhere('is_current', true);
        if (!$currentDeviceSession) {
            $parsedInfo = $this->parseDeviceInfo($request->userAgent());
            $currentDeviceSession = [
                'id' => $currentSessionId,
                'device' => $parsedInfo['device'],
                'is_current' => true,
                'type' => $parsedInfo['type'],
                'ip' => ($request->ip() === '127.0.0.1') ? ($currentGps['public_ip'] ?? '127.0.0.1 (Localhost)') : $request->ip(),
                'location' => !empty($currentGps['city']) ? $currentGps['city'] . ', ' . ($currentGps['country'] ?? 'ID') : 'Localhost · Private Network',
                'gps' => !empty($currentGps['latitude']) ? 'GPS: ' . round($currentGps['latitude'], 4) . '°, ' . round($currentGps['longitude'], 4) . '°' : null,
                'gps_raw' => $currentGps,
                'last_active' => 'active now',
                'is_unusual' => false,
                'unusual_message' => null,
                'is_real' => true,
            ];
            $realSessions->prepend($currentDeviceSession);
        }

        // Only genuine sessions from database, current device guaranteed at the top
        $allSessions = $realSessions->sortByDesc('is_current')->values();

        // Reset revoked sessions if explicitly requested (?reset=1)
        if ($request->has('reset')) {
            $request->session()->forget(['revoked_session_ids', 'revoked_all_others']);
        }

        // Filter out any revoked sessions
        $revokedSessions = $request->session()->get('revoked_session_ids', []);
        $revokedAllOthers = $request->session()->get('revoked_all_others', false);

        if ($revokedAllOthers) {
            $allSessions = $allSessions->where('is_current', true);
        } else {
            $allSessions = $allSessions->reject(fn($s) => in_array($s['id'], $revokedSessions));
        }

        return view('admin.sessions.index', [
            'sessions' => $allSessions->values(),
            'totalDevices' => $allSessions->count(),
            'currentGps' => $currentGps,
        ]);
    }

    /**
     * Endpoint to receive real-time GPS coordinates from browser Geolocation API.
     */
    public function updateGps(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'accuracy' => ['nullable', 'numeric'],
        ]);

        $lat = (float) $request->input('latitude');
        $lng = (float) $request->input('longitude');
        $accuracy = (float) $request->input('accuracy', 0);

        // Reverse geocode GPS coordinates to city, province, country
        $geo = $this->reverseGeocode($lat, $lng);

        $gpsData = [
            'latitude' => $lat,
            'longitude' => $lng,
            'accuracy' => $accuracy,
            'city' => $geo['city'] ?? 'Jakarta',
            'region' => $geo['region'] ?? '',
            'country' => $geo['country'] ?? 'Indonesia',
            'formatted' => $geo['formatted'] ?? "{$lat}, {$lng}",
            'source' => 'device_hardware_gps',
            'public_ip' => $request->ip() === '127.0.0.1' ? ($this->getExternalIp() ?? '127.0.0.1') : $request->ip(),
            'updated_at' => now()->toIso8601String(),
        ];

        $sessionId = $request->session()->getId();
        $request->session()->put('current_gps', $gpsData);
        Cache::put("session_gps_{$sessionId}", $gpsData, now()->addDays(7));

        return response()->json([
            'success' => true,
            'message' => 'Real-time GPS location updated successfully.',
            'gps' => $gpsData,
            'gps_display' => 'GPS: ' . round($lat, 4) . '°, ' . round($lng, 4) . '°' . ($accuracy ? ' (±' . round($accuracy) . 'm)' : ''),
            'location_display' => $gpsData['city'] . ', ' . $gpsData['country'],
        ]);
    }

    /**
     * Revoke a specific session.
     */
    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $currentSessionId = $request->session()->getId();

        if ($id === $currentSessionId) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot revoke your current active session directly from here.',
            ], 422);
        }

        // Delete from database if present
        DB::table('sessions')->where('id', $id)->delete();

        // Track in session state for demo and real consistency
        $revoked = $request->session()->get('revoked_session_ids', []);
        $revoked[] = $id;
        $request->session()->put('revoked_session_ids', array_unique($revoked));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Device session revoked successfully.',
            ]);
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Device session revoked successfully.');
    }

    /**
     * Revoke all other active sessions except current.
     */
    public function destroyOthers(Request $request): JsonResponse|RedirectResponse
    {
        $currentSessionId = $request->session()->getId();
        $adminId = Auth::guard('admin')->id();

        // Delete other sessions from database
        DB::table('sessions')
            ->where('id', '!=', $currentSessionId)
            ->where(function($q) use ($adminId) {
                $q->where('user_id', $adminId)
                  ->orWhereNull('user_id');
            })
            ->delete();

        $request->session()->put('revoked_all_others', true);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'All other active sessions have been signed out.',
            ]);
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'All other active sessions have been signed out.');
    }

    /**
     * Retrieve or initialize current GPS and location for current session.
     */
    private function getCurrentGps(Request $request, string $sessionId): array
    {
        // Check if GPS was updated via browser Geolocation API
        $cached = $request->session()->get('current_gps') ?? Cache::get("session_gps_{$sessionId}");
        if ($cached && !empty($cached['latitude'])) {
            return $cached;
        }

        // Resolve from external IP as immediate fallback
        $ip = $request->ip();
        if ($ip === '127.0.0.1' || $ip === '::1') {
            $ip = $this->getExternalIp() ?? '127.0.0.1';
        }

        $geo = $this->resolveIpLocation($ip);

        $initialGps = [
            'latitude' => $geo['latitude'] ?? -6.1898,
            'longitude' => $geo['longitude'] ?? 106.8415,
            'accuracy' => 100,
            'city' => $geo['city'] ?? 'Jakarta',
            'region' => $geo['region'] ?? 'DKI Jakarta',
            'country' => $geo['country'] ?? 'Indonesia',
            'formatted' => ($geo['city'] ?? 'Jakarta') . ', ' . ($geo['country'] ?? 'Indonesia'),
            'source' => 'ip_network',
            'public_ip' => $ip,
            'updated_at' => now()->toIso8601String(),
        ];

        $request->session()->put('current_gps', $initialGps);

        return $initialGps;
    }

    /**
     * Resolve location information from an IP address.
     */
    private function resolveIpLocation(string $ip): array
    {
        return Cache::remember("ip_geo_{$ip}", now()->addHours(6), function() use ($ip) {
            // Check for optional private IPinfo API token
            $ipinfoToken = env('IPINFO_TOKEN');
            if ($ipinfoToken && $ip !== '127.0.0.1') {
                try {
                    $resp = Http::timeout(3)->get("https://ipinfo.io/{$ip}?token={$ipinfoToken}");
                    if ($resp->successful()) {
                        $data = $resp->json();
                        $loc = explode(',', $data['loc'] ?? '');
                        return [
                            'city' => $data['city'] ?? 'Jakarta',
                            'region' => $data['region'] ?? '',
                            'country' => $data['country'] ?? 'ID',
                            'latitude' => isset($loc[0]) ? (float) $loc[0] : null,
                            'longitude' => isset($loc[1]) ? (float) $loc[1] : null,
                        ];
                    }
                } catch (\Throwable $e) {
                    // fall through to free provider
                }
            }

            // Free IP Geolocation via ip-api.com
            try {
                $queryUrl = ($ip === '127.0.0.1' || $ip === '::1')
                    ? 'http://ip-api.com/json/?fields=status,country,city,regionName,lat,lon,query'
                    : "http://ip-api.com/json/{$ip}?fields=status,country,city,regionName,lat,lon,query";

                $resp = Http::timeout(3)->get($queryUrl);
                if ($resp->successful() && ($resp->json('status') === 'success')) {
                    return [
                        'city' => $resp->json('city') ?? 'Jakarta',
                        'region' => $resp->json('regionName') ?? '',
                        'country' => $resp->json('country') ?? 'Indonesia',
                        'latitude' => (float) $resp->json('lat'),
                        'longitude' => (float) $resp->json('lon'),
                    ];
                }
            } catch (\Throwable $e) {
                // fall back to default
            }

            return [
                'city' => 'Jakarta',
                'region' => 'DKI Jakarta',
                'country' => 'Indonesia',
                'latitude' => -6.1898,
                'longitude' => 106.8415,
            ];
        });
    }

    /**
     * Reverse geocode latitude and longitude to human address.
     */
    private function reverseGeocode(float $lat, float $lng): array
    {
        // 1. Check for optional Google Maps Geocoding API Key
        $googleKey = env('GOOGLE_MAPS_GEOCODING_KEY');
        if ($googleKey) {
            try {
                $resp = Http::timeout(4)->get("https://maps.googleapis.com/maps/api/geocode/json", [
                    'latlng' => "{$lat},{$lng}",
                    'key' => $googleKey,
                ]);
                if ($resp->successful() && !empty($resp->json('results'))) {
                    $result = $resp->json('results')[0];
                    $city = 'Jakarta';
                    $country = 'Indonesia';
                    foreach ($result['address_components'] as $comp) {
                        if (in_array('locality', $comp['types'])) {
                            $city = $comp['long_name'];
                        }
                        if (in_array('country', $comp['types'])) {
                            $country = $comp['long_name'];
                        }
                    }
                    return [
                        'city' => $city,
                        'country' => $country,
                        'formatted' => $result['formatted_address'],
                        'provider' => 'google_maps',
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning('Google Geocoding error: ' . $e->getMessage());
            }
        }

        // 2. Default: OpenStreetMap Nominatim (Zero API Key required)
        try {
            $resp = Http::withHeaders([
                'User-Agent' => 'UnivNewsCMS/1.0 (admin-security-session)',
            ])->timeout(4)->get("https://nominatim.openstreetmap.org/reverse", [
                'format' => 'jsonv2',
                'lat' => $lat,
                'lon' => $lng,
            ]);

            if ($resp->successful()) {
                $data = $resp->json();
                $addr = $data['address'] ?? [];
                $city = $addr['city'] ?? $addr['town'] ?? $addr['county'] ?? $addr['suburb'] ?? 'Jakarta';
                $region = $addr['state'] ?? $addr['region'] ?? '';
                $country = $addr['country'] ?? 'Indonesia';

                return [
                    'city' => $city,
                    'region' => $region,
                    'country' => $country,
                    'formatted' => $data['display_name'] ?? "{$city}, {$country}",
                    'provider' => 'openstreetmap',
                ];
            }
        } catch (\Throwable $e) {
            Log::warning('Nominatim reverse geocode error: ' . $e->getMessage());
        }

        return [
            'city' => 'Jakarta',
            'region' => 'DKI Jakarta',
            'country' => 'Indonesia',
            'formatted' => "GPS: {$lat}, {$lng}",
            'provider' => 'fallback',
        ];
    }

    /**
     * Resolve developer external IP when testing on localhost.
     */
    private function getExternalIp(): ?string
    {
        return Cache::remember('server_external_ip', now()->addHours(6), function() {
            try {
                $resp = Http::timeout(2)->get('https://api.ipify.org?format=json');
                if ($resp->successful()) {
                    return $resp->json('ip');
                }
            } catch (\Throwable $e) {
                // Ignore
            }
            return null;
        });
    }

    /**
     * Parse User-Agent string to detect device type, OS, and browser.
     */
    private function parseDeviceInfo(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'device' => 'Windows 11 · Chrome',
                'type' => 'desktop',
                'os' => 'Windows 11',
                'browser' => 'Chrome',
            ];
        }

        $type = 'desktop';
        $os = 'Unknown OS';
        $browser = 'Browser';

        // OS detection
        if (preg_match('/iPhone/i', $userAgent)) {
            $type = 'mobile';
            $os = 'iPhone';
            if (preg_match('/iPhone OS ([\d_]+)/i', $userAgent, $m)) {
                $os = 'iPhone (iOS ' . str_replace('_', '.', $m[1]) . ')';
            }
        } elseif (preg_match('/iPad/i', $userAgent)) {
            $type = 'tablet';
            $os = 'iPad';
            if (preg_match('/CPU OS ([\d_]+)/i', $userAgent, $m)) {
                $os = 'iPad (iPadOS ' . str_replace('_', '.', $m[1]) . ')';
            }
        } elseif (preg_match('/Android/i', $userAgent)) {
            $type = preg_match('/Mobile/i', $userAgent) ? 'mobile' : 'tablet';
            $os = 'Android';
            if (preg_match('/Android ([\d.]+)/i', $userAgent, $m)) {
                $os = 'Android ' . $m[1];
            }
        } elseif (preg_match('/Windows NT 10\.0/i', $userAgent)) {
            $type = 'desktop';
            $os = 'Windows 11 · Chrome'; // Standard modern Windows presentation
            // Refine if other browser
            if (preg_match('/Firefox/i', $userAgent)) {
                $os = 'Windows 11';
            } elseif (preg_match('/Edg/i', $userAgent)) {
                $os = 'Windows 11';
            } else {
                $os = 'Windows 11';
            }
        } elseif (preg_match('/Windows NT 6\./i', $userAgent) || preg_match('/Windows/i', $userAgent)) {
            $type = 'desktop';
            $os = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $type = 'desktop';
            $os = 'MacBook Pro';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $type = 'desktop';
            $os = 'Linux';
        }

        // Browser detection
        if (preg_match('/Edg\/([\d.]+)/i', $userAgent, $m)) {
            $browser = 'Edge ' . explode('.', $m[1])[0];
        } elseif (preg_match('/Chrome\/([\d.]+)/i', $userAgent, $m) && !preg_match('/Edg/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox\/([\d.]+)/i', $userAgent, $m)) {
            $browser = 'Firefox ' . explode('.', $m[1])[0];
        } elseif (preg_match('/Version\/([\d.]+).*Safari/i', $userAgent, $m)) {
            $browser = 'Safari ' . explode('.', $m[1])[0];
        } elseif (preg_match('/WindowsPowerShell|curl|Postman/i', $userAgent)) {
            $type = 'cli';
            $browser = 'CLI Runner';
        }

        $device = $os . ' · ' . $browser;

        return [
            'device' => $device,
            'type' => $type,
            'os' => $os,
            'browser' => $browser,
        ];
    }
}
