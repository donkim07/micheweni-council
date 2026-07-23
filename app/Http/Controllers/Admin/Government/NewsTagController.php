<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsTagController extends Controller
{
    /**
     * Display a listing of the news tags.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tags = NewsTag::withCount('news')->orderBy('name')->paginate(15);
        return view('admin.government.news-tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new news tag.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.news-tags.create');
    }

    /**
     * Store a newly created news tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateTag($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        NewsTag::create($validated);
        
        return redirect()->route('admin.government.news-tags.index')
            ->with('success', 'News tag created successfully.');
    }

    /**
     * Display the specified news tag.
     *
     * @param  \App\Models\Government\NewsTag  $newsTag
     * @return \Illuminate\View\View
     */
    public function show(NewsTag $newsTag)
    {
        $newsTag->load(['news' => function($query) {
            $query->orderBy('created_at', 'desc')->take(5);
        }]);
        
        return view('admin.government.news-tags.show', [
            'tag' => $newsTag
        ]);
    }

    /**
     * Show the form for editing the specified news tag.
     *
     * @param  \App\Models\Government\NewsTag  $newsTag
     * @return \Illuminate\View\View
     */
    public function edit(NewsTag $newsTag)
    {
        return view('admin.government.news-tags.edit', [
            'tag' => $newsTag
        ]);
    }

    /**
     * Update the specified news tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\NewsTag  $newsTag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, NewsTag $newsTag)
    {
        $validated = $this->validateTag($request, $newsTag->id);
        
        // Generate slug if name has changed
        if ($newsTag->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $newsTag->update($validated);
        
        return redirect()->route('admin.government.news-tags.index')
            ->with('success', 'News tag updated successfully.');
    }

    /**
     * Remove the specified news tag from storage.
     *
     * @param  \App\Models\Government\NewsTag  $newsTag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(NewsTag $newsTag)
    {
        // Detach this tag from all news articles
        $newsTag->news()->detach();
        
        $newsTag->delete();
        
        return redirect()->route('admin.government.news-tags.index')
            ->with('success', 'News tag deleted successfully.');
    }
    
    /**
     * Validate the news tag request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validateTag(Request $request, $id = null)
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('government_news_tags')->ignore($id),
            ],
        ]);
    }
} 