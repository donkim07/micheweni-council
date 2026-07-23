<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Category;
use App\Models\Opportunities\CircularEconomy\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('news')
            ->with('parent')
            ->orderBy('name')
            ->paginate(20);
            
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->orWhere('id', '!=', 0) // Exclude self in case of edit
            ->pluck('name', 'id')
            ->toArray();
            
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Create the category
        $category = Category::create($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', __('Category created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with(['parent', 'children', 'news'])->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        
        // Get parent categories excluding self and children to avoid circular references
        $parentCategories = Category::where(function($query) use ($id) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', '!=', $id);
            })
            ->where('id', '!=', $id) 
            ->pluck('name', 'id')
            ->toArray();
            
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Prevent parent-child circular reference
        if ($validated['parent_id'] == $id) {
            unset($validated['parent_id']);
        }
        
        // Update the category
        $category->update($validated);
        
        return redirect()->route('admin.categories.index')
            ->with('success', __('Category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        
        // Check if the category has news items
        $newsCount = News::where('category_id', $id)->count();
        
        if ($newsCount > 0) {
            return back()->with('error', __('Cannot delete category with associated news articles. Reassign articles first.'));
        }
        
        // Check if the category has child categories and handle them
        if ($category->children()->count() > 0) {
            // Option 1: Don't allow deletion
            // return back()->with('error', __('Cannot delete a category with child categories.'));
            
            // Option 2: Update children to parent's parent
            DB::transaction(function() use ($category) {
                $category->children()->update(['parent_id' => $category->parent_id]);
                $category->delete();
            });
        } else {
            $category->delete();
        }
        
        return redirect()->route('admin.categories.index')
            ->with('success', __('Category deleted successfully.'));
    }
}
