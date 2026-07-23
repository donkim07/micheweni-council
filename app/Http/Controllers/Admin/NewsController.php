<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Category;
use App\Models\Opportunities\CircularEconomy\News;
use App\Models\User;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'author']);
        
        // Filter by category if provided
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter by status if provided
        if ($request->has('is_published')) {
            $query->where('is_published', $request->is_published);
        }
        
        // Search by title or content if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }
        
        $news = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::pluck('name', 'id')->toArray();
        
        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'excerpt' => 'nullable|string|max:500',
            'excerpt_sw' => 'nullable|string|max:500',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_data' => 'nullable|array',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle file uploads for featured image
        if ($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
            $validated['featured_image'] = $this->uploadFile($request->file('featured_image'), 'news');
        }
        
        // Handle JSON data
        if (isset($validated['meta_data'])) {
            $validated['meta_data'] = json_encode($validated['meta_data']);
        }
        
        // Set the author (current user)
        $validated['author_id'] = Auth::id();
        
        // Set published date if article is published
        if ($request->has('is_published') && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        // Create the news article
        $news = News::create($validated);
        
        return redirect()->route('admin.news.edit', $news->id)
            ->with('success', __('News article created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::with(['category', 'author'])->findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = News::findOrFail($id);
        $categories = Category::pluck('name', 'id')->toArray();
        
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug,' . $id,
            'excerpt' => 'nullable|string|max:500',
            'excerpt_sw' => 'nullable|string|max:500',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_data' => 'nullable|array',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle file uploads for featured image
        if ($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
            $validated['featured_image'] = $this->uploadFile(
                $request->file('featured_image'),
                'news',
                $news->featured_image
            );
        }
        
        // Handle JSON data
        if (isset($validated['meta_data'])) {
            $validated['meta_data'] = json_encode($validated['meta_data']);
        }
        
        // Set published date if article is being published for the first time
        if ($request->has('is_published') && !$news->is_published && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        // Update the news article
        $news->update($validated);
        
        return redirect()->route('admin.news.edit', $news->id)
            ->with('success', __('News article updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        
        // Delete the featured image if exists
        if (!empty($news->featured_image)) {
            $this->deleteFile($news->featured_image);
        }
        
        $news->delete();
        
        return redirect()->route('admin.news.index')
            ->with('success', __('News article deleted successfully.'));
    }
    
    /**
     * Toggle the published status of a news article.
     */
    public function togglePublished(string $id)
    {
        $news = News::findOrFail($id);
        
        $news->is_published = !$news->is_published;
        
        // Set published date if publishing for the first time
        if ($news->is_published && empty($news->published_at)) {
            $news->published_at = now();
        }
        
        $news->save();
        
        $status = $news->is_published ? __('published') : __('unpublished');
        
        return redirect()->route('admin.news.index')
            ->with('success', __('News article :status successfully.', ['status' => $status]));
    }
}
