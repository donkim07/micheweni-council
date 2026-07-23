<?php

namespace App\Http\Controllers\Admin\Opportunities\CircularEconomy;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\WasteLocation;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WasteLocationController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WasteLocation::query();
        
        // Filter by type if provided
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }
        
        // Filter by active status if provided
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }
        
        // Search by name or address if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $wasteLocations = $query->orderBy('name')->paginate(15);
        $locationTypes = $this->getLocationTypes();
        
        return view('admin.waste-locations.index', compact('wasteLocations', 'locationTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locationTypes = $this->getLocationTypes();
        $acceptedMaterials = $this->getAcceptedMaterials();
        
        return view('admin.waste-locations.create', compact('locationTypes', 'acceptedMaterials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'operating_hours' => 'nullable|array',
            'accepted_materials' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
        
        // Handle file uploads for image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $this->uploadFile($request->file('image'), 'waste-locations');
        }
        
        // Handle JSON data
        if (isset($validated['operating_hours'])) {
            $validated['operating_hours'] = json_encode($validated['operating_hours']);
        }
        
        if (isset($validated['accepted_materials'])) {
            $validated['accepted_materials'] = json_encode($validated['accepted_materials']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        
        // Create the waste location
        $wasteLocation = WasteLocation::create($validated);
        
        return redirect()->route('admin.waste-locations.edit', $wasteLocation)
            ->with('success', __('Waste location created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $wasteLocation = WasteLocation::findOrFail($id);
        return view('admin.waste-locations.show', compact('wasteLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $wasteLocation = WasteLocation::findOrFail($id);
        $locationTypes = $this->getLocationTypes();
        $acceptedMaterials = $this->getAcceptedMaterials();
        
        // Decode JSON data for the form
        if (!empty($wasteLocation->operating_hours)) {
            $wasteLocation->operating_hours = json_decode($wasteLocation->operating_hours, true);
        }
        
        if (!empty($wasteLocation->accepted_materials)) {
            $wasteLocation->accepted_materials = json_decode($wasteLocation->accepted_materials, true);
        }
        
        return view('admin.waste-locations.edit', compact('wasteLocation', 'locationTypes', 'acceptedMaterials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wasteLocation = WasteLocation::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'operating_hours' => 'nullable|array',
            'accepted_materials' => 'nullable|array',
            'is_active' => 'boolean',
        ]);
        
        // Handle file uploads for image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $this->uploadFile(
                $request->file('image'),
                'waste-locations',
                $wasteLocation->image
            );
        }
        
        // Handle JSON data
        if (isset($validated['operating_hours'])) {
            $validated['operating_hours'] = json_encode($validated['operating_hours']);
        }
        
        if (isset($validated['accepted_materials'])) {
            $validated['accepted_materials'] = json_encode($validated['accepted_materials']);
        }
        
        // Set default values for checkboxes if not present
        $validated['is_active'] = $request->has('is_active');
        
        // Update the waste location
        $wasteLocation->update($validated);
        
        return redirect()->route('admin.waste-locations.edit', $wasteLocation)
            ->with('success', __('Waste location updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wasteLocation = WasteLocation::findOrFail($id);
        
        // Delete the image if exists
        if (!empty($wasteLocation->image)) {
            $this->deleteFile($wasteLocation->image);
        }
        
        $wasteLocation->delete();
        
        return redirect()->route('admin.waste-locations.index')
            ->with('success', __('Waste location deleted successfully.'));
    }
    
    /**
     * Get available waste location types.
     */
    private function getLocationTypes()
    {
        return [
            'collection_point' => __('Collection Point'),
            'recycling_center' => __('Recycling Center'),
            'landfill' => __('Landfill'),
            'transfer_station' => __('Transfer Station'),
            'composting_facility' => __('Composting Facility'),
            'hazardous_waste' => __('Hazardous Waste Facility'),
            'e_waste' => __('E-Waste Collection'),
            'buy_back_center' => __('Buy-Back Center'),
        ];
    }
    
    /**
     * Get available accepted materials.
     */
    private function getAcceptedMaterials()
    {
        return [
            'general_waste' => __('General Waste'),
            'plastic' => __('Plastic'),
            'paper' => __('Paper'),
            'cardboard' => __('Cardboard'),
            'glass' => __('Glass'),
            'metal' => __('Metal'),
            'electronics' => __('Electronics'),
            'batteries' => __('Batteries'),
            'hazardous' => __('Hazardous Materials'),
            'organic' => __('Organic/Food Waste'),
            'garden' => __('Garden Waste'),
            'construction' => __('Construction Debris'),
            'textiles' => __('Textiles/Clothing'),
            'oil' => __('Oil'),
            'tires' => __('Tires'),
            'furniture' => __('Furniture'),
        ];
    }
} 