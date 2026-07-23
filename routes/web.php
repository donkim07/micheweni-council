<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DataDashboardController;
use App\Http\Controllers\DataVisualizationController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationCenterController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StakeholderDirectoryController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Import Government Controllers
use App\Http\Controllers\Government\HomeController as GovernmentHomeController;
use App\Http\Controllers\Admin\Government\DashboardController as GovernmentAdminDashboardController;

// Import Admin Controllers
use App\Http\Controllers\Admin\LayoutController;

// Government Routes
Route::prefix('government')->name('government.')->group(function () {
    // Home
    Route::get('/', [App\Http\Controllers\Government\HomeController::class, 'index'])->name('home');
    
    // About
    Route::get('/about', [App\Http\Controllers\Government\HomeController::class, 'about'])->name('about');
    Route::get('/about/history', [App\Http\Controllers\Government\HomeController::class, 'history'])->name('about.history');
    Route::get('/about/leadership', [App\Http\Controllers\Government\HomeController::class, 'leadership'])->name('about.leadership');
    Route::get('/about/mission-vision', [App\Http\Controllers\Government\HomeController::class, 'missionVision'])->name('about.mission-vision');
    Route::get('/about/organizational-structure', [App\Http\Controllers\Government\HomeController::class, 'organizationalStructure'])->name('about.organizational-structure');
    
    // Services - Use PublicController
    Route::get('/services', [App\Http\Controllers\Government\PublicController::class, 'servicesIndex'])->name('services.index');
    Route::get('/services/{id}', [App\Http\Controllers\Government\PublicController::class, 'serviceShow'])->name('services.show');
    
    // Projects - Use PublicController
    Route::get('/projects', [App\Http\Controllers\Government\PublicController::class, 'projectsIndex'])->name('projects.index');
    Route::get('/projects/{id}', [App\Http\Controllers\Government\PublicController::class, 'projectShow'])->name('projects.show');
    
    // Departments
    Route::get('/departments', [App\Http\Controllers\Government\HomeController::class, 'departments'])->name('departments.index');
    Route::get('/departments/{slug}', [App\Http\Controllers\Government\HomeController::class, 'departmentDetail'])->name('departments.show');
    
    // News
    Route::get('/news-new', [App\Http\Controllers\Government\PublicController::class, 'newsIndex'])->name('news.index');
    Route::get('/news-new/{id}', [App\Http\Controllers\Government\PublicController::class, 'newsShow'])->name('news.show');
    
    // Media Gallery
    Route::get('/media-new/gallery', [App\Http\Controllers\Government\PublicController::class, 'mediaGallery'])->name('media.gallery');
    Route::get('/media-new/videos', [App\Http\Controllers\Government\PublicController::class, 'mediaVideos'])->name('media.videos');
    
    // Publications
    Route::get('/publications', [App\Http\Controllers\Government\PublicController::class, 'publicationsIndex'])->name('publications.index');
    Route::get('/publications/{id}', [App\Http\Controllers\Government\PublicController::class, 'publicationShow'])->name('publications.show');
    Route::get('/publications/{category}', [App\Http\Controllers\Government\PublicController::class, 'publicationCategory'])->name('publications.category');
    
    // Contact
    Route::get('/contact', [App\Http\Controllers\Government\HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [App\Http\Controllers\Government\HomeController::class, 'submitContactForm'])->name('contact.submit');
    
    // Search
    Route::get('/search', [App\Http\Controllers\Government\SearchController::class, 'search'])->name('search');
    
    // Fallback for static pages
    Route::get('/{section?}/{page?}', [App\Http\Controllers\Government\HomeController::class, 'fallback'])
        ->where('section', '^(?!admin|api|login|register|password).*$')
        ->name('fallback');
});

// Public Routes
Route::get('/', function() {
    return redirect()->route('government.home');
})->name('home');

// Sitemap Routes
Route::get('/sitemap', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'xml'])->name('sitemap.xml');

// About Route
Route::get('/about', [App\Http\Controllers\Opportunities\CircularEconomy\AboutController::class, 'index'])->name('about');

// Services Route
Route::get('/services', [App\Http\Controllers\Opportunities\CircularEconomy\ServicesController::class, 'index'])->name('services');

