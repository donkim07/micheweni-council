<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Department;
use App\Models\Government\Service;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $services = Service::with('department')->orderBy('order')->paginate(10);
        return view('admin.government.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.government.services.create', compact('departments'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateService($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile($request->file('featured_image'), 'services');
        }
        
        Service::create($validated);
        
        return redirect()->route('admin.government.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified service.
     *
     * @param  \App\Models\Government\Service  $service
     * @return \Illuminate\View\View
     */
    public function show(Service $service)
    {
        $service->load('department');
        return view('admin.government.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  \App\Models\Government\Service  $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.government.services.edit', compact('service', 'departments'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request, $service->id);
        
        // Generate slug if title has changed
        if ($service->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile(
                $request->file('featured_image'), 
                'services', 
                $service->featured_image
            );
        }
        
        $service->update($validated);
        
        return redirect()->route('admin.government.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Government\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        // Delete image if it exists
        if ($service->featured_image) {
            $this->deleteFile($service->featured_image);
        }
        
        $service->delete();
        
        return redirect()->route('admin.government.services.index')
            ->with('success', 'Service deleted successfully.');
    }
    
    /**
     * Update the order of services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:government_services,id',
        ]);
        
        foreach ($request->order as $index => $id) {
            Service::where('id', $id)->update(['order' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Validate the service request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validateService(Request $request, $id = null)
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('government_services')->ignore($id),
            ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:50',
            'featured_image' => 'nullable|image|max:2048',
            'department_id' => 'nullable|exists:government_departments,id',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
        ]);
    }
    
    // Using the FileUploader trait instead of local uploadImage method
} 