<?php

namespace App\Models\Government;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteConfig extends Model
{
    use HasFactory;

    protected $table = 'site_configs';
    
    protected $fillable = [
        'config_key',
        'config_value',
        'config_group',
        'is_json',
        'description'
    ];

    protected $casts = [
        'is_json' => 'boolean',
    ];

    /**
     * Get config value, automatically decoding JSON if necessary
     *
     * @return mixed
     */
    public function getValueAttribute()
    {
        if ($this->is_json) {
            return json_decode($this->config_value, true);
        }
        
        return $this->config_value;
    }

    /**
     * Set a configuration value
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param bool $isJson
     * @param string|null $description
     * @return SiteConfig
     */
    public static function setConfig(string $key, $value, string $group = 'general', bool $isJson = false, ?string $description = null)
    {
        // Clear cache for this key
        Cache::forget("site_config:{$key}");
        
        // Convert array/object values to JSON
        $configValue = $isJson ? json_encode($value) : $value;
        
        // Find existing or create new
        $config = self::updateOrCreate(
            ['config_key' => $key],
            [
                'config_value' => $configValue,
                'config_group' => $group,
                'is_json' => $isJson,
                'description' => $description
            ]
        );
        
        return $config;
    }
    
    /**
     * Get a configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getConfig(string $key, $default = null)
    {
        return Cache::remember("site_config:{$key}", 3600, function() use ($key, $default) {
            $config = self::where('config_key', $key)->first();
            
            if (!$config) {
                return $default;
            }
            
            return $config->is_json ? json_decode($config->config_value, true) : $config->config_value;
        });
    }
    
    /**
     * Get contact information
     *
     * @return array
     */
    public static function getContactInfo()
    {
        $default = [
            'address' => 'Micheweni District Council, Pemba, Zanzibar',
            'phones' => ['+255 777 123 456', '+255 777 654 321'],
            'emails' => ['info@micheweni.go.tz', 'support@micheweni.go.tz'],
            'social_media' => [
                'facebook' => 'https://www.facebook.com/WeteCouncil',
                'twitter' => 'https://twitter.com/WeteCouncil',
                'instagram' => 'https://www.instagram.com/WeteCouncil'
            ],
            'working_hours' => 'Monday - Friday: 8:00 AM - 4:00 PM'
        ];
        
        return self::getConfig('contact_info', $default);
    }
    
    /**
     * Get social media links
     *
     * @return array
     */
    public static function getSocialLinks()
    {
        $default = [
            'facebook' => 'https://facebook.com/wetecouncil',
            'twitter' => 'https://twitter.com/wetecouncil',
            'instagram' => 'https://instagram.com/wetecouncil',
            'youtube' => 'https://youtube.com/wetecouncil',
            'linkedin' => 'https://linkedin.com/company/wetecouncil'
        ];
        
        return self::getConfig('social_links', $default);
    }
    
    /**
     * Get leadership information
     *
     * @return array
     */
    public static function getLeadership()
    {
        $default = [
            'commissioner' => [
                'name' => 'Mhe. MOHAMMED ABOUD MOHAMMED',
                'title' => 'MKUU WA WILAYA YA MICHEWENI',
                'image' => 'images/government/commissioner.jpg',
                'email' => 'commissioner@micheweni.go.tz',
                'phone' => '+255 777 123 456',
                'office' => "District Commissioner's Office, Micheweni",
                'bio' => "Hon. Mohammed Aboud has been serving as the District Commissioner of Micheweni since 2020. With over 15 years of experience in public administration, he has led numerous initiatives to improve service delivery and enhance the quality of life for Micheweni residents."
            ],
            'director' => [
                'name' => 'Bi. SAADA ALLY NASSOR',
                'title' => 'MKURUGENZI WA HALMASHAURI YA WILAYA YA MICHEWENI',
                'image' => 'images/government/director.jpg',
                'email' => 'director@micheweni.go.tz',
                'phone' => '+255 777 654 321',
                'office' => "District Executive Director's Office, Micheweni",
                'bio' => "Dr. Saada Ally brings a wealth of experience in public administration and management to her role as the District Executive Director. She is responsible for overseeing all administrative functions and ensuring efficient service delivery to citizens."
            ]
        ];
        
        return self::getConfig('leadership', $default);
    }
    
    /**
     * Get statistics for homepage
     *
     * @return array
     */
    public static function getStats()
    {
        $default = [
            'population' => 95000,
            'businesses' => 250,
            'schools' => 45,
            'health_centers' => 12
        ];
        
        return self::getConfig('stats', $default);
    }
} 