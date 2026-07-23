<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the templates.
     */
    public function index(Request $request)
    {
        // Filter by category if provided
        $category = $request->input('category');
        $type = $request->input('type');
        
        $query = Template::query();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        if ($type) {
            $query->where('type', $type);
        }
        
        $templates = $query->orderBy('name')->paginate(20);
        $categories = Template::distinct()->pluck('category')->toArray();
        $types = Template::distinct()->pluck('type')->toArray();
        
        return view('admin.templates.index', compact('templates', 'categories', 'types', 'category', 'type'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        $categories = Template::distinct()->pluck('category')->toArray();
        $types = Template::distinct()->pluck('type')->toArray();
        
        return view('admin.templates.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identifier' => 'required|string|max:255|unique:templates,identifier',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'animation' => 'nullable|string|max:255',
            'hover_effect' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'settings' => 'nullable|json',
            'default_content' => 'nullable|json',
        ]);
        
        // Handle file uploads for thumbnail
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = $request->file('thumbnail')->store('templates-thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Parse JSON data
        if (isset($validated['settings'])) {
            $validated['settings'] = json_decode($validated['settings'], true);
        }
        
        if (isset($validated['default_content'])) {
            $validated['default_content'] = json_decode($validated['default_content'], true);
        }
        
        $template = Template::create($validated);
        
        return redirect()->route('admin.templates.edit', $template->id)
            ->with('success', __('Template created successfully.'));
    }

    /**
     * Display the specified template.
     */
    public function show(Template $template)
    {
        return view('admin.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(Template $template)
    {
        $categories = Template::distinct()->pluck('category')->toArray();
        $types = Template::distinct()->pluck('type')->toArray();
        
        return view('admin.templates.edit', compact('template', 'categories', 'types'));
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'identifier' => 'required|string|max:255|unique:templates,identifier,' . $template->id,
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'animation' => 'nullable|string|max:255',
            'hover_effect' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'settings' => 'nullable|json',
            'default_content' => 'nullable|json',
        ]);
        
        // Handle file uploads for thumbnail
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            // Delete old image if exists
            if (!empty($template->thumbnail)) {
                Storage::disk('public')->delete($template->thumbnail);
            }
            
            $path = $request->file('thumbnail')->store('templates-thumbnails', 'public');
            $validated['thumbnail'] = $path;
        }
        
        // Parse JSON data
        if (isset($validated['settings'])) {
            $validated['settings'] = json_decode($validated['settings'], true);
        }
        
        if (isset($validated['default_content'])) {
            $validated['default_content'] = json_decode($validated['default_content'], true);
        }
        
        $template->update($validated);
        
        return redirect()->route('admin.templates.edit', $template->id)
            ->with('success', __('Template updated successfully.'));
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(Template $template)
    {
        // Delete the thumbnail if exists
        if (!empty($template->thumbnail)) {
            Storage::disk('public')->delete($template->thumbnail);
        }
        
        $template->delete();
        
        return redirect()->route('admin.templates.index')
            ->with('success', __('Template deleted successfully.'));
    }
    
    /**
     * Toggle the active status of a template.
     */
    public function toggleActive(Template $template)
    {
        $template->is_active = !$template->is_active;
        $template->save();
        
        $status = $template->is_active ? __('activated') : __('deactivated');
        
        return redirect()->route('admin.templates.index')
            ->with('success', __('Template :status successfully.', ['status' => $status]));
    }
    
    /**
     * Get available templates by type (for AJAX).
     */
    public function getTemplatesByType(Request $request)
    {
        $type = $request->input('type');
        
        if (!$type) {
            return response()->json(['error' => 'Type is required'], 400);
        }
        
        $templates = Template::where('type', $type)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'identifier', 'description', 'thumbnail']);
        
        return response()->json($templates);
    }
    
    /**
     * Get templates by component type - dedicated endpoint for AJAX calls.
     */
    public function getByComponentType(Request $request)
    {
        $type = $request->input('type');
        
        if (!$type) {
            return response()->json(['error' => 'Component type is required'], 400);
        }
        
        $templates = Template::where('type', $type)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'identifier', 'description', 'thumbnail', 'animation', 'hover_effect']);
            
        return response()->json($templates);
    }
} 