// Opportunities Routes
Route::prefix('opportunities')->name('opportunities.')->group(function () {
    // Main opportunities page
    Route::get('/', [App\Http\Controllers\OpportunityController::class, 'index'])->name('index');
    Route::get('/show/{id}', [App\Http\Controllers\OpportunityController::class, 'show'])->name('show');
    Route::get('/search', [App\Http\Controllers\OpportunityController::class, 'search'])->name('search');
    Route::post('/save', [App\Http\Controllers\OpportunityController::class, 'save'])->name('save')->middleware('auth');
    Route::get('/saved', [App\Http\Controllers\OpportunityController::class, 'savedOpportunities'])->name('saved')->middleware('auth');
    Route::get('/applications', [App\Http\Controllers\OpportunityController::class, 'applications'])->name('applications')->middleware('auth');
    Route::get('/contact', [App\Http\Controllers\OpportunityController::class, 'contact'])->name('contact');
    
    // Category routes
    Route::get('/category/{category}', [App\Http\Controllers\OpportunityController::class, 'byCategory'])->name('category');
    
    // Circular Economy Routes
    Route::prefix('circular-economy')->name('circular-economy.')->group(function () {
        Route::get('/', [App\Http\Controllers\Opportunities\CircularEconomy\HomeController::class, 'index'])->name('home');
        // Waste Management Routes
        Route::prefix('waste')->name('waste.')->group(function () {
            Route::get('/', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'index'])->name('home');
            Route::get('/map', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'map'])->name('map');
            Route::get('/collection', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'collection'])->name('collection');
            Route::get('/recycling', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'recycling'])->name('recycling');
            Route::get('/directory', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'directory'])->name('directory');
            Route::get('/marketplace', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'marketplace'])->name('marketplace');
            
            // Marketplace Routes
            Route::get('/marketplace/create', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'createListing'])->name('create-listing')->middleware('auth');
            Route::post('/marketplace/store', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'storeListing'])->name('store-listing')->middleware('auth');
            Route::get('/marketplace/my-listings', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'myListings'])->name('my-listings')->middleware('auth');
            Route::get('/marketplace/listing/{id}', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'showListing'])->name('show-listing');
            Route::post('/marketplace/listing/{id}/toggle', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'toggleListingStatus'])->name('toggle-listing')->middleware('auth');
            
            // Waste Locations Route
            Route::get('/locations', [App\Http\Controllers\Opportunities\CircularEconomy\WasteController::class, 'locations'])->name('locations');
        });
                
        // Data & Reports Routes
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\Opportunities\CircularEconomy\DataDashboardController::class, 'index'])->name('dashboard');
            Route::get('/country', [App\Http\Controllers\Opportunities\CircularEconomy\DataDashboardController::class, 'getCountryData'])->name('country');
            Route::get('/compare', [App\Http\Controllers\Opportunities\CircularEconomy\DataDashboardController::class, 'compareCountries'])->name('compare');
            Route::post('/report', [App\Http\Controllers\Opportunities\CircularEconomy\DataDashboardController::class, 'generateReport'])->name('report');
        });

        // Resources Route
        Route::get('/resources', [App\Http\Controllers\Opportunities\CircularEconomy\ResourcesController::class, 'index'])->name('resources');

        // News Routes
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', [App\Http\Controllers\Opportunities\CircularEconomy\NewsController::class, 'index'])->name('index');
            Route::get('/category/{slug}', [App\Http\Controllers\Opportunities\CircularEconomy\NewsController::class, 'category'])->name('category');
            Route::get('/{slug}', [App\Http\Controllers\Opportunities\CircularEconomy\NewsController::class, 'show'])->name('show');
        });

        // Contact Route
        Route::get('/contact', [App\Http\Controllers\Opportunities\CircularEconomy\ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [App\Http\Controllers\Opportunities\CircularEconomy\ContactController::class, 'submit'])->name('contact.submit');

        // Form Submission Route
        Route::post('/form/{id}/submit', [App\Http\Controllers\Opportunities\CircularEconomy\FormController::class, 'submit'])->name('form.submit');

        // Page Route
        Route::get('/page/{slug}', [App\Http\Controllers\Opportunities\CircularEconomy\PageController::class, 'show'])->name('page.show');
        // Alias route for pages.show (for backward compatibility)
        Route::get('/pages/{slug}', [App\Http\Controllers\Opportunities\CircularEconomy\PageController::class, 'show'])->name('pages.show');

        // Language Switching
        Route::get('/language/{locale}', [App\Http\Controllers\Opportunities\CircularEconomy\LanguageController::class, 'switch'])->name('language.switch');



        // Newsletter Subscription
        Route::post('/newsletter/subscribe', [App\Http\Controllers\Opportunities\CircularEconomy\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
        Route::post('/newsletter/unsubscribe', [App\Http\Controllers\Opportunities\CircularEconomy\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');


        
        Route::get('/about', [App\Http\Controllers\Opportunities\CircularEconomy\AboutController::class, 'index'])->name('about');
        Route::get('/services', [App\Http\Controllers\Opportunities\CircularEconomy\ServicesController::class, 'index'])->name('services');
        

        
        // Privacy, Terms and Accessibility Pages
        Route::get('/privacy-policy', function() {
            return view('pages.privacy');
        })->name('privacy');

        Route::get('/terms-of-use', function() {
            return view('pages.terms');
        })->name('terms');

        Route::get('/accessibility', function() {
            return view('pages.accessibility');
        })->name('accessibility');
    });
});

// Assessment Routes - now part of circular economy opportunity
Route::prefix('opportunities/circular-economy/assessment')->name('opportunities.circular-economy.assessment.')->group(function () {
    Route::get('/', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'index'])->name('index');
    Route::get('/section/{section}', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'section'])->name('section');
    Route::post('/section/{section}/submit', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'submitSection'])->name('submit');
    Route::get('/results/{section}/{submission}', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'results'])->name('section.results');
    Route::get('/continue', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'continue'])->name('continue');
    Route::get('/results', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'showResults'])->name('showResults');
    Route::get('/pdf/{submission}', [App\Http\Controllers\Opportunities\CircularEconomy\AssessmentController::class, 'generatePdf'])->name('pdf');
});

