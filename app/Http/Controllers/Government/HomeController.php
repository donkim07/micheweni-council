<?php

namespace App\Http\Controllers\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Announcement;
use App\Models\Government\Department;
use App\Models\Government\News;
use App\Models\Government\NewsCategory;
use App\Models\Government\NewsTag;
use App\Models\Government\Project;
use App\Models\Government\ProjectCategory;
use App\Models\Government\Service;
use App\Models\Government\Statistics;
use App\Models\Government\Testimonial;
use App\Models\Government\SiteConfig;
use App\Models\VisitorCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class HomeController extends Controller
{
    /**
     * Shared data for all views
     *
     * @var array
     */
    protected $sharedData = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Get visitor statistics for all views
        $visitorStats = [
            'total' => VisitorCounter::getTotalVisits(),
            'unique' => VisitorCounter::getUniqueVisits(),
            'today' => VisitorCounter::getTodayVisits()
        ];
        
        // Get social links for all views
        $socialLinks = SiteConfig::getSocialLinks();
        
        // Get contact info for all views
        $siteContactInfo = SiteConfig::getContactInfo();
        
        // Set up shared data
        $this->sharedData = [
            'visitorStats' => $visitorStats,
            'socialLinks' => $socialLinks,
            'siteContactInfo' => $siteContactInfo
        ];
        
        // Share data with all views
        view()->share($this->sharedData);
    }

    /**
     * Display the government portal homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Record visit
        VisitorCounter::recordVisit('government/home');
        
        // Get featured services
        $services = Service::active()
            ->featured()
            ->orderBy('order')
            ->take(6)
            ->get();
            
        // Get featured projects
        $projects = Project::active()
            ->featured()
            ->latest()
            ->take(3)
            ->get();
            
        // Get latest news
        $latestNews = News::where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();
            
        // Get featured testimonials
        $testimonials = Testimonial::active()
            ->featured()
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        // Get featured statistics
        $statistics = Statistics::featured()
            ->orderBy('order')
            ->take(4)
            ->get();
            
        // Get active announcements for the ticker at the top - force eager loading to avoid lazy loading issues
        $announcements = Announcement::where('status', 'active')
            ->orderByDesc('priority')
            ->take(5)
            ->get();
            
        // Get ticker news for the ribbon at the top of the page
        $tickerNews = News::where('status', 'published')
            ->where('is_ticker', true)
            ->orderByDesc('is_critical')
            ->orderByDesc('published_at')
            ->take(10)
            ->get();
            
        // Get departments for navigation
        $departments = Department::orderBy('order')->get();
        
        // Create variable for missing newsArticles
        $newsArticles = $latestNews;

        // Create variable for announcementNews (replacing importantAnnouncements)
        $announcementNews = News::whereHas('category', function($query) {
            $query->where('name', 'like', '%announcement%')->orWhere('slug', 'like', '%announcement%');
        })->where('status', 'published')
        ->latest('published_at')
        ->take(2)
        ->get();
            
        // Get media gallery images for hero slideshow - preload and eager load the data
        $mediaGallery = \App\Models\Government\Media::where('status', 'active')
            ->where('type', 'image')
            ->where('is_featured', true)
            ->orderBy('order')  // Use order instead of latest
            ->take(15)
            ->get();

        // Get stats from site configuration
        $stats = SiteConfig::getStats();
        $statsIcons = SiteConfig::getConfig('stats_icons', []);
        $statsNames = SiteConfig::getConfig('stats_names', []);
        
        // Get leadership information
        $leadership = SiteConfig::getLeadership();

        return view('government.home', compact(
            'services',
            'projects',
            'latestNews',
            'newsArticles',
            'testimonials',
            'statistics',
            'announcements',
            'announcementNews',
            'departments',
            'mediaGallery',
            'stats',
            'statsIcons',
            'statsNames',
            'tickerNews',
            'leadership'
        ));
    }
    
    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('government.about');
    }
    
    /**
     * Display the about history page.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        return view('government.about.history');
    }
    
    /**
     * Display the leadership page.
     *
     * @return \Illuminate\View\View
     */
    public function leadership()
    {
        $departments = Department::active()->orderBy('order')->get();
        $leadership = SiteConfig::getLeadership();
        return view('government.about.leadership', compact('departments', 'leadership'));
    }
    
    /**
     * Display the mission and vision page.
     *
     * @return \Illuminate\View\View
     */
    public function missionVision()
    {
        return view('government.about.mission-vision');
    }
    
    /**
     * Display the organizational structure page.
     *
     * @return \Illuminate\View\View
     */
    public function organizationalStructure()
    {
        return view('government.about.organizational-structure');
    }
    
    /**
     * Display the services page.
     *
     * @return \Illuminate\View\View
     */
    public function services()
    {
        $services = Service::active()->orderBy('order')->get();
        $departments = Department::active()->orderBy('order')->get();
        
        return view('government.services.index', compact('services', 'departments'));
    }
    
    /**
     * Display a specific service page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function serviceDetail($slug)
    {
        $service = Service::active()->where('slug', $slug)->firstOrFail();
        
        return view('government.services.show', compact('service'));
    }
    
    /**
     * Display the projects page.
     *
     * @return \Illuminate\View\View
     */
    public function projects()
    {
        $projects = Project::active()->orderBy('created_at', 'desc')->paginate(12);
        $categories = ProjectCategory::all();
        
        return view('government.projects.index', compact('projects', 'categories'));
    }
    
    /**
     * Display a specific project category page.
     *
     * @param  string  $category
     * @return \Illuminate\View\View
     */
    public function projectCategory($category)
    {
        $category = ProjectCategory::where('slug', $category)->firstOrFail();
        $projects = Project::active()
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        return view('government.projects.category', compact('category', 'projects'));
    }
    
    /**
     * Display the departments page.
     *
     * @return \Illuminate\View\View
     */
    public function departments()
    {
        $departments = Department::active()->orderBy('order')->get();
        
        // Make sure departments have default images if none provided
        foreach ($departments as $department) {
            if (empty($department->featured_image) || !Storage::disk('public')->exists($department->featured_image)) {
                $department->default_image = true;
            } else {
                $department->image = $department->featured_image;
            }
        }
        
        return view('government.departments.index', compact('departments'));
    }
    
    /**
     * Display a specific department page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function departmentDetail($slug)
    {
        $department = Department::active()->where('slug', $slug)->firstOrFail();
        $services = Service::active()->where('department_id', $department->id)->get();
        $projects = Project::active()->where('department_id', $department->id)->take(4)->get();
        
        return view('government.departments.detail', compact('department', 'services', 'projects'));
    }
    
    /**
     * Display the circular economy overview page.
     *
     * @return \Illuminate\View\View
     */
    public function circularEconomy()
    {
        return view('government.circular-economy');
    }
    
    /**
     * Display the news page.
     *
     * @return \Illuminate\View\View
     */
    public function news()
    {
        $news = News::published()->latest('published_at')->paginate(9);
        $categories = NewsCategory::active()->get();
        
        return view('government.news.index', compact('news', 'categories'));
    }

    public function newsIndex(Request $request)
    {
        $query = News::published();
        $currentCategory = null;
        $currentTag = null;
        
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
            $currentCategory = NewsCategory::find($request->category);
        }
        
        if ($request->has('tag') && !empty($request->tag)) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('news_tags.id', $request->tag);
            });
            $currentTag = NewsTag::find($request->tag);
        }
        
        if ($request->has('year') && !empty($request->year)) {
            $query->whereYear('published_at', $request->year);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('published_at', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('published_at', 'asc');
        }
        
        $news = $query->paginate(10);
        $categories = NewsCategory::withCount('news')->get();
        $tags = NewsTag::withCount('news')->take(15)->get();
        $totalNews = News::published()->count();
        
        $featuredNews = News::published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        return view('government.news.index', compact(
            'news', 
            'categories', 
            'tags', 
            'totalNews', 
            'featuredNews',
            'currentCategory',
            'currentTag'
        ));
    }

    public function newsDetail($id)
    {
        $news = News::findOrFail($id);
        
        // Increment view counter
        $news->increment('views');
        
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where(function($query) use ($news) {
                if ($news->category_id) {
                    $query->where('category_id', $news->category_id);
                }
            })
            ->take(2)
            ->get();
            
        $latestNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(5)
            ->get();
            
        $categories = NewsCategory::withCount('news')->get();
        $tags = NewsTag::withCount('news')->take(15)->get();

        return view('government.news.show', compact('news', 'relatedNews', 'latestNews', 'categories', 'tags'));
    }
    
    /**
     * Display a specific news category page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function newsCategory($slug)
    {
        $category = NewsCategory::where('slug', $slug)->firstOrFail();
        $news = News::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(9);
        
        return view('government.news.category', compact('category', 'news'));
    }
    
    /**
     * Display a specific news article.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function newsArticle($slug)
    {
        $article = News::published()->where('slug', $slug)->firstOrFail();
        $article->incrementViews();
        
        $relatedArticles = News::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        
        return view('government.news.show', compact('article', 'relatedArticles'));
    }
    
    /**
     * Display the media gallery page.
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function mediaGallery($type)
    {
        // Use the Media model to fetch media based on type
        $query = \App\Models\Government\Media::active();
        
        if ($type === 'photos' || $type === 'gallery') {
            $query->where('type', 'image');
            $viewName = 'government.media.gallery';
        } elseif ($type === 'videos') {
            $query->where('type', 'video');
            $viewName = 'government.media.videos';
        } elseif ($type === 'documents') {
            $query->where('type', 'document');
            $viewName = 'government.media.documents';
        } else {
            // Default to gallery view
            $query->where('type', 'image');
            $viewName = 'government.media.' . $type;
        }
        
        // Handle category filtering if present in request
        if (request()->has('category') && !empty(request()->category)) {
            $query->where('category', request()->category);
        }
        
        // Handle project filtering
        if (request()->has('project_id') && !empty(request()->project_id)) {
            $query->where('model_type', \App\Models\Government\Project::class)
                  ->where('model_id', request()->project_id);
        }
        
        // Handle news filtering
        if (request()->has('news_id') && !empty(request()->news_id)) {
            $query->where('model_type', \App\Models\Government\News::class)
                  ->where('model_id', request()->news_id);
        }
        
        $media = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get project and news data for filter dropdowns
        $projects = \App\Models\Government\Project::active()->orderBy('title')->get();
        $news = \App\Models\Government\News::published()->orderBy('title')->get();
        $categories = $query->select('category')->distinct()->whereNotNull('category')->pluck('category');
        
        return view($viewName, compact('media', 'projects', 'news', 'categories', 'type'));
    }
    
    /**
     * Display the publications page.
     *
     * @return \Illuminate\View\View
     */
    public function publications()
    {
        // Fetch publications from the database
        $publications = \App\Models\Government\Publication::orderBy('created_at', 'desc')->paginate(12);
        
        // Count total publications
        $totalPublications = \App\Models\Government\Publication::count();
        
        // Get publication categories (use distinct categories from publications)
        $categories = \App\Models\Government\Publication::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->category,
                    'name' => ucfirst($item->category),
                    'publications_count' => \App\Models\Government\Publication::where('category', $item->category)->count()
                ];
            });
        
        return view('government.publications.index', compact('publications', 'categories', 'totalPublications'));
    }
    
    /**
     * Display a specific publication category page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function publicationCategory($slug)
    {
        // Use the slug parameter as the category
        $category = $slug;
        
        // Try to find publications with this category
        $publications = \App\Models\Government\Publication::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        // Get all available categories for the sidebar
        $availableCategories = \App\Models\Government\Publication::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
            
        // Format the category name for display
        $categoryName = ucfirst($category);
        
        // If no publications found for this category
        if ($publications->isEmpty()) {
            // Get some alternative publications to suggest
            $otherPublications = \App\Models\Government\Publication::orderBy('created_at', 'desc')
                ->take(6)
                ->get();
                
            return view('government.publications.category-not-found', [
                'category' => $categoryName,
                'availableCategories' => $availableCategories,
                'otherPublications' => $otherPublications
            ]);
        }
        
        // Count total publications
        $totalPublications = \App\Models\Government\Publication::count();
        
        return view('government.publications.category', [
            'category' => $categoryName, 
            'categories' => $availableCategories, 
            'totalPublications' => $totalPublications,
            'publications' => $publications
        ]);
    }
    
    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        $contactInfo = SiteConfig::getContactInfo();
        return view('government.contact.index', compact('contactInfo'));
    }
    
    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContactForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Log the submission
            Log::info('Contact form submitted', ['email' => $validated['email']]);

            // Send email notification
            Mail::to(config('mail.admin_address'))
                ->send(new ContactFormSubmission($validated));

            return redirect()->route('government.contact')
                ->with('success', __('Thank you for your message. We will get back to you soon!'));
        } catch (\Exception $e) {
            Log::error('Failed to process contact form', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return redirect()->route('government.contact')
                ->with('error', __('Sorry, there was an error processing your request. Please try again later.'));
        }
    }
    
    /**
     * Search the government portal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        // In a real implementation, you would search the database for relevant content
        $results = [];
        
        if ($query) {
            // Search for services
            $serviceResults = Service::active()
                ->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();
            
            // Search for news
            $newsResults = News::published()
                ->where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")
                ->get();
            
            // Search for departments
            $departmentResults = Department::active()
                ->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();
            
            // Search for projects
            $projectResults = Project::active()
                ->where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();
            
            // Combine results
            $results = [
                'services' => $serviceResults,
                'news' => $newsResults,
                'departments' => $departmentResults,
                'projects' => $projectResults
            ];
        }
        
        return view('government.search', compact('query', 'results'));
    }
    
    /**
     * Fallback method to handle routes with missing views
     *
     * @param  string  $section
     * @param  string  $page
     * @return \Illuminate\View\View
     */
    public function fallback($section = null, $page = null)
    {
        $data = [
            'title' => $page ? ucfirst($page) : ucfirst($section),
            'subtitle' => 'This section is currently under development',
            'message' => 'Content Coming Soon',
            'description' => 'We are actively working on creating content for this section. Please check back later for updates.',
            'icon' => 'fa-hammer',
            'contactButton' => true
        ];
        
        // Add parent breadcrumb data if section is provided
        if ($section) {
            $data['parentRoute'] = "/government/{$section}";
            $data['parentName'] = ucfirst($section);
        }
        
        return view('government.partials.placeholder', $data);
    }
    
    /**
     * Handle when a view is not found
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function viewNotFound(Request $request)
    {
        $path = $request->path();
        $segments = explode('/', $path);
        
        // Remove "government" from the beginning if it exists
        if (isset($segments[0]) && $segments[0] === 'government') {
            array_shift($segments);
        }
        
        $section = $segments[0] ?? null;
        $page = $segments[1] ?? null;
        
        return $this->fallback($section, $page);
    }
    
    /**
     * Display a specific publication detail page.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function publicationDetail($slug)
    {
        // Find the publication by slug
        $publication = \App\Models\Government\Publication::where('slug', $slug)->firstOrFail();
        
        // Get related publications
        $relatedPublications = \App\Models\Government\Publication::where('id', '!=', $publication->id)
            ->where(function($query) use ($publication) {
                if ($publication->category_id) {
                    $query->where('category_id', $publication->category_id);
                }
            })
            ->take(3)
            ->get();
            
        return view('government.publications.show', compact('publication', 'relatedPublications'));
    }
    
    /**
     * Display a specific announcement detail page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function announcementDetail($id)
    {
        // Find the announcement by ID
        $announcement = Announcement::findOrFail($id);
        
        // Get related announcements
        $relatedAnnouncements = Announcement::where('id', '!=', $announcement->id)
            ->where('status', 'active')
            ->orderByDesc('priority')
            ->take(3)
            ->get();
            
        return view('government.announcements.show', compact('announcement', 'relatedAnnouncements'));
    }
}