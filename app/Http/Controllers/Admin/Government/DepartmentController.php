<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Department;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $departments = Department::orderBy('order')->paginate(10);
        return view('admin.government.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.departments.create');
    }

    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateDepartment($request);
        
        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle head image upload
        if ($request->hasFile('head_image')) {
            $validated['head_image'] = $this->uploadFile($request->file('head_image'), 'departments/heads');
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile($request->file('featured_image'), 'departments');
        }
        
        $department = Department::create($validated);
        
        // Create empty department details
        $department->detail()->create([
            'overview' => null,
            'responsibilities' => null,
            'statistics' => null,
        ]);
        
        return redirect()->route('admin.government.departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department.
     *
     * @param  \App\Models\Government\Department  $department
     * @return \Illuminate\View\View
     */
    public function show(Department $department)
    {
        $department->load(['services', 'projects', 'detail']);
        return view('admin.government.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified department.
     *
     * @param  \App\Models\Government\Department  $department
     * @return \Illuminate\View\View
     */
    public function edit(Department $department)
    {
        return view('admin.government.departments.edit', compact('department'));
    }

    /**
     * Show the form for editing the department details.
     *
     * @param  \App\Models\Government\Department  $department
     * @return \Illuminate\View\View
     */
    public function editDetails(Department $department)
    {
        if (!$department->detail) {
            $department->detail()->create([
                'overview' => null,
                'responsibilities' => null,
                'statistics' => null,
            ]);
            $department->load('detail');
        }
        
        return view('admin.government.departments.edit-details', compact('department'));
    }

    /**
     * Update the department details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Department  $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDetails(Request $request, Department $department)
    {
        $validated = $request->validate([
            'overview' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'statistics' => 'nullable|array',
            'statistics.*.label' => 'required|string|max:255',
            'statistics.*.value' => 'required|string|max:255',
            'statistics.*.icon' => 'nullable|string|max:255',
            'include_services_count' => 'nullable|boolean',
            'include_projects_count' => 'nullable|boolean',
        ]);
        
        // Convert checkbox values to boolean
        $validated['include_services_count'] = isset($request->include_services_count);
        $validated['include_projects_count'] = isset($request->include_projects_count);
        
        if (!$department->detail) {
            $department->detail()->create($validated);
        } else {
            $department->detail->update($validated);
        }
        
        return redirect()->route('admin.government.departments.show', $department)
            ->with('success', 'Department details updated successfully.');
    }

    /**
     * Update the specified department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Department  $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Department $department)
    {
        $validated = $this->validateDepartment($request, $department->id);
        
        // Generate slug if name has changed
        if ($department->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Handle head image upload
        if ($request->hasFile('head_image')) {
            $validated['head_image'] = $this->uploadFile(
                $request->file('head_image'),
                'departments/heads',
                $department->head_image
            );
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadFile(
                $request->file('featured_image'),
                'departments',
                $department->featured_image
            );
        }
        
        $department->update($validated);
        
        return redirect()->route('admin.government.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department from storage.
     *
     * @param  \App\Models\Government\Department  $department
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Department $department)
    {
        // Delete images if they exist
        if ($department->head_image) {
            $this->deleteFile($department->head_image);
        }
        
        if ($department->featured_image) {
            $this->deleteFile($department->featured_image);
        }
        
        $department->delete();
        
        return redirect()->route('admin.government.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
    
    /**
     * Update the order of departments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:government_departments,id',
        ]);
        
        foreach ($request->order as $index => $id) {
            Department::where('id', $id)->update(['order' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Validate the department request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $id
     * @return array
     */
    private function validateDepartment(Request $request, $id = null)
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('government_departments')->ignore($id),
            ],
            'description' => 'nullable|string',
            'category' => 'required|string|in:department,division',
            'head_name' => 'nullable|string|max:255',
            'head_title' => 'nullable|string|max:255',
            'head_image' => 'nullable|image|max:2048',
            'featured_image' => 'nullable|image|max:2048',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);
    }
    
    // Using FileUploader trait instead of local uploadImage method
} 