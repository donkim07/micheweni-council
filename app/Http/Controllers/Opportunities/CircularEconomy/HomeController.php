<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\News;
use App\Models\Opportunities\CircularEconomy\WasteLocation;
use App\Models\Opportunities\CircularEconomy\Country;
use App\Models\Opportunities\CircularEconomy\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get hero section content
        $heroSection = Content::where('type', 'hero')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();
            
        // Get about section
        $aboutSection = Content::where('type', 'about')
            ->where('is_active', true)
            ->first();
            
        // Get services section
        $servicesSection = Content::where('type', 'service')
            ->where('is_active', true)
            ->where('section', 'heading')
            ->first();
            
        // Get map section
        $mapSection = Content::where('type', 'map')
            ->where('is_active', true)
            ->first();
            
        // Get news section
        $newsSection = Content::where('type', 'news')
            ->where('section', 'heading')
            ->where('is_active', true)
            ->first();
        
        // Get global snapshot section
        $snapshotSection = Content::where('type', 'snapshot')
            ->where('is_active', true)
            ->first();
            
        // Get featured content for services
        $featuredContent = Content::where('is_featured', true)
            ->where('is_active', true)
            ->where('type', 'service')
            ->where('section', 'content')
            ->orderBy('sort_order')
            ->take(6)
            ->get();
            
        // Get latest news
        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        // Get waste locations
        $wasteLocations = WasteLocation::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        // Get countries for leaderboard
        $countries = Country::where('is_featured', true)
            ->orderBy('ranking')
            ->take(5)
            ->get();
            
        // Get achievements
        $achievements = Achievement::where('is_featured', true)
            ->orderBy('display_order')
            ->take(3)
            ->get();
            
        // Get statistics - from actual data if available, otherwise fallback to defaults
        $localCountry = Country::where('is_local', true)->first();
        
        $stats = [
            'recycling_rate' => $localCountry ? $localCountry->circular_material_use_rate : 45, // Percentage
            'waste_reduction' => 30, // Percentage
            'community_participation' => 75, // Percentage
            'collection_points' => $wasteLocations->where('type', 'collection_point')->count(),
            'recycling_centers' => $wasteLocations->where('type', 'recycling_center')->count(),
            'transfer_stations' => $wasteLocations->where('type', 'transfer_station')->count(),
        ];
            
        return view('opportunities.circular-economy.home', compact(
            'heroSection',
            'aboutSection',
            'servicesSection',
            'mapSection',
            'newsSection',
            'snapshotSection',
            'featuredContent',
            'latestNews',
            'wasteLocations',
            'achievements',
            'countries',
            'stats'
        ));
    }
} 