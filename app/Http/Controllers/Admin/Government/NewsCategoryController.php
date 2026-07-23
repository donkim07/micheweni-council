<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the news categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = NewsCategory::withCount('news')->orderBy('name')->paginate(10);
        return view('admin.government.news-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new news category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.news-categories.create');
    }

    /**
     * Store a newly created news category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        NewsCategory::create($validated);
        
        return redirect()->route('admin.government.news-categories.index')
            ->with('success', 'News category created successfully.');
    }

    /**
     * Display the specified news category.
     *
     * @param  \App\Models\Government\NewsCategory  $newsCategory
     * @return \Illuminate\View\View
     */
    public function show(NewsCategory $newsCategory)
    {
        $newsCategory->load(['news' => function($query) {
            $query->orderBy('created_at', 'desc')->take(5);
        }]);
        
        return view('admin.government.news-categories.show', [
            'category' => $newsCategory
        ]);
    }

    /**
     * Show the form for editing the specified news category.
     *
     * @param  \App\Models\Government\NewsCategory  $newsCategory
     * @return \Illuminate\View\View
     */
    public function edit(NewsCategory $newsCategory)
    {
        return view('admin.government.news-categories.edit', [
            'category' => $newsCategory
        ]);
    }

    /**
     * Update the specified news category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\NewsCategory  $newsCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, NewsCategory $newsCategory)
    {
        $validated = $this->validateCategory($request, $newsCategory->id);
        
        // Generate slug if name has changed
        if ($newsCategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $newsCategory->update($validated);
        
        return redirect()->route('admin.government.news-categories.index')
            ->with('success', 'News category updated successfully.');
    }

    /**
     * Remove the specified news category from storage.
     *
     * @param  \App\Models\Government\NewsCategory  $newsCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(NewsCategory $newsCategory)
    {
        // Check if category has news articles
        if ($newsCategory->news()->count() > 0) {
            return redirect()->route('admin.government.news-categories.index')
                ->with('error', 'Cannot delete category with associated news articles.');
        }
        
        $newsCategory->delete();
        
        return redirect()->route('admin.government.news-categories.index')
            ->with('success', 'News category deleted successfully.');
    }
    
    /**
     * Validate the news category request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validateCategory(Request $request, $id = null)
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('government_news_categories')->ignore($id),
            ],
            'description' => 'nullable|string|max:500',
        ]);
    }
} 