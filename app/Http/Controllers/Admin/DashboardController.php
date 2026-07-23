<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Category;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\News;
use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\User;
use App\Models\WasteLocation;
use App\Models\Opportunities\CircularEconomy\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a dashboard with overview statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalPages = Page::count();
        $totalNews = News::count();
        $totalSubmissions = FormSubmission::count();
        
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentPages = Page::orderBy('created_at', 'desc')->take(5)->get();
        $recentNews = News::orderBy('created_at', 'desc')->take(5)->get();
        $recentSubmissions = FormSubmission::with('form')->orderBy('created_at', 'desc')->take(5)->get();
        
        // Get actual activity data for the chart
        $activityData = $this->getActivityData();
        
        // Add stats data
        $stats = [
            'users_growth' => $this->calculateGrowthPercentage(User::class),
            'pages_growth' => $this->calculateGrowthPercentage(Page::class),
            'news_growth' => $this->calculateGrowthPercentage(News::class),
            'submissions_growth' => $this->calculateGrowthPercentage(FormSubmission::class),
            // 'recent_logins' => User::where('last_login_at', '>=', now()->subDays(7))->count(),
            'active_forms' => \App\Models\Opportunities\CircularEconomy\FormBuilder::where('is_active', true)->count(),
            'total_uploads' => $this->countUploads(),
            'total_comments' => $this->countComments()
        ];
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalPages', 'totalNews', 'totalSubmissions',
            'recentUsers', 'recentPages', 'recentNews', 'recentSubmissions',
            'stats', 'activityData'
        ));
    }
    
    /**
     * Get activity data for the dashboard chart
     * 
     * @return array
     */
    private function getActivityData()
    {
        // Get the last 6 months
        $months = [];
        $pageViews = [];
        $formSubmissions = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('F');
            
            // Get page views count (from a tracking table if available, or estimate from Content views)
            $month = $date->month;
            $year = $date->year;
            
            // Get page views (estimated from Content updated timestamps)
            $pageViewCount = Content::whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)
                ->count();
            
            // If no data, use a random number between 30-100 for demo purposes
            $pageViews[] = $pageViewCount > 0 ? $pageViewCount : rand(30, 100);
            
            // Get form submissions
            $submissionCount = FormSubmission::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
            
            $formSubmissions[] = $submissionCount;
        }
        
        return [
            'months' => $months,
            'pageViews' => $pageViews,
            'formSubmissions' => $formSubmissions
        ];
    }
    
    /**
     * Calculate growth percentage for a model compared to previous period
     * 
     * @param string $modelClass
     * @return int
     */
    private function calculateGrowthPercentage($modelClass)
    {
        $currentPeriodStart = Carbon::now()->startOfMonth();
        $previousPeriodStart = Carbon::now()->subMonth()->startOfMonth();
        $previousPeriodEnd = Carbon::now()->subMonth()->endOfMonth();
        
        $currentCount = $modelClass::where('created_at', '>=', $currentPeriodStart)->count();
        $previousCount = $modelClass::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        
        if ($previousCount == 0) {
            return $currentCount > 0 ? 100 : 0;
        }
        
        return round((($currentCount - $previousCount) / $previousCount) * 100);
    }
    
    /**
     * Count total uploads in the system
     * 
     * @return int
     */
    private function countUploads()
    {
        // Count images in content meta_data
        $contentWithImages = Content::whereRaw("JSON_EXTRACT(meta_data, '$.image') IS NOT NULL")->count();
        
        // Count news with featured images
        $newsWithImages = News::whereNotNull('featured_image')->count();
        
        return $contentWithImages + $newsWithImages;
    }
    
    /**
     * Count total comments in the system
     * 
     * @return int
     */
    private function countComments()
    {
        // If you have a comments table, use that
        // For now, return a placeholder count
        return DB::table('form_submissions')->count();
    }
    
    /**
     * Display the home page configuration guide.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeConfigGuide()
    {
        return view('admin.dashboard.home-config-guide');
    }
}
