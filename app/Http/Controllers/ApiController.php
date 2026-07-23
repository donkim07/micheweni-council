<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\VisitorCounter;

class ApiController extends Controller
{
    /**
     * Get Google Maps API key
     *
     * @return JsonResponse
     */
    public function getGoogleMapsApiKey(): JsonResponse
    {
        $apiKey = config('services.google_maps.api_key');
        
        // Only return the key if the request is from our own domain
        if (!$this->isValidRequest()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }
        
        return response()->json([
            'api_key' => $apiKey,
            'success' => true
        ]);
    }
    
    /**
     * Check if the request is valid (from our own domain)
     *
     * @return bool
     */
    private function isValidRequest(): bool
    {
        $referer = request()->header('referer');
        $host = request()->getHost();
        
        // If no referer or doesn't contain our host, reject
        if (empty($referer) || !str_contains($referer, $host)) {
            Log::warning('Invalid API key request', [
                'referer' => $referer,
                'ip' => request()->ip()
            ]);
            return false;
        }
        
        return true;
    }
    
    /**
     * Test endpoint
     *
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'message' => 'API is working',
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    /**
     * Get visitor locations for the world map
     *
     * @return JsonResponse
     */
    public function visitorLocations(): JsonResponse
    {
        // Ensure request is valid
        if (!$this->isValidRequest()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            // Fetch visitor data from database, limited to recent unique IPs
            $visitors = DB::table('visitor_counters')
                ->select('ip_address', 'country', 'latitude', 'longitude', 'city', DB::raw('COUNT(*) as visit_count'))
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->groupBy('ip_address', 'country', 'latitude', 'longitude', 'city')
                ->orderBy('visit_count', 'desc')
                ->limit(15)
                ->get();

            $markers = [];
            
            // Transform visitor data into map markers
            foreach ($visitors as $visitor) {
                if (!empty($visitor->latitude) && !empty($visitor->longitude)) {
                    $location = $visitor->city ? $visitor->city : ($visitor->country ?? 'Unknown');
                    $markers[] = [
                        'latLng' => [(float)$visitor->latitude, (float)$visitor->longitude],
                        'name' => $location . ': ' . $visitor->visit_count . ' visits'
                    ];
                }
            }
            
            // Always include Micheweni
            $weteAdded = false;
            foreach ($markers as $marker) {
                if ($marker['latLng'][0] == -5.0561 && $marker['latLng'][1] == 39.7303) {
                    $weteAdded = true;
                    break;
                }
            }
            
            if (!$weteAdded) {
                $markers[] = [
                    'latLng' => [-5.0561, 39.7303],
                    'name' => 'Micheweni, Pemba'
                ];
            }

            return response()->json($markers);
        } catch (\Exception $e) {
            Log::error('Error fetching visitor locations: ' . $e->getMessage());
            
            // Return default markers if there's an error
            return response()->json([
                ['latLng' => [-5.0561, 39.7303], 'name' => 'Micheweni, Pemba'],
                ['latLng' => [35.6762, 139.6503], 'name' => 'Tokyo, Japan'],
                ['latLng' => [51.5074, -0.1278], 'name' => 'London, UK'],
                ['latLng' => [40.7128, -74.0060], 'name' => 'New York, USA'],
                ['latLng' => [-33.8688, 151.2093], 'name' => 'Sydney, Australia'],
                ['latLng' => [55.7558, 37.6173], 'name' => 'Moscow, Russia'],
                ['latLng' => [-1.2921, 36.8219], 'name' => 'Nairobi, Kenya']
            ]);
        }
    }
} 