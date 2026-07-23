<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\ProjectCategory;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectCategoryController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the project categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = ProjectCategory::withCount('projects')->orderBy('name')->paginate(10);
        return view('admin.government.project-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new project category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.project-categories.create');
    }

    /**
     * Store a newly created project category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle icon upload
        if ($request->hasFile('icon')) {
            $validated['icon'] = $this->uploadFile($request->file('icon'), 'projects/categories');
        }
        
        ProjectCategory::create($validated);
        
        return redirect()->route('admin.government.project-categories.index')
            ->with('success', 'Project category created successfully.');
    }

    /**
     * Display the specified project category.
     *
     * @param  \App\Models\Government\ProjectCategory  $projectCategory
     * @return \Illuminate\View\View
     */
    public function show(ProjectCategory $projectCategory)
    {
        $projectCategory->load(['projects' => function($query) {
            $query->orderBy('created_at', 'desc')->take(5);
        }]);
        
        return view('admin.government.project-categories.show', [
            'category' => $projectCategory
        ]);
    }

    /**
     * Show the form for editing the specified project category.
     *
     * @param  \App\Models\Government\ProjectCategory  $projectCategory
     * @return \Illuminate\View\View
     */
    public function edit(ProjectCategory $projectCategory)
    {
        return view('admin.government.project-categories.edit', [
            'category' => $projectCategory
        ]);
    }

    /**
     * Update the specified project category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\ProjectCategory  $projectCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ProjectCategory $projectCategory)
    {
        $validated = $this->validateCategory($request, $projectCategory->id);
        
        // Generate slug if name has changed
        if ($projectCategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Handle icon upload
        if ($request->hasFile('icon')) {
            $validated['icon'] = $this->uploadFile(
                $request->file('icon'),
                'projects/categories',
                $projectCategory->icon
            );
        }
        
        $projectCategory->update($validated);
        
        return redirect()->route('admin.government.project-categories.index')
            ->with('success', 'Project category updated successfully.');
    }

    /**
     * Remove the specified project category from storage.
     *
     * @param  \App\Models\Government\ProjectCategory  $projectCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        // Check if category has projects
        if ($projectCategory->projects()->count() > 0) {
            return redirect()->route('admin.government.project-categories.index')
                ->with('error', 'Cannot delete category with associated projects.');
        }
        
        $projectCategory->delete();
        
        return redirect()->route('admin.government.project-categories.index')
            ->with('success', 'Project category deleted successfully.');
    }
    
    /**
     * Validate the project category request data.
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
                Rule::unique('government_project_categories')->ignore($id),
            ],
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|image|max:2048', // 2MB max
            'status' => 'nullable|string|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);
    }
} 