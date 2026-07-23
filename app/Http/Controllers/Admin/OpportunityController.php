<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\Opportunity;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OpportunityController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of opportunities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $opportunities = Opportunity::orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.opportunities.index', compact('opportunities'));
    }

    /**
     * Show the form for creating a new opportunity.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = [
            'circular-economy' => 'Circular Economy',
            'business' => 'Business',
            'agriculture' => 'Agriculture',
            'tourism' => 'Tourism & Culture'
        ];
        
        return view('admin.opportunities.create', compact('categories'));
    }

    /**
     * Store a newly created opportunity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'deadline' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'application_url' => 'nullable|url|max:255',
            'application_process' => 'nullable|string',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $this->uploadFile($request->file('image'), 'opportunities');
        } else {
            $imagePath = 'images/templates/placeholder.svg';
        }
        
        // Create the opportunity
        Opportunity::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $request->has('is_featured') ? 'featured_opportunity' : 'opportunity',
            'category' => $validated['category'],
            'deadline' => $validated['deadline'] ?? null,
            'location' => $validated['location'] ?? null,
            'contact' => $validated['contact'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'website' => $validated['website'] ?? null,
            'requirements' => $validated['requirements'] ?? [],
            'benefits' => $validated['benefits'] ?? [],
            'application_url' => $validated['application_url'] ?? null,
            'application_process' => $validated['application_process'] ?? null,
            'image' => $imagePath,
            'is_active' => true,
            'order' => 0,
        ]);
        
        return redirect()->route('admin.opportunities.index')
            ->with('success', __('Opportunity created successfully.'));
    }

    /**
     * Display the specified opportunity.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        
        return view('admin.opportunities.show', compact('opportunity'));
    }

    /**
     * Show the form for editing the specified opportunity.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        
        $categories = [
            'circular-economy' => 'Circular Economy',
            'business' => 'Business',
            'agriculture' => 'Agriculture',
            'tourism' => 'Tourism & Culture'
        ];
        
        return view('admin.opportunities.edit', compact('opportunity', 'categories'));
    }

    /**
     * Update the specified opportunity in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $opportunity = Opportunity::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'deadline' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'requirements' => 'nullable|array',
            'benefits' => 'nullable|array',
            'application_url' => 'nullable|url|max:255',
            'application_process' => 'nullable|string',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Only delete if it's not a default image
            $oldPath = null;
            if ($opportunity->image && !Str::contains($opportunity->image, 'templates/placeholder')) {
                $oldPath = $opportunity->image;
            }
            
            $opportunity->image = $this->uploadFile($request->file('image'), 'opportunities', $oldPath);
        }
        
        // Update the opportunity
        $opportunity->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $request->has('is_featured') ? 'featured_opportunity' : 'opportunity',
            'category' => $validated['category'],
            'deadline' => $validated['deadline'] ?? null,
            'location' => $validated['location'] ?? null,
            'contact' => $validated['contact'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'website' => $validated['website'] ?? null,
            'requirements' => $validated['requirements'] ?? [],
            'benefits' => $validated['benefits'] ?? [],
            'application_url' => $validated['application_url'] ?? null,
            'application_process' => $validated['application_process'] ?? null,
        ]);
        
        return redirect()->route('admin.opportunities.index')
            ->with('success', __('Opportunity updated successfully.'));
    }

    /**
     * Remove the specified opportunity from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        
        // Delete associated image if it's not a default image
        if ($opportunity->image && !Str::contains($opportunity->image, 'templates/placeholder')) {
            $this->deleteFile($opportunity->image);
        }
        
        $opportunity->delete();
        
        return redirect()->route('admin.opportunities.index')
            ->with('success', __('Opportunity deleted successfully.'));
    }
    
    /**
     * Toggle the active status of an opportunity.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->update(['is_active' => !$opportunity->is_active]);
        
        $status = $opportunity->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.opportunities.index')
            ->with('success', __("Opportunity {$status} successfully."));
    }
}
