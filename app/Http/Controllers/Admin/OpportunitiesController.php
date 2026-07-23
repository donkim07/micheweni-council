<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OpportunitiesController extends Controller
{
    /**
     * Display a listing of opportunities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $opportunities = Content::where('type', 'opportunity')
            ->orWhere('type', 'featured_opportunity')
            ->orderBy('created_at', 'desc')
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
            $imagePath = $request->file('image')->store('opportunities', 'public');
        } else {
            $imagePath = 'images/templates/placeholder.svg';
        }
        
        // Prepare meta data
        $metaData = [
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
        ];
        
        // Create the opportunity
        Content::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $request->has('is_featured') ? 'featured_opportunity' : 'opportunity',
            'is_active' => true,
            'meta_data' => json_encode($metaData),
            'order' => 0,
            'section' => 'opportunities',
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
        $opportunity = Content::findOrFail($id);
        
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
        $opportunity = Content::findOrFail($id);
        
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
        $opportunity = Content::findOrFail($id);
        
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
        
        // Get existing meta data
        $metaData = json_decode($opportunity->meta_data, true) ?? [];
        
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if it exists and is not a default image
            if (isset($metaData['image']) && !Str::contains($metaData['image'], 'templates/placeholder')) {
                Storage::disk('public')->delete($metaData['image']);
            }
            
            $metaData['image'] = $request->file('image')->store('opportunities', 'public');
        }
        
        // Update meta data
        $metaData['category'] = $validated['category'];
        $metaData['deadline'] = $validated['deadline'] ?? null;
        $metaData['location'] = $validated['location'] ?? null;
        $metaData['contact'] = $validated['contact'] ?? null;
        $metaData['email'] = $validated['email'] ?? null;
        $metaData['phone'] = $validated['phone'] ?? null;
        $metaData['website'] = $validated['website'] ?? null;
        $metaData['requirements'] = $validated['requirements'] ?? [];
        $metaData['benefits'] = $validated['benefits'] ?? [];
        $metaData['application_url'] = $validated['application_url'] ?? null;
        $metaData['application_process'] = $validated['application_process'] ?? null;
        
        // Update the opportunity
        $opportunity->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $request->has('is_featured') ? 'featured_opportunity' : 'opportunity',
            'meta_data' => json_encode($metaData),
            'section' => 'opportunities',
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
        $opportunity = Content::findOrFail($id);
        
        // Delete associated image if it's not a default image
        $metaData = json_decode($opportunity->meta_data, true) ?? [];
        if (isset($metaData['image']) && !Str::contains($metaData['image'], 'templates/placeholder')) {
            Storage::disk('public')->delete($metaData['image']);
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
        $opportunity = Content::findOrFail($id);
        $opportunity->update(['is_active' => !$opportunity->is_active]);
        
        $status = $opportunity->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.opportunities.index')
            ->with('success', __("Opportunity {$status} successfully."));
    }
} 