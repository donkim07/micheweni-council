<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Location\Facades\Location;

class VisitorCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'visited_at',
        'page',
        'country',
        'city',
        'latitude',
        'longitude',
        'region'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    /**
     * Record a new visit with geolocation
     *
     * @param string|null $page
     * @return VisitorCounter
     */
    public static function recordVisit($page = null)
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();
        $path = $page ?? request()->path();
        
        // Try to get geolocation data
        $data = [
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'visited_at' => now(),
            'page' => $path
        ];
        
        try {
            // Use Stevebauman/Location or any other IP geolocation package
            // Note: For local testing, this will not work with 127.0.0.1
            $geoLocation = Location::get($ip);
            if ($geoLocation) {
                $data['country'] = $geoLocation->countryName ?? null;
                $data['city'] = $geoLocation->cityName ?? null;
                $data['latitude'] = $geoLocation->latitude ?? null;
                $data['longitude'] = $geoLocation->longitude ?? null;
                $data['region'] = $geoLocation->regionName ?? null;
            }
        } catch (\Exception $e) {
            // Just continue without geolocation data
        }
        
        return self::create($data);
    }

    /**
     * Get total visitor count
     *
     * @return int
     */
    public static function getTotalVisits()
    {
        return self::count();
    }

    /**
     * Get unique visitor count
     *
     * @return int
     */
    public static function getUniqueVisits()
    {
        return self::distinct('ip_address')->count('ip_address');
    }

    /**
     * Get today's visitor count
     *
     * @return int
     */
    public static function getTodayVisits()
    {
        return self::whereDate('visited_at', today())->count();
    }
} 