<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::with('parent')->orderBy('menu_order')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentPages = Page::where('is_active', true)
            ->whereNull('parent_id')
            ->orWhere('id', '!=', 0) // Exclude self in case of edit
            ->pluck('title', 'id')
            ->toArray();
            
        $templates = $this->getAvailableTemplates();
        
        return view('admin.pages.create', compact('parentPages', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'description' => 'nullable|string',
            'template' => 'required|string',
            'parent_id' => 'nullable|exists:pages,id',
            'is_active' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_order' => 'nullable|integer',
            'meta_data' => 'nullable|array',
            'show_in_navigation' => 'boolean',
            'navigation_order' => 'nullable|integer',
            'visibility_roles' => 'nullable|array',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle JSON data
        if (isset($validated['meta_data'])) {
            $validated['meta_data'] = json_encode($validated['meta_data']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        $validated['show_in_menu'] = $request->has('show_in_menu');
        $validated['show_in_navigation'] = $request->has('show_in_navigation');
        
        // Create the page
        $page = Page::create($validated);
        
        return redirect()->route('admin.pages.edit', $page)
            ->with('success', __('Page created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $page = Page::with(['parent', 'contents'])->findOrFail($id);
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::findOrFail($id);
        
        $parentPages = Page::where('is_active', true)
            ->where(function($query) use ($id) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', '!=', $id);
            })
            ->where('id', '!=', $id) // Exclude self
            ->pluck('title', 'id')
            ->toArray();
        
        $templates = $this->getAvailableTemplates();
        
        // Get all roles for visibility options
        $roles = \App\Models\Role::pluck('name', 'id')->toArray();
        
        return view('admin.pages.edit', compact('page', 'parentPages', 'templates', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = Page::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'description' => 'nullable|string',
            'template' => 'required|string',
            'parent_id' => 'nullable|exists:pages,id',
            'is_active' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_order' => 'nullable|integer',
            'meta_data' => 'nullable|array',
            'visibility_roles' => 'nullable|array',
            'show_in_navigation' => 'boolean',
            'navigation_order' => 'nullable|integer',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle JSON data
        if (isset($validated['meta_data'])) {
            $validated['meta_data'] = json_encode($validated['meta_data']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        $validated['show_in_menu'] = $request->has('show_in_menu');
        $validated['show_in_navigation'] = $request->has('show_in_navigation');
        
        // Prevent parent-child circular reference
        if ($validated['parent_id'] == $id) {
            unset($validated['parent_id']);
        }
        
        // Update the page
        $page->update($validated);
        
        return redirect()->route('admin.pages.edit', $page)
            ->with('success', __('Page updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findOrFail($id);
        
        // Check if the page has child pages and handle them
        if ($page->children()->count() > 0) {
            // Option 1: Don't allow deletion
            // return back()->with('error', __('Cannot delete a page with child pages.'));
            
            // Option 2: Update children to parent's parent
            DB::transaction(function() use ($page) {
                $page->children()->update(['parent_id' => $page->parent_id]);
                $page->delete();
            });
        } else {
            $page->delete();
        }
        
        return redirect()->route('admin.pages.index')
            ->with('success', __('Page deleted successfully.'));
    }
    
    /**
     * Get available page templates.
     */
    private function getAvailableTemplates()
    {
        // This could be extended to scan the views directory for templates
        return [
            'default' => __('Default Template'),
            'home' => __('Home Page'),
            'about' => __('About Page'),
            'contact' => __('Contact Page'),
            'sidebar-left' => __('Page with Left Sidebar'),
            'sidebar-right' => __('Page with Right Sidebar'),
            'full-width' => __('Full Width Page'),
        ];
    }
}
