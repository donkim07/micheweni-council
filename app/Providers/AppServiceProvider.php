<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\LayoutController;
use App\View\Components\AppLayout;
use App\Models\Opportunities\CircularEconomy\News;
use App\Observers\NewsObserver;
use App\Models\Government\SiteConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default string length for MySQL older versions
        Schema::defaultStringLength(191);
        
        // Register the @role Blade directive
        Blade::if('role', function($role) {
            $user = Auth::user();
            return Auth::check() && $user && method_exists($user, 'hasRole') && $user->hasRole($role);
        });
        
        // Register components
        Blade::component('app-layout', AppLayout::class);

        // Register component view composer
        View::composer('admin.layout.components.*', function ($view) {
            $content = $view->getData()['content'] ?? null;
            $request = $view->getData()['request'] ?? request();
            
            if ($content) {
                $isPreview = $request->is('*preview*') || $request->has('preview_mode');
                $template = $content->template ?? 'standard';
                $class = isset($content->meta->css_class) ? $content->meta->css_class : '';
                
                $view->with('isPreview', $isPreview);
                $view->with('template', $template);
                $view->with('class', $class);
            }
        });
        
        // Register component types
        View::composer(['admin.layout.builder', 'admin.layout.preview', 'pages.show'], function ($view) {
            $layoutController = app(LayoutController::class);
            $view->with('componentTypes', $layoutController->getComponentTypes());
        });
        
        // Register custom directives
        Blade::directive('escapedPhp', function ($expression) {
            return "<?php echo e('{$expression}'); ?>";
        });
        
        // View composers for layout components
        View::composer('admin.layout.section-settings', function ($view) {
            // Ensure both meta and meta_data fields are properly loaded
            $section = $view->getData()['section'] ?? null;
            if ($section) {
                // If meta is empty but meta_data has content, copy it to meta
                if (empty($section->meta) && !empty($section->meta_data)) {
                    $section->meta = $section->meta_data;
                }
                // If meta_data is empty but meta has content, copy it to meta_data
                elseif (empty($section->meta_data) && !empty($section->meta)) {
                    $section->meta_data = $section->meta;
                }
                
                // Re-share the section with the view
                $view->with('section', $section);
            }
        });
        
        // Form component view composer to ensure form data is available
        View::composer('admin.layout.components.form', function ($view) {
            // Add forms data if not already present
            if (!isset($view->getData()['formBuilders'])) {
                try {
                    if (class_exists('\App\Models\FormBuilder')) {
                        $formBuilders = \App\Models\Opportunities\CircularEconomy\FormBuilder::where('is_active', true)
                                                           ->pluck('title', 'id')
                                                           ->toArray();
                        $view->with('formBuilders', $formBuilders);
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error loading form builders: ' . $e->getMessage());
                }
            }
        });

        // Register observers
        // Temporarily disabled due to model issues
        News::observe(NewsObserver::class);

        // Share contact info, social links, and leadership info with all views
        if (Schema::hasTable('site_configs')) {
            View::composer('*', function ($view) {
                $view->with('siteContactInfo', SiteConfig::getContactInfo());
                $view->with('siteSocialLinks', SiteConfig::getSocialLinks());
                $view->with('siteLeadership', SiteConfig::getLeadership());
            });
        }
    }
}
