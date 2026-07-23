<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Announcement;
use App\Models\Government\Department;
use App\Models\Government\News;
use App\Models\Government\Project;
use App\Models\Government\Service;
use App\Models\Government\Statistics;
use App\Models\Government\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the government dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Count the number of each entity
        $departmentsCount = Department::count();
        $servicesCount = Service::count();
        $projectsCount = Project::count();
        $newsCount = News::count();
        
        // Count news with announcements category
        $announcementsCount = News::whereHas('category', function($query) {
            $query->where('name', 'like', '%announcements%')->orWhere('slug', 'like', '%announcements%');
        })->count();
        
        $testimonialsCount = Testimonial::count();
        
        // Get statistics
        $statistics = Statistics::featured()->get();
        
        // Get recent items for quick access
        $recentDepartments = Department::latest('updated_at')->take(5)->get();
        $recentServices = Service::latest('updated_at')->take(5)->get();
        $recentProjects = Project::latest('updated_at')->take(5)->get();
        $recentNews = News::latest('updated_at')->take(5)->get();
        
        // Get active announcements
        $activeAnnouncements = Announcement::active()->latest()->take(5)->get();
        // Get news with announcement category
        $announcementNews = News::whereHas('category', function($query) {
            $query->where('name', 'like', '%announcements%')->orWhere('slug', 'like', '%announcements%');
        })->where('status', 'published')->latest('published_at')->take(5)->get();
        
        return view('admin.government.dashboard', compact(
            'departmentsCount',
            'servicesCount',
            'projectsCount',
            'newsCount',
            'announcementsCount',
            'testimonialsCount',
            'statistics',
            'recentDepartments',
            'recentServices',
            'recentProjects',
            'recentNews',
            'announcementNews',
            'activeAnnouncements'
        ));
    }
} 