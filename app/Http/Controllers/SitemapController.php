<?php

namespace App\Http\Controllers;

use App\Models\Government\Announcement;
use App\Models\Government\Department;
use App\Models\Government\Project;
use App\Models\Government\Publication;
use App\Models\Government\Service;
use App\Models\Government\News;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url as SitemapUrl;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap for search engines
     */
    public function xml()
    {
        $sitemap = Sitemap::create();

        // Add static routes
        $sitemap->add(URL::to('/'));
        $sitemap->add(URL::to('/government'));
        $sitemap->add(URL::to('/government/about'));
        $sitemap->add(URL::to('/government/contact'));
        $sitemap->add(URL::to('/government/services'));
        $sitemap->add(URL::to('/government/news'));
        $sitemap->add(URL::to('/government/projects'));
        $sitemap->add(URL::to('/government/departments'));
        $sitemap->add(URL::to('/government/publications'));
        $sitemap->add(URL::to('/government/media'));
        $sitemap->add(URL::to('/opportunities'));
        $sitemap->add(URL::to('/opportunities/circular-economy'));
        $sitemap->add(URL::to('/login'));
        $sitemap->add(URL::to('/register'));
        $sitemap->add(URL::to('/sitemap'));
        
        // Add dynamic content
        // News
        $news = News::all();
        foreach ($news as $item) {
            $sitemap->add(URL::to('/government/news/' . $item->id));
        }
        
        // Departments
        $departments = Department::all();
        foreach ($departments as $item) {
            $sitemap->add(URL::to('/government/departments/' . $item->id));
        }
        
        // Services
        $services = Service::all();
        foreach ($services as $item) {
            $sitemap->add(URL::to('/government/services/' . $item->id));
        }
        
        // Projects
        $projects = Project::all();
        foreach ($projects as $item) {
            $sitemap->add(URL::to('/government/projects/' . $item->id));
        }
        
        // Publications
        $publications = Publication::all();
        foreach ($publications as $item) {
            $sitemap->add(URL::to('/government/publications/' . $item->id));
        }
        
        // Announcements
        $announcements = Announcement::all();
        foreach ($announcements as $item) {
            $sitemap->add(URL::to('/government/announcements/' . $item->id));
        }
        
        // Opportunities
        $opportunities = Opportunity::all();
        foreach ($opportunities as $item) {
            $sitemap->add(URL::to('/opportunities/' . $item->id));
        }
        
        // Circular Economy Content
        $ceContents = Content::all();
        foreach ($ceContents as $item) {
            $sitemap->add(URL::to('/opportunities/circular-economy/content/' . $item->id));
        }

        // Return the sitemap
        return $sitemap->toResponse(request());
    }

    /**
     * Generate HTML sitemap for users
     */
    public function index()
    {
        // Get all public routes
        $publicRoutes = $this->getPublicRoutes();
        
        // Get admin routes if user is admin
        $adminRoutes = [];
        if (Auth::check() && Auth::user()->roles && Auth::user()->roles->contains('name', 'admin')) {
            $adminRoutes = $this->getAdminRoutes();
        }
        
        // Get dynamic content
        $news = News::all();
        $departments = Department::all();
        $services = Service::all();
        $projects = Project::all();
        $publications = Publication::all();
        $announcements = Announcement::all();
        $opportunities = Opportunity::all();
        $ceContents = Content::all();
        
        return view('sitemap', compact(
            'publicRoutes', 
            'adminRoutes', 
            'news', 
            'departments', 
            'services', 
            'projects', 
            'publications', 
            'announcements', 
            'opportunities', 
            'ceContents'
        ));
    }
    
    /**
     * Get all public routes for the sitemap
     */
    private function getPublicRoutes()
    {
        return [
            'Main' => [
                ['url' => '/', 'title' => 'Home'],
                ['url' => '/sitemap', 'title' => 'Sitemap'],
                ['url' => '/login', 'title' => 'Login'],
                ['url' => '/register', 'title' => 'Register'],
            ],
            'Government' => [
                ['url' => '/government', 'title' => 'Government Portal'],
                ['url' => '/government/about', 'title' => 'About Us'],
                ['url' => '/government/about/leadership', 'title' => 'Leadership'],
                ['url' => '/government/about/history', 'title' => 'History'],
                ['url' => '/government/contact', 'title' => 'Contact Us'],
                ['url' => '/government/services', 'title' => 'Services'],
                ['url' => '/government/news', 'title' => 'News'],
                ['url' => '/government/projects', 'title' => 'Projects'],
                ['url' => '/government/departments', 'title' => 'Departments'],
                ['url' => '/government/publications', 'title' => 'Publications'],
                ['url' => '/government/media', 'title' => 'Media Gallery'],
                ['url' => '/government/announcements', 'title' => 'Announcements'],
                ['url' => '/government/search', 'title' => 'Search'],
            ],
            'Opportunities' => [
                ['url' => '/opportunities', 'title' => 'Opportunities Portal'],
                ['url' => '/opportunities/circular-economy', 'title' => 'Circular Economy'],
                ['url' => '/opportunities/applications', 'title' => 'My Applications'],
                ['url' => '/opportunities/saved', 'title' => 'Saved Opportunities'],
                ['url' => '/opportunities/about', 'title' => 'About Opportunities'],
            ],
        ];
    }
    
    /**
     * Get all admin routes for the sitemap
     */
    private function getAdminRoutes()
    {
        return [
            'Admin Dashboard' => [
                ['url' => '/admin/dashboard', 'title' => 'Dashboard'],
                ['url' => '/admin/profile', 'title' => 'My Profile'],
            ],
            'Content Management' => [
                ['url' => '/admin/pages', 'title' => 'Pages'],
                ['url' => '/admin/news', 'title' => 'News'],
                ['url' => '/admin/categories', 'title' => 'Categories'],
                ['url' => '/admin/contents', 'title' => 'Content Blocks'],
            ],
            'Government Management' => [
                ['url' => '/admin/government/departments', 'title' => 'Departments'],
                ['url' => '/admin/government/services', 'title' => 'Services'],
                ['url' => '/admin/government/projects', 'title' => 'Projects'],
                ['url' => '/admin/government/publications', 'title' => 'Publications'],
                ['url' => '/admin/government/announcements', 'title' => 'Announcements'],
                ['url' => '/admin/government/media', 'title' => 'Media Gallery'],
            ],
            'Opportunities Management' => [
                ['url' => '/admin/opportunities', 'title' => 'Opportunities'],
                ['url' => '/admin/opportunities/categories', 'title' => 'Categories'],
                ['url' => '/admin/opportunities/applications', 'title' => 'Applications'],
            ],
            'System Management' => [
                ['url' => '/admin/users', 'title' => 'Users'],
                ['url' => '/admin/roles', 'title' => 'Roles'],
                ['url' => '/admin/permissions', 'title' => 'Permissions'],
                ['url' => '/admin/form-builders', 'title' => 'Form Builders'],
                ['url' => '/admin/form-submissions', 'title' => 'Form Submissions'],
                ['url' => '/admin/waste-locations', 'title' => 'Waste Locations'],
                ['url' => '/admin/newsletter-subscriptions', 'title' => 'Newsletter Subscriptions'],
            ],
        ];
    }
} 