<?php

namespace App\Http\Controllers\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Department;
use App\Models\Government\Media;
use App\Models\Government\News;
use App\Models\Government\NewsCategory;
use App\Models\Government\NewsTag;
use App\Models\Government\Project;
use App\Models\Government\ProjectCategory;
use App\Models\Government\Publication;
use App\Models\Government\Service;
use App\Models\Government\Album;
use App\Models\Government\MediaCategory;
use App\Models\Government\PublicationCategory;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the services index page
     */
    public function servicesIndex(Request $request)
    {
        $query = Service::active();
        
        // Filter by department
        if ($request->has('department') && !empty($request->department)) {
            $query->where('department_id', $request->department);
        }
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }
        
        // Sort options
        $sort = $request->input('sort', 'default');
        if ($sort === 'a-z') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'z-a') {
            $query->orderBy('title', 'desc');
        } else {
            // Default sorting by order field
            $query->orderBy('order');
        }
        
        // Paginate the results
        $services = $query->paginate(12);
        
        // Get featured services
        $featuredServices = Service::active()->where('is_featured', true)->take(3)->get();
        
        // Get all departments for filtering
        $departments = Department::active()->orderBy('name')->get();
        
        // Count total services
        $totalServices = Service::active()->count();
        
        // Get services grouped by category for the "Browse Services by Category" section
        $servicesByCategory = Department::with(['services' => function($query) {
            $query->active();
        }])->get()->filter(function($department) {
            return $department->services->isNotEmpty();
        });

        return view('government.services.index', compact(
            'services', 
            'featuredServices', 
            'departments', 
            'totalServices',
            'servicesByCategory'
        ));
    }

    /**
     * Display a specific service
     */
    public function serviceShow($id)
    {
        $service = Service::findOrFail($id);
        $relatedServices = Service::active()
            ->where('id', '!=', $service->id)
            ->where(function($query) use ($service) {
                if ($service->department_id) {
                    $query->where('department_id', $service->department_id);
                }
            })
            ->take(4)
            ->get();

        return view('government.services.show', compact('service', 'relatedServices'));
    }

    /**
     * Display the projects index page
     */
    public function projectsIndex(Request $request)
    {
        $query = Project::active();
        $currentCategory = null;
        
        // Initialize categories with active project counts
        $categories = \App\Models\Government\ProjectCategory::withCount(['activeProjects as projects_count'])
            ->orderBy('name')
            ->get();
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
            $currentCategory = \App\Models\Government\ProjectCategory::find($request->category);
        }
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }
        
        // Sort options
        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->latest();
        } elseif ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'a-z') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'z-a') {
            $query->orderBy('title', 'desc');
        }
        
        $projects = $query->paginate(9);
        
        // Count projects by status for statistics
        $completedCount = Project::active()->where('status', 'completed')->count();
        $ongoingCount = Project::active()->where('status', 'ongoing')->count();
        $plannedCount = Project::active()->where('status', 'planned')->count();
        
        return view('government.projects.index', compact(
            'projects', 
            'categories', 
            'currentCategory', 
            'completedCount', 
            'ongoingCount', 
            'plannedCount'
        ));
    }

    /**
     * Display a specific project
     */
    public function projectShow($id)
    {
        $project = Project::with('images')->findOrFail($id);
        
        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->where(function($query) use ($project) {
                if ($project->category_id) {
                    $query->where('category_id', $project->category_id);
                }
            })
            ->take(3)
            ->get();
            
        // Get project images from both the Media model and project images relationship
        $projectGalleryFromMedia = Media::where('type', 'image')
            ->where('category', 'project')
            ->get()
            ->filter(function($media) use ($project) {
                // Filter the collection after fetching to find images related to this project
                return str_contains($media->description ?? '', 'Project ID: ' . $project->id) || 
                       str_contains($media->title ?? '', 'Project: ' . $project->title);
            });
        
        $projectGallery = $project->images ? $project->images()->orderBy('order')->get() : collect();
        
        // Merge both image collections
        if ($projectGalleryFromMedia->isNotEmpty()) {
            $projectGallery = $projectGallery->merge($projectGalleryFromMedia);
        }

        return view('government.projects.show', compact('project', 'relatedProjects', 'projectGallery'));
    }

    /**
     * Display the publications index page
     */
    public function publicationsIndex(Request $request)
    {
        $query = Publication::query();
        $currentCategory = null;
        
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
            $currentCategory = $request->category;
        }
        
        if ($request->has('year') && !empty($request->year)) {
            $query->whereYear('published_date', $request->year);
        }
        
        if ($request->has('file_type') && !empty($request->file_type)) {
            $fileType = $request->file_type;
            $query->where(function($q) use ($fileType) {
                if ($fileType === 'pdf') {
                    $q->where('file_path', 'like', '%.pdf');
                } elseif ($fileType === 'doc') {
                    $q->where(function($q2) {
                        $q2->where('file_path', 'like', '%.doc')
                           ->orWhere('file_path', 'like', '%.docx');
                    });
                } elseif ($fileType === 'xls') {
                    $q->where(function($q2) {
                        $q2->where('file_path', 'like', '%.xls')
                           ->orWhere('file_path', 'like', '%.xlsx')
                           ->orWhere('file_path', 'like', '%.csv');
                    });
                } elseif ($fileType === 'ppt') {
                    $q->where(function($q2) {
                        $q2->where('file_path', 'like', '%.ppt')
                           ->orWhere('file_path', 'like', '%.pptx');
                    });
                }
            });
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('published_date', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('published_date', 'asc');
        } elseif ($sort === 'a-z') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'z-a') {
            $query->orderBy('title', 'desc');
        }
        
        $publications = $query->paginate(12);
        
        // Get categories from publications
        $categories = Publication::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->category,
                    'name' => ucfirst($item->category),
                    'publications_count' => Publication::where('category', $item->category)->count()
                ];
            });
            
        $totalPublications = Publication::count();

        return view('government.publications.index', compact('publications', 'categories', 'totalPublications', 'currentCategory'));
    }

    /**
     * Display a specific publication
     */
    public function publicationShow($id)
    {
        $publication = Publication::findOrFail($id);
        
        // Increment downloads counter when viewing - in a real app you'd do this on actual download
        $publication->increment('downloads');
        
        $relatedPublications = Publication::where('id', '!=', $publication->id)
            ->where(function($query) use ($publication) {
                if ($publication->category) {
                    $query->where('category', $publication->category);
                }
            })
            ->take(4)
            ->get();
            
        $latestPublications = Publication::latest('published_date')->take(5)->get();
        
        // Get categories from publications
        $categories = Publication::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->category,
                    'name' => ucfirst($item->category),
                    'publications_count' => Publication::where('category', $item->category)->count()
                ];
            });

        return view('government.publications.show', compact('publication', 'relatedPublications', 'latestPublications', 'categories'));
    }

    /**
     * Display a specific publication category page.
     *
     * @param  string  $category
     * @return \Illuminate\View\View
     */
    public function publicationCategory($category)
    {
        // Try to find publications with this category
        $query = Publication::query();
        $query->where('category', $category);
        $publications = $query->orderBy('publication_date', 'desc')->paginate(12);
            
        // Get all available categories for the sidebar
        $categories = Publication::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->category,
                    'name' => ucfirst($item->category),
                    'publications_count' => Publication::where('category', $item->category)->count()
                ];
            });
            
        // Format the category name for display
        $categoryName = ucfirst($category);
        $currentCategory = $category;
        
        // If no publications found for this category
        if ($publications->isEmpty()) {
            // Get some alternative publications to suggest
            $otherPublications = Publication::orderBy('publication_date', 'desc')
                ->take(6)
                ->get();
                
            return view('government.publications.category-not-found', [
                'category' => $categoryName,
                'categories' => $categories,
                'otherPublications' => $otherPublications
            ]);
        }
        
        // Count total publications
        $totalPublications = Publication::count();
        
        return view('government.publications.category', compact(
            'category', 
            'categoryName', 
            'categories', 
            'totalPublications',
            'publications',
            'currentCategory'
        ));
    }

    /**
     * Display the media gallery page
     */
    public function mediaGallery(Request $request)
    {
        $query = Media::where('status', 'active');
        
        // Filter by type if provided, otherwise default to images
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        } else {
            $query->where('type', 'image');
        }
        
        // Filter by category if provided
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $media = $query->latest()->paginate(24);
        
        // Get all categories from media
        $categories = Media::select('category')
            ->where('category', '!=', null)
            ->distinct()
            ->pluck('category');
            
        // Check if we have albums defined
        $albums = null;
        $currentAlbum = null;
        
        // Only use Album class if it exists
        if (class_exists('App\Models\Government\Album')) {
            if ($request->has('album') && !empty($request->album)) {
                $albumId = $request->album;
                $query->where('album_id', $albumId);
                $currentAlbum = app('App\Models\Government\Album')->find($albumId);
            }
            
            $albums = app('App\Models\Government\Album')->withCount(['media' => function($query) {
                $query->where('type', 'image');
            }])->get();
        }

        return view('government.media.gallery', compact('media', 'categories', 'albums', 'currentAlbum'));
    }

    /**
     * Display the videos page
     */
    public function mediaVideos(Request $request)
    {
        $query = Media::where('type', 'video')->where('status', 'active');
        
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
            $currentCategory = $request->category;
        } else {
            $currentCategory = null;
        }
        
        if ($request->has('year') && !empty($request->year)) {
            $query->whereYear('created_at', $request->year);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $sort = $request->input('sort', 'newest');
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        
        $videos = $query->paginate(12);
        
        // Get all categories from media videos
        $categories = Media::select('category')
            ->where('type', 'video')
            ->where('category', '!=', null)
            ->distinct()
            ->pluck('category');
        
        $featuredVideo = Media::where('type', 'video')
            ->where('is_featured', true)
            ->where('status', 'active')
            ->latest()
            ->first();

        return view('government.media.videos', compact('videos', 'categories', 'featuredVideo', 'currentCategory'));
    }

    /**
     * Display the news index page
     */
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

    /**
     * Display a specific news article
     */
    public function newsShow($id)
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
} 