// Page Route
Route::get('/page/{slug}', [App\Http\Controllers\Opportunities\CircularEconomy\PageController::class, 'show'])->name('page.show');
// Alias route for pages.show (for backward compatibility)
Route::get('/pages/{slug}', [App\Http\Controllers\Opportunities\CircularEconomy\PageController::class, 'show'])->name('pages.show');

        // Newsletter Subscription
        Route::post('/newsletter/subscribe', [App\Http\Controllers\Opportunities\CircularEconomy\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
        Route::post('/newsletter/unsubscribe', [App\Http\Controllers\Opportunities\CircularEconomy\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// User Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function() {
        return view('profile.index');
    })->name('profile');
    
    Route::get('/profile/assessments', function() {
        return view('profile.assessments');
    })->name('profile.assessments');
});

// Admin Routes
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    // Add a check at the beginning of each admin route to verify admin status
    Route::get('/dashboard', function(Request $request) {
        // Check for admin role
        if (!$request->user() || !$request->user()->roles->contains('name', 'admin')) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        
        // Pass to controller if user is admin
        return app()->call([app(App\Http\Controllers\Admin\DashboardController::class), 'index']);
    })->name('dashboard');
    
    // Admin Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Direct route for home config guide
    Route::get('/home-config-guide', [App\Http\Controllers\Admin\DashboardController::class, 'homeConfigGuide'])->name('home-config-guide');
    
    // Resource Controllers - Define with closures that check admin status first
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class);
    
    Route::resource('contents', App\Http\Controllers\Admin\ContentController::class);
    Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class);
    
    // Form Builder Routes
    Route::resource('form-builders', App\Http\Controllers\Admin\FormBuilderController::class);
    Route::resource('form-submissions', App\Http\Controllers\Admin\FormSubmissionController::class)->except(['create', 'store', 'edit', 'update']);
    Route::post('form-submissions/{id}/status', [App\Http\Controllers\Admin\FormSubmissionController::class, 'updateStatus'])->name('form-submissions.update-status');
    Route::get('form-submissions/export', [App\Http\Controllers\Admin\FormSubmissionController::class, 'export'])->name('form-submissions.export');
    
    // Generate default permissions
    Route::get('/permissions/generate-defaults', [App\Http\Controllers\Admin\PermissionController::class, 'generateDefaults'])
        ->name('permissions.generate-defaults');
        
    // Page Builder Routes
    Route::get('/layout/builder/{page}', [LayoutController::class, 'builder'])->name('layout.builder');
    Route::post('/layout/save/{page}', [LayoutController::class, 'saveLayout'])->name('layout.saveLayout');
    Route::get('/layout/preview/{page}', [LayoutController::class, 'preview'])->name('layout.preview');
    Route::get('/layout/component-settings/{id}', [LayoutController::class, 'componentSettings'])->name('layout.componentSettings');
    Route::post('/layout/component-settings/{id}', [LayoutController::class, 'saveComponentSettings'])->name('layout.saveComponentSettings');
    Route::get('/layout/section-settings/{id}', [LayoutController::class, 'sectionSettings'])->name('layout.sectionSettings');
    Route::post('/layout/section-settings/{id}', [LayoutController::class, 'saveSectionSettings'])->name('layout.saveSectionSettings');
    Route::get('/layout/get-templates', [LayoutController::class, 'getTemplates'])->name('layout.getTemplates');
    Route::post('/layout/preview-component/{id}', [LayoutController::class, 'previewComponent'])->name('layout.previewComponent');
    Route::post('/layout/add-component', [LayoutController::class, 'addComponent'])->name('layout.addComponent');
    
    // Template System Routes
    Route::resource('templates', App\Http\Controllers\Admin\TemplateController::class);
    Route::get('templates/get-by-component-type', [App\Http\Controllers\Admin\TemplateController::class, 'getByComponentType'])->name('templates.by-type');
    Route::post('templates/{template}/toggle-active', [App\Http\Controllers\Admin\TemplateController::class, 'toggleActive'])->name('templates.toggle-active');
    

    Route::resource('waste-locations', App\Http\Controllers\Admin\Opportunities\CircularEconomy\WasteLocationController::class);

    // Newsletter Subscriptions Management
    Route::get('newsletter-subscriptions', [App\Http\Controllers\Admin\NewsletterSubscriptionController::class, 'index'])->name('newsletter-subscriptions.index');
    Route::delete('newsletter-subscriptions/{id}', [App\Http\Controllers\Admin\NewsletterSubscriptionController::class, 'destroy'])->name('newsletter-subscriptions.destroy');
    Route::get('newsletter-subscriptions/export', [App\Http\Controllers\Admin\NewsletterSubscriptionController::class, 'export'])->name('newsletter-subscriptions.export');

    // Site Configuration routes
    Route::group(['prefix' => 'government/site-config', 'as' => 'government.site-config.'], function () {
        Route::get('/', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'destroy'])->name('destroy');
        
        // Special configuration sections
        Route::get('/contact', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'editContact'])->name('edit-contact');
        Route::post('/contact', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'updateContact'])->name('update-contact');
        
        Route::get('/social', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'editSocial'])->name('edit-social');
        Route::post('/social', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'updateSocial'])->name('update-social');
        
        Route::get('/leadership', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'editLeadership'])->name('edit-leadership');
        Route::post('/leadership', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'updateLeadership'])->name('update-leadership');
        
        Route::get('/stats', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'editStats'])->name('edit-stats');
        Route::post('/stats', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'updateStats'])->name('update-stats');
    
        Route::get('/about', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'editAbout'])->name('edit-about');
        Route::post('/about', [App\Http\Controllers\Admin\Government\SiteConfigController::class, 'updateAbout'])->name('update-about');
    });
});

// Admin Opportunities Routes
Route::middleware(['auth'])->prefix('admin/opportunities')->name('admin.opportunities.')->group(function () {
    // Main opportunities routes
    Route::get('/', [App\Http\Controllers\Admin\OpportunityController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\OpportunityController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\OpportunityController::class, 'store'])->name('store');
    Route::get('/{id}', [App\Http\Controllers\Admin\OpportunityController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [App\Http\Controllers\Admin\OpportunityController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\Admin\OpportunityController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\Admin\OpportunityController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/toggle', [App\Http\Controllers\Admin\OpportunityController::class, 'toggle'])->name('toggle');
    
    // // Circular Economy Routes
    // Route::prefix('circular-economy')->name('circular-economy.')->group(function () {
    //     // Waste Routes
    //     Route::resource('waste-locations', App\Http\Controllers\Admin\Opportunities\CircularEconomy\WasteLocationController::class);
    // });
});

// Add this section for government admin routes
Route::middleware(['auth'])->prefix('admin/government')->name('admin.government.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [App\Http\Controllers\Admin\Government\DashboardController::class, 'index'])->name('dashboard');
    
    // Site Configuration routes
    
    // Pages routes
    Route::resource('pages', App\Http\Controllers\Admin\Government\PageController::class);
    
    // Department routes
    Route::resource('departments', App\Http\Controllers\Admin\Government\DepartmentController::class);
    Route::post('departments/update-order', [App\Http\Controllers\Admin\Government\DepartmentController::class, 'updateOrder'])->name('departments.updateOrder');
    Route::get('departments/{department}/details', [App\Http\Controllers\Admin\Government\DepartmentController::class, 'editDetails'])->name('departments.edit-details');
    Route::post('departments/{department}/details', [App\Http\Controllers\Admin\Government\DepartmentController::class, 'updateDetails'])->name('departments.update-details');
    
    // Service routes
    Route::resource('services', App\Http\Controllers\Admin\Government\ServiceController::class);
    Route::post('services/update-order', [App\Http\Controllers\Admin\Government\ServiceController::class, 'updateOrder'])->name('services.updateOrder');
    
    // Project routes
    Route::resource('project-categories', App\Http\Controllers\Admin\Government\ProjectCategoryController::class);
    Route::resource('projects', App\Http\Controllers\Admin\Government\ProjectController::class);
    
    // Project Images routes
    Route::get('projects/{project}/images', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'index'])->name('projects.images.index');
    Route::get('projects/{project}/images/create', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'create'])->name('projects.images.create');
    Route::post('projects/{project}/images', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'store'])->name('projects.images.store');
    Route::get('projects/{project}/images/{image}/edit', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'edit'])->name('projects.images.edit');
    Route::put('projects/{project}/images/{image}', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'update'])->name('projects.images.update');
    Route::delete('projects/{project}/images/{imageId}', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'destroy'])->name('projects.images.destroy');
    Route::post('projects/{project}/images/update-order', [App\Http\Controllers\Admin\Government\ProjectImagesController::class, 'updateOrder'])->name('projects.images.update-order');
    
    // News routes
    Route::resource('news-categories', App\Http\Controllers\Admin\Government\NewsCategoryController::class);
    Route::resource('news-tags', App\Http\Controllers\Admin\Government\NewsTagController::class);
    Route::resource('news', App\Http\Controllers\Admin\Government\NewsController::class);
    
    // Announcement routes
    Route::resource('announcements', App\Http\Controllers\Admin\Government\AnnouncementController::class);
    
    // Statistics routes
    Route::resource('statistics', App\Http\Controllers\Admin\Government\StatisticsController::class);
    
    // Testimonial routes
    Route::resource('testimonials', App\Http\Controllers\Admin\Government\TestimonialController::class);
    
    // Publication routes
    Route::resource('publications', App\Http\Controllers\Admin\Government\PublicationController::class);
    
    // Media Gallery routes
    Route::resource('media', App\Http\Controllers\Admin\Government\MediaController::class, [
        'parameters' => [
            'media' => 'media'
        ]
    ]);
});

// API-style routes for template loading
Route::get('/api/templates/by-type', [App\Http\Controllers\Admin\TemplateController::class, 'getTemplatesByType'])->name('api.templates.by-type');

// Auth routes (Laravel Breeze will handle these)
require __DIR__.'/auth.php';

// Template preview routes - these are for previewing the newly created templates
Route::prefix('templates')->name('templates.')->group(function () {
    // Generic template route for about pages
    Route::get('/about/{template?}', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'showTemplate'])
        ->name('about')
        ->defaults('section', 'about');
    
    // Service templates
    Route::get('/services', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'services'])->name('services');
    Route::get('/services/detail', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'serviceDetail'])->name('service.detail');
    
    // Project templates
    Route::get('/projects', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'projects'])->name('projects');
    Route::get('/projects/detail', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'projectDetail'])->name('project.detail');
    
    // Publication templates
    Route::get('/publications', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'publications'])->name('publications');
    Route::get('/publications/detail', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'publicationDetail'])->name('publication.detail');
    
    // News templates
    Route::get('/news', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'news'])->name('news');
    Route::get('/news/detail', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'newsDetail'])->name('news.detail');
    
    // Media templates
    Route::get('/media/gallery', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'mediaGallery'])->name('media.gallery');
    Route::get('/media/videos', [App\Http\Controllers\Opportunities\CircularEconomy\TemplatesController::class, 'mediaVideos'])->name('media.videos');
});
