<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplatesController extends Controller
{
    /**
     * Display various templates for government pages
     */
    public function showTemplate($section, $template = null)
    {
        // Handle pages with sub-sections like about.history
        if ($template) {
            $viewPath = "government.{$section}.{$template}";
        } else {
            $viewPath = "government.{$section}";
        }
        
        // Check if view exists
        if (view()->exists($viewPath)) {
            return view($viewPath);
        }
        
        return abort(404, "View [{$viewPath}] not found.");
    }
    
    /**
     * Display the services template
     */
    public function services()
    {
        return view('opportunities.circular-economy.services.index');
    }
    
    /**
     * Display the service detail template
     */
    public function serviceDetail()
    {
        return view('opportunities.circular-economy.services.show');
    }
    
    /**
     * Display the projects template
     */
    public function projects()
    {
        return view('opportunities.circular-economy.projects.index');
    }
    
    /**
     * Display the project detail template
     */
    public function projectDetail()
    {
        return view('opportunities.circular-economy.projects.show');
    }
    
    /**
     * Display the publications template
     */
    public function publications()
    {
        return view('opportunities.circular-economy.publications.index');
    }
    
    /**
     * Display the publication detail template
     */
    public function publicationDetail()
    {
        return view('opportunities.circular-economy.publications.show');
    }
    
    /**
     * Display the news template
     */
    public function news()
    {
        return view('opportunities.circular-economy.news.index');
    }
    
    /**
     * Display the news detail template
     */
    public function newsDetail()
    {
        return view('opportunities.circular-economy.news.show');
    }
    
    /**
     * Display the media gallery template
     */
    public function mediaGallery()
    {
        return view('opportunities.circular-economy.media.gallery');
    }
    
    /**
     * Display the media videos template
     */
    public function mediaVideos()
    {
        return view('opportunities.circular-economy.media.videos');
    }
} 