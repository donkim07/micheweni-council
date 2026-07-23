<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Publication;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the publications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $publications = Publication::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.government.publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new publication.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.publications.create');
    }

    /**
     * Store a newly created publication in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validatePublication($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle file upload
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $this->uploadFile($request->file('file_path'), 'publications/files');
        }
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadFile($request->file('cover_image'), 'publications/covers');
        }
        
        Publication::create($validated);
        
        return redirect()->route('admin.government.publications.index')
            ->with('success', 'Publication created successfully.');
    }

    /**
     * Display the specified publication.
     *
     * @param  \App\Models\Government\Publication  $publication
     * @return \Illuminate\View\View
     */
    public function show(Publication $publication)
    {
        return view('admin.government.publications.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified publication.
     *
     * @param  \App\Models\Government\Publication  $publication
     * @return \Illuminate\View\View
     */
    public function edit(Publication $publication)
    {
        return view('admin.government.publications.edit', compact('publication'));
    }

    /**
     * Update the specified publication in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Publication  $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Publication $publication)
    {
        $validated = $this->validatePublication($request, $publication->id);
        
        // Generate slug if title has changed
        if ($publication->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle file upload
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $this->uploadFile(
                $request->file('file_path'),
                'publications/files',
                $publication->file_path
            );
        }
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadFile(
                $request->file('cover_image'),
                'publications/covers',
                $publication->cover_image
            );
        }
        
        $publication->update($validated);
        
        return redirect()->route('admin.government.publications.index')
            ->with('success', 'Publication updated successfully.');
    }

    /**
     * Remove the specified publication from storage.
     *
     * @param  \App\Models\Government\Publication  $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Publication $publication)
    {
        // Delete file if exists
        if ($publication->file_path) {
            $this->deleteFile($publication->file_path);
        }
        
        // Delete cover image if exists
        if ($publication->cover_image) {
            $this->deleteFile($publication->cover_image);
        }
        
        $publication->delete();
        
        return redirect()->route('admin.government.publications.index')
            ->with('success', 'Publication deleted successfully.');
    }
    
    /**
     * Validate the publication request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validatePublication(Request $request, $id = null)
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|max:10240', // 10MB max
            'cover_image' => 'nullable|image|max:2048', // 2MB max
            'category' => 'required|string|max:50',
            'published_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'sometimes|boolean',
            'order' => 'nullable|integer|min:0',
        ]);
    }
} 