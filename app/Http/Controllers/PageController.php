<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display the specified page.
     */
    public function show($slug)
    {
        // Get the page with the specified slug, active only
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get all active contents for this page ordered by section and order
        $contents = $page->contents()
            ->where('is_active', true)
            ->orderBy('section')
            ->orderBy('order')
            ->get();
        
        // Get form builders for any form content
        $formContents = $contents->where('type', 'form');
        $formIds = [];
        
        foreach ($formContents as $content) {
            // Handle different meta data formats (string, object, etc.)
            if (is_string($content->meta)) {
                $meta = json_decode($content->meta, true);
                if (isset($meta['form_id'])) {
                    $formIds[] = $meta['form_id'];
                }
            } elseif (is_object($content->meta) && isset($content->meta->form_id)) {
                $formIds[] = $content->meta->form_id;
            }
        }
        
        $formBuilders = \App\Models\Opportunities\CircularEconomy\FormBuilder::whereIn('id', $formIds)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');
        
        // Prepare meta data for SEO
        $metaDescription = $page->description ?? substr(strip_tags($page->content ?? ''), 0, 160);
        $metaKeywords = $page->meta_keywords ?? '';
        
        // Check if we should use the new template system
        $useNewTemplateSystem = config('app.use_template_system', true);
        
        if ($useNewTemplateSystem && view()->exists('templates.render-page')) {
            return view('opportunities.circular-economy.templates.render-page', [
                'page' => $page,
                'contents' => $contents,
                'formBuilders' => $formBuilders,
                'metaDescription' => $metaDescription,
                'metaKeywords' => $metaKeywords
            ]);
        }
        
        // Fallback to the old system
        $sections = \App\Models\Opportunities\CircularEconomy\Section::where('page_id', $page->id)
            ->orderBy('order', 'asc')
            ->get();
        
        // Define component types with templates for dynamic template handling
        $componentTypes = [];
        if (method_exists('\App\Http\Controllers\Admin\LayoutController', 'getComponentTypes')) {
            $layoutController = new \App\Http\Controllers\Admin\LayoutController();
            $componentTypes = $layoutController->getComponentTypes();
        }
        
        // Compile all views to ensure they're properly rendered
        foreach ($contents as $content) {
            if ($content->type && view()->exists('admin.layout.components.' . $content->type)) {
                try {
                    // Pre-render components to make sure they're compiled correctly
                    $view = view('admin.layout.components.' . $content->type, [
                        'content' => $content,
                        'request' => request(),
                        'isPreview' => false,
                        'formBuilders' => $formBuilders
                    ]);
                    $view->render();
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error pre-rendering component: ' . $e->getMessage());
                }
            }
        }
        
        return view('opportunities.circular-economy.pages.show', [
            'page' => $page,
            'contents' => $contents,
            'sections' => $sections,
            'formBuilders' => $formBuilders,
            'componentTypes' => $componentTypes,
            'metaDescription' => $metaDescription,
            'metaKeywords' => $metaKeywords
        ]);
    }
    
    /**
     * Get all published pages for navigation
     */
    public static function getNavigationPages()
    {
        try {
            // First check if the table exists
            if (!Schema::hasTable('pages')) {
                return collect([]);
            }
            
            // Check if the show_in_navigation column exists
            if (Schema::hasColumn('pages', 'show_in_navigation')) {
                return Page::where('is_active', true)
                    ->where('show_in_navigation', true)
                    ->orderBy('navigation_order')
                    ->get();
            } else if (Schema::hasColumn('pages', 'show_in_menu')) {
                // Fallback if the show_in_navigation column doesn't exist
                return Page::where('is_active', true)
                    ->where('show_in_menu', true)
                    ->orderBy('menu_order')
                    ->get();
            } else {
                // Fallback if neither column exists
                return Page::where('is_active', true)
                    ->get();
            }
        } catch (QueryException $e) {
            // Handle missing columns
            return collect([]);
        } catch (\Exception $e) {
            // Catch any other exceptions
            return collect([]);
        }
    }
} 