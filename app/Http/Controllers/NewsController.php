<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use App\Models\Opportunities\CircularEconomy\News;
use App\Models\Opportunities\CircularEconomy\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display the news page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);
            
        $categories = Category::has('news')->get();
        
        return view('opportunities.circular-economy.news.index', compact('news', 'categories'));
    }
    
    /**
     * Display news by category.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $news = News::where('is_published', true)
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(12);
            
        $categories = Category::has('news')->get();
        
        return view('opportunities.circular-economy.news.category', compact('news', 'categories', 'category'));
    }
    
    /**
     * Display a specific news article.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $article = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Get related news
        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->where(function($query) use ($article) {
                $query->where('category_id', $article->category_id)
                    ->orWhere(function($q) use ($article) {
                        $q->whereJsonContains('meta_data->tags', $article->meta_data['tags'] ?? []);
                    });
            })
            ->limit(3)
            ->get();
        
        return view('opportunities.circular-economy.news.show', compact('article', 'relatedNews'));
    }
} 