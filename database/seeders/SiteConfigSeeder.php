<?php

namespace Database\Seeders;

use App\Models\Government\SiteConfig;
use Illuminate\Database\Seeder;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contact Information
        $contactInfo = [
            'address' => 'Micheweni District Council, P.O. Box 150, Micheweni, Pemba, Zanzibar',
            'phones' => ['+255 24 245 2003', '+255 777 123 456'],
            'emails' => ['info@micheweni.go.tz', 'director@micheweni.go.tz'],
            'working_hours' => 'Monday - Friday: 8:00 AM - 4:00 PM'
        ];
        
        SiteConfig::setConfig(
            'contact_info',
            $contactInfo,
            'contact',
            true,
            'Contact information displayed throughout the site'
        );
        
        // Social Media Links
        $socialLinks = [
            'facebook' => 'https://facebook.com/wetecouncil',
            'twitter' => 'https://twitter.com/wetecouncil',
            'instagram' => 'https://instagram.com/wetecouncil',
            'youtube' => 'https://youtube.com/wetecouncil',
            'linkedin' => 'https://linkedin.com/company/wetecouncil'
        ];
        
        SiteConfig::setConfig(
            'social_links',
            $socialLinks,
            'social',
            true,
            'Social media links'
        );
        
        // Leadership Information
        $leadership = [
            'commissioner' => [
                'name' => 'Mhe. SONGORO H. MNYONGE',
                'title' => 'MSTAHIKI MEYA WA MANISPAA YA PEMBA',
                'image' => 'images/government/commissioner.jpg',
                'email' => 'commissioner@micheweni.go.tz',
                'phone' => '+255 777 123 456',
                'office' => "District Commissioner's Office, Micheweni",
                'bio' => "Hon. Abdallah Mohamed has been serving as the District Commissioner of Micheweni since 2020. With over 15 years of experience in public administration, he has led numerous initiatives to improve service delivery and enhance the quality of life for Micheweni residents. He holds a Master's degree in Public Administration from the University of Dar es Salaam and is committed to transforming Micheweni into a model district through sustainable development practices and inclusive governance."
            ],
            'director' => [
                'name' => 'Bi. HANIFA SULEIMAN HAMZA',
                'title' => 'MKURUGENZI WA MANISPAA YA PEMBA',
                'image' => 'images/government/director.jpg',
                'email' => 'director@micheweni.go.tz',
                'phone' => '+255 777 654 321',
                'office' => "District Executive Director's Office, Micheweni",
                'bio' => "Dr. Fatma Hussein brings a wealth of experience in public administration and management to her role as the District Executive Director. She is responsible for overseeing all administrative functions and ensuring efficient service delivery to citizens. She holds a PhD in Public Administration and has previously worked with international organizations on governance and development projects."
            ]
        ];
        
        SiteConfig::setConfig(
            'leadership',
            $leadership,
            'leadership',
            true,
            'Leadership information for Commissioner and Director'
        );
        
        // Statistics
        $stats = [
            'population' => 95000,
            'businesses' => 250,
            'schools' => 45,
            'health_centers' => 12
        ];
        
        SiteConfig::setConfig(
            'stats',
            $stats,
            'stats',
            true,
            'Statistics counters for homepage'
        );
    }
} 