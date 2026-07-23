<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\News;
use App\Models\Government\NewsCategory;
use App\Models\Government\NewsTag;
use App\Models\Government\Department;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the news.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $news = News::with(['category', 'department', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.government.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = NewsCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $tags = NewsTag::orderBy('name')->get();
        
        return view('admin.government.news.create', compact('categories', 'departments', 'tags'));
    }

    /**
     * Store a newly created news article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateNews($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile($request->file('featured_image'), 'news');
        }
        
        $news = News::create($validated);
        
        // Handle tags
        if ($request->has('tags')) {
            $news->tags()->attach($request->input('tags'));
        }
        
        return redirect()->route('admin.government.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Display the specified news article.
     *
     * @param  \App\Models\Government\News  $news
     * @return \Illuminate\View\View
     */
    public function show(News $news)
    {
        $news->load(['category', 'department', 'tags']);
        return view('admin.government.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news article.
     *
     * @param  \App\Models\Government\News  $news
     * @return \Illuminate\View\View
     */
    public function edit(News $news)
    {
        $categories = NewsCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $tags = NewsTag::orderBy('name')->get();
        $news->load('tags');
        
        return view('admin.government.news.edit', compact('news', 'categories', 'departments', 'tags'));
    }

    /**
     * Update the specified news article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\News  $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, News $news)
    {
        $validated = $this->validateNews($request, $news->id);
        
        // Generate slug if title has changed
        if ($news->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile(
                $request->file('featured_image'), 
                'news', 
                $news->featured_image
            );
        }
        
        $news->update($validated);
        
        // Handle tags
        $news->tags()->sync($request->input('tags', []));
        
        return redirect()->route('admin.government.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     *
     * @param  \App\Models\Government\News  $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(News $news)
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            $this->deleteFile($news->featured_image);
        }
        
        // Detach all tags
        $news->tags()->detach();
        
        $news->delete();
        
        return redirect()->route('admin.government.news.index')
            ->with('success', 'News article deleted successfully.');
    }
    
    /**
     * Validate the news article request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validateNews(Request $request, $id = null)
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('government_news')->ignore($id),
            ],
            'short_description' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_ticker' => 'boolean',
            'is_critical' => 'boolean',
            'category_id' => 'required|exists:government_news_categories,id',
            'department_id' => 'nullable|exists:government_departments,id',
            'source' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:government_news_tags,id',
        ]);
    }
    
    // Using the FileUploader trait instead of a local uploadImage method
} 