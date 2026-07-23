<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Project;
use App\Models\Government\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectImageController extends Controller
{
    /**
     * Display a listing of the project images.
     *
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\View\View
     */
    public function index(Project $project)
    {
        $images = $project->images()->orderBy('order')->get();
        return view('admin.government.projects.images.index', compact('project', 'images'));
    }

    /**
     * Show the form for creating a new project image.
     *
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\View\View
     */
    public function create(Project $project)
    {
        return view('admin.government.projects.images.create', compact('project'));
    }

    /**
     * Store a newly created project image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
            'capture_date' => 'nullable|date',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('projects/images', $fileName, 'public');
                
                $project->images()->create([
                    'image' => $path,
                    'caption' => $request->input('caption'),
                    'capture_date' => $request->input('capture_date') ? date('Y-m-d', strtotime($request->input('capture_date'))) : now()->format('Y-m-d'),
                    'order' => $project->images()->count() + 1,
                ]);
            }
        }

        return redirect()->route('admin.government.projects.images.index', $project)
            ->with('success', 'Project images uploaded successfully.');
    }

    /**
     * Show the form for editing the specified project image.
     *
     * @param  \App\Models\Government\Project  $project
     * @param  \App\Models\Government\ProjectImage  $image
     * @return \Illuminate\View\View
     */
    public function edit(Project $project, ProjectImage $image)
    {
        return view('admin.government.projects.images.edit', compact('project', 'image'));
    }

    /**
     * Update the specified project image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Project  $project
     * @param  \App\Models\Government\ProjectImage  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project, ProjectImage $image)
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'caption' => 'nullable|string|max:255',
            'capture_date' => 'nullable|date',
            'order' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($image->image);
            
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('projects/images', $fileName, 'public');
            
            $image->image = $path;
        }

        $image->caption = $request->input('caption');
        $image->capture_date = $request->input('capture_date') ? date('Y-m-d', strtotime($request->input('capture_date'))) : $image->capture_date;
        $image->order = $request->input('order') ?? $image->order;
        $image->save();

        return redirect()->route('admin.government.projects.images.index', $project)
            ->with('success', 'Project image updated successfully.');
    }

    /**
     * Remove the specified project image from storage.
     *
     * @param  \App\Models\Government\Project  $project
     * @param  \App\Models\Government\ProjectImage  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project, ProjectImage $image)
    {
        // Delete the image file
        Storage::disk('public')->delete($image->image);
        
        // Delete the image record
        $image->delete();

        return redirect()->route('admin.government.projects.images.index', $project)
            ->with('success', 'Project image deleted successfully.');
    }

    /**
     * Update the order of multiple project images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request, Project $project)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'integer|exists:government_project_images,id',
        ]);

        foreach ($request->input('images') as $index => $id) {
            $image = ProjectImage::find($id);
            if ($image && $image->project_id === $project->id) {
                $image->order = $index + 1;
                $image->save();
            }
        }

        return response()->json(['success' => true]);
    }
} 