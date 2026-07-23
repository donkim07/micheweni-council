<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Project;
use App\Models\Government\ProjectCategory;
use App\Models\Government\Department;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::with(['category', 'department'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.government.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = ProjectCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        
        return view('admin.government.projects.create', compact('categories', 'departments'));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateProject($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile($request->file('featured_image'), 'projects');
        }
        
        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $this->uploadFile($image, 'projects/gallery');
            }
            $validated['gallery'] = json_encode($gallery);
        }
        
        Project::create($validated);
        
        return redirect()->route('admin.government.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     *
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project)
    {
        $project->load(['category', 'department']);
        return view('admin.government.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $categories = ProjectCategory::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        
        return view('admin.government.projects.edit', compact('project', 'categories', 'departments'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request, $project->id);
        
        // Generate slug if title has changed
        if ($project->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile(
                $request->file('featured_image'), 
                'projects', 
                $project->featured_image
            );
        }
        
        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            $existingGallery = $project->gallery ? json_decode($project->gallery, true) : [];
            
            // Delete removed images
            if ($request->input('removed_gallery')) {
                $removed = explode(',', $request->input('removed_gallery'));
                foreach ($removed as $path) {
                    $this->deleteFile($path);
                    $existingGallery = array_diff($existingGallery, [$path]);
                }
            }
            
            // Add new images
            $newGallery = $existingGallery;
            foreach ($request->file('gallery') as $image) {
                $newGallery[] = $this->uploadFile($image, 'projects/gallery');
            }
            
            $validated['gallery'] = json_encode($newGallery);
        } elseif ($request->input('removed_gallery')) {
            // Only remove images without adding new ones
            $existingGallery = $project->gallery ? json_decode($project->gallery, true) : [];
            $removed = explode(',', $request->input('removed_gallery'));
            
            foreach ($removed as $path) {
                $this->deleteFile($path);
                $existingGallery = array_diff($existingGallery, [$path]);
            }
            
            $validated['gallery'] = json_encode(array_values($existingGallery));
        }
        
        $project->update($validated);
        
        return redirect()->route('admin.government.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        // Delete featured image if exists
        if ($project->featured_image) {
            $this->deleteFile($project->featured_image);
        }
        
        // Delete gallery images if exist
        if ($project->gallery) {
            $gallery = json_decode($project->gallery, true);
            foreach ($gallery as $image) {
                $this->deleteFile($image);
            }
        }
        
        $project->delete();
        
        return redirect()->route('admin.government.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
    
    /**
     * Validate the project request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validateProject(Request $request, $id = null)
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('government_projects')->ignore($id),
            ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'status' => 'required|in:planned,ongoing,completed,cancelled,inactive',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'category_id' => 'nullable|exists:government_project_categories,id',
            'department_id' => 'nullable|exists:government_departments,id',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
        ]);
    }
    
    // Using the FileUploader trait instead of local uploadImage method
} 