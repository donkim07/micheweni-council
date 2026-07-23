<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Media;
use App\Models\Government\Project;
use App\Models\Government\News;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MediaController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the media.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Media::query();
        
        // Filter by type if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        $media = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.government.media.index', compact('media'));
    }

    /**
     * Show the form for creating a new media.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get projects and news for the category dropdown
        $projects = Project::orderBy('title')->get();
        $news = News::orderBy('title')->get();
        
        return view('admin.government.media.create', compact('projects', 'news'));
    }

    /**
     * Store a newly created media in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,document',
            'files.*' => 'required_without:video_url|file|max:20480',
            'video_url' => 'required_without:files|nullable|url|max:255',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,published,draft',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
            'category' => 'nullable|string',
            'related_id' => 'nullable|integer',
            'related_type' => 'nullable|string',
        ]);

        // Handle single file upload via video_url (existing functionality)
        if ($request->filled('video_url')) {
            $media = new Media();
            $media->title = $request->title;
            $media->description = $request->description;
            $media->type = $request->type;
            $media->file_path = null;
            $media->video_url = $request->video_url;
            $media->thumbnail_path = null;
            $media->status = $request->status;
            $media->is_featured = $request->has('is_featured');
            $media->order = $request->order ?? 0;
            $media->category = $request->category;

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailPath = $thumbnail->store('media/thumbnails', 'public');
                $media->thumbnail_path = $thumbnailPath;
            }

            // Handle relationship if specified
            if ($request->filled('related_id') && $request->filled('related_type')) {
                $media->model_id = $request->related_id;
                $media->model_type = $request->related_type;
            }

            $media->save();
        } 
        // Handle multiple file uploads (new functionality)
        elseif ($request->hasFile('files')) {
            $successCount = 0;
            foreach ($request->file('files') as $file) {
                $media = new Media();
                $media->title = $request->title;
                $media->description = $request->description;
                $media->type = $request->type;
                $media->video_url = null;
                $media->status = $request->status;
                $media->is_featured = $request->has('is_featured');
                $media->order = $request->order ?? 0;
                $media->category = $request->category;
                
                // Store the file using our FileUploader trait
                $filePath = $this->uploadFile($file, 'media/' . $request->type);
                $media->file_path = $filePath;
                
                // Handle thumbnail for videos and documents
                if (in_array($request->type, ['video', 'document'])) {
                    if ($request->hasFile('thumbnail')) {
                        $thumbnail = $request->file('thumbnail');
                        $thumbnailPath = $this->uploadFile($thumbnail, 'media/thumbnails');
                        $media->thumbnail_path = $thumbnailPath;
                    }
                }
                
                // Handle relationship if specified
                if ($request->filled('related_id') && $request->filled('related_type')) {
                    $media->model_id = $request->related_id;
                    $media->model_type = $request->related_type;
                }
                
                $media->save();
                $successCount++;
            }
            
            return redirect()->route('admin.government.media.index')
                ->with('success', $successCount . ' ' . __('media files uploaded successfully!'));
        }
        
        return redirect()->route('admin.government.media.index')
            ->with('success', __('Media created successfully!'));
    }

    /**
     * Show the form for editing the specified media.
     *
     * @param  \App\Models\Government\Media  $media
     * @return \Illuminate\View\View
     */
    public function edit(Media $media)
    {
        return view('admin.government.media.edit', compact('media'));
    }
    
    /**
     * Update the specified media in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Media  $media
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['image', 'video', 'document'])],
            'file' => 'nullable|file|max:10240', // 10MB max
            'thumbnail' => 'nullable|image|max:2048', // 2MB max for thumbnail
            'category' => 'nullable|string|max:100',
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
            'related_type' => 'nullable|string',
            'related_id' => 'nullable|integer',
        ]);
        
        // Handle file upload if present
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Store in the appropriate directory based on type
            $path = 'media/' . $validated['type'] . 's';
            $validated['file_path'] = $this->uploadFile($file, $path, $media->file_path);
        }
        
        // Handle thumbnail upload for videos and documents
        if ($request->hasFile('thumbnail') && in_array($validated['type'], ['video', 'document'])) {
            $thumbnail = $request->file('thumbnail');
            $validated['thumbnail_path'] = $this->uploadFile($thumbnail, 'media/thumbnails', $media->thumbnail_path);
        }
        
        // Handle category with related entity
        if ($request->filled('related_type') && $request->filled('related_id')) {
            $relatedType = $request->input('related_type');
            $relatedId = $request->input('related_id');
            
            if ($relatedType === 'project') {
                $project = Project::find($relatedId);
                if ($project) {
                    $validated['category'] = 'project';
                    $validated['model_type'] = Project::class;
                    $validated['model_id'] = $project->id;
                    
                    // Update or create project image if type is image
                    if ($validated['type'] === 'image') {
                        // Check if a project image exists for this media
                        $projectImage = $project->images()->where('image', $media->file_path)->first();
                        
                        if ($projectImage) {
                            // Update existing project image
                            $projectImage->update([
                                'image' => $validated['file_path'] ?? $media->file_path,
                                'caption' => $validated['title'],
                                'order' => $validated['order'] ?? 0,
                            ]);
                        } else {
                            // Create new project image
                            $project->images()->create([
                                'image' => $validated['file_path'] ?? $media->file_path,
                                'caption' => $validated['title'],
                                'capture_date' => now(),
                                'order' => $validated['order'] ?? 0,
                            ]);
                        }
                    }
                }
            } elseif ($relatedType === 'news') {
                $newsItem = News::find($relatedId);
                if ($newsItem) {
                    $validated['category'] = 'news';
                    $validated['model_type'] = News::class;
                    $validated['model_id'] = $newsItem->id;
                }
            }
        }
        
        // Update the media record
        $media->update($validated);
        
        return redirect()->route('admin.government.media.index')
            ->with('success', 'Media updated successfully.');
    }

    /**
     * Display the specified media.
     *
     * @param  \App\Models\Government\Media  $media
     * @return \Illuminate\View\View
     */
    public function show(Media $media)
    {
        return view('admin.government.media.show', compact('media'));
    }

    /**
     * Remove the specified media from storage.
     *
     * @param  \App\Models\Government\Media  $media
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Media $media)
    {
        // Delete the file
        if ($media->file_path) {
            $this->deleteFile($media->file_path);
        }
        
        // Delete the thumbnail if exists
        if ($media->thumbnail_path) {
            $this->deleteFile($media->thumbnail_path);
        }
        
        // Delete any associated project images
        if ($media->type === 'image' && $media->category === 'project' && $media->model_id) {
            $project = Project::find($media->model_id);
            if ($project) {
                $project->images()->where('image', $media->file_path)->delete();
            }
        }
        
        // Delete the media record
        $media->delete();
        
        return redirect()->route('admin.government.media.index')
            ->with('success', 'Media deleted successfully.');
    }
} 