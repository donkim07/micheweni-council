<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use App\Models\Opportunities\CircularEconomy\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Content::with('page');
        
        // Filter by page if provided
        if ($request->has('page_id') && !empty($request->page_id)) {
            $query->where('page_id', $request->page_id);
        }
        
        // Filter by section if provided
        if ($request->has('section') && !empty($request->section)) {
            $query->where('section', $request->section);
        }
        
        // Filter by type if provided
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }
        
        $contents = $query->orderBy('page_id')->orderBy('section')->orderBy('order')->paginate(20);
        $pages = Page::pluck('title', 'id')->toArray();
        $sections = Content::distinct()->pluck('section')->filter()->toArray();
        $types = $this->getContentTypes();
        
        return view('admin.contents.index', compact('contents', 'pages', 'sections', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = Page::pluck('title', 'id')->toArray();
        $sections = Content::distinct()->pluck('section')->filter()->toArray();
        $types = $this->getContentTypes();
        $forms = FormBuilder::where('is_active', true)->pluck('title', 'id')->toArray();
        
        return view('admin.contents.create', compact('pages', 'sections', 'types', 'forms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'identifier' => 'nullable|string|max:255|unique:contents,identifier',
            'content' => 'nullable',
            'content_sw' => 'nullable',
            'type' => 'required|string|max:50',
            'page_id' => 'nullable|exists:pages,id',
            'section' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'meta_data' => 'nullable|array',
            'form_builder_id' => 'nullable|exists:form_builders,id',
            'content_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content_image_sw' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Generate identifier if not provided
        if (empty($validated['identifier'])) {
            $validated['identifier'] = Str::slug($validated['title']) . '-' . time();
        }
        
        // Handle file uploads for image type content
        if ($request->hasFile('content_image') && $request->file('content_image')->isValid()) {
            $path = $request->file('content_image')->store('content-images', 'public');
            $validated['content'] = $path;
        }
        
        if ($request->hasFile('content_image_sw') && $request->file('content_image_sw')->isValid()) {
            $path = $request->file('content_image_sw')->store('content-images', 'public');
            $validated['content_sw'] = $path;
        }
        
        // Handle JSON data
        if (isset($validated['meta_data'])) {
            $validated['meta_data'] = json_encode($validated['meta_data']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Create the content
        $content = Content::create($validated);
        
        return redirect()->route('admin.contents.edit', $content->id)
            ->with('success', __('Content block created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $content = Content::with('page')->findOrFail($id);
        return view('admin.contents.show', compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $content = Content::findOrFail($id);
        $pages = Page::pluck('title', 'id')->toArray();
        $sections = Content::distinct()->pluck('section')->filter()->toArray();
        $types = $this->getContentTypes();
        $forms = FormBuilder::where('is_active', true)->pluck('title', 'id')->toArray();
        
        return view('admin.contents.edit', compact('content', 'pages', 'sections', 'types', 'forms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $content = Content::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'identifier' => 'nullable|string|max:255|unique:contents,identifier,' . $id,
            'content' => 'nullable',
            'content_sw' => 'nullable',
            'type' => 'required|string|max:50',
            'page_id' => 'nullable|exists:pages,id',
            'section' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'meta_data' => 'nullable|array',
            'form_builder_id' => 'nullable|exists:form_builders,id',
            'content_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content_image_sw' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Generate identifier if not provided
        if (empty($validated['identifier'])) {
            $validated['identifier'] = Str::slug($validated['title']) . '-' . time();
        }
        
        // Handle file uploads for image type content
        if ($request->hasFile('content_image') && $request->file('content_image')->isValid()) {
            // Delete old image if exists
            if ($content->type == 'image' && !empty($content->content)) {
                Storage::disk('public')->delete($content->content);
            }
            
            $path = $request->file('content_image')->store('content-images', 'public');
            $validated['content'] = $path;
        } elseif ($validated['type'] != 'image') {
            // Only update content if it's not an image type or if no new image is uploaded
            // This prevents clearing image path when updating non-image fields
        }
        
        if ($request->hasFile('content_image_sw') && $request->file('content_image_sw')->isValid()) {
            $path = $request->file('content_image_sw')->store('content-images', 'public');
            $validated['content_sw'] = $path;
        }
        
        // Handle JSON data
        if (isset($validated['meta_data'])) {
            $validated['meta_data'] = json_encode($validated['meta_data']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        
        // Update the content
        $content->update($validated);
        
        return redirect()->route('admin.contents.edit', $content->id)
            ->with('success', __('Content block updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $content = Content::findOrFail($id);
        
        // Delete associated image if this is an image content
        if ($content->type == 'image' && !empty($content->content)) {
            Storage::disk('public')->delete($content->content);
        }
        
        $content->delete();
        
        return redirect()->route('admin.contents.index')
            ->with('success', __('Content block deleted successfully.'));
    }
    
    /**
     * Get available content types.
     */
    private function getContentTypes()
    {
        return [
            'text' => __('Plain Text'),
            'html' => __('Rich Text (HTML)'),
            'image' => __('Image'),
            'video' => __('Video Embed'),
            'file' => __('File Download'),
            'map' => __('Map Embed'),
            'slider' => __('Image Slider'),
            'gallery' => __('Image Gallery'),
            'form' => __('Form Embed'),
            'custom' => __('Custom Component'),
        ];
    }
}
