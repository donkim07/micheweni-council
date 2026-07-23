<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use App\Models\Opportunities\CircularEconomy\WasteLocation;
use App\Models\Opportunities\CircularEconomy\WasteListing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class WasteController extends Controller
{
    /**
     * Display the waste map.
     *
     * @return \Illuminate\View\View
     */
    public function map()
    {
        $wasteLocations = WasteLocation::where('is_active', true)->get();
        
        // Count locations by type
        $collectionPoints = $wasteLocations->where('type', 'collection_point')->count();
        $recyclingCenters = $wasteLocations->where('type', 'recycling_center')->count();
        $transferStations = $wasteLocations->where('type', 'transfer_station')->count();
        
        // Use default values if none found
        if ($collectionPoints == 0) $collectionPoints = 2;
        if ($recyclingCenters == 0) $recyclingCenters = 1;
        if ($transferStations == 0) $transferStations = 1;
        
        return view('opportunities.circular-economy.waste.map', [
            'wasteLocations' => $wasteLocations,
            'collectionPoints' => $collectionPoints,
            'recyclingCenters' => $recyclingCenters,
            'transferStations' => $transferStations
        ]);
    }
    public function index()
    {
        return view('opportunities.circular-economy.waste.index');
    }

    /**
     * Display collection points.
     *
     * @return \Illuminate\View\View
     */
    public function collection()
    {
        return view('opportunities.circular-economy.waste.collection');
    }

    /**
     * Display recycling centers.
     *
     * @return \Illuminate\View\View
     */
    public function recycling()
    {
        return view('opportunities.circular-economy.waste.recycling');
    }

    /**
     * Display waste service providers directory.
     *
     * @return \Illuminate\View\View
     */
    public function directory()
    {
        return view('opportunities.circular-economy.waste.directory');
    }
    
    /**
     * Display all waste locations.
     *
     * @return \Illuminate\View\View
     */
    public function locations()
    {
        $locations = WasteLocation::where('is_active', true)->get();
        
        return view('opportunities.circular-economy.waste.locations', [
            'locations' => $locations,
        ]);
    }
    
    /**
     * Display waste trading marketplace.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function marketplace(Request $request)
    {
        // Apply filters if provided
        $query = WasteListing::with('user');
        
        if ($request->has('category') && !empty($request->category)) {
            $query->byCategory($request->category);
        }
        
        if ($request->has('location') && !empty($request->location)) {
            $query->byLocation($request->location);
        }
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Get all listings
        $listings = $query->latest()->paginate(12);
        
        // Get service providers
        $serviceProviders = User::whereHas('roles', function($query) {
            $query->where('name', 'service_provider');
        })->with('profile')->take(6)->get();
        
        // Get waste trade categories
        $categories = [
            'recyclable_materials' => __('Recyclable Materials'),
            'equipment_machinery' => __('Equipment & Machinery'),
            'collection_services' => __('Collection Services'),
            'consulting_services' => __('Consulting Services'),
            'training_education' => __('Training & Education'),
            'composting_services' => __('Composting Services')
        ];
        
        return view('opportunities.circular-economy.waste.marketplace', [
            'serviceProviders' => $serviceProviders,
            'listings' => $listings,
            'categories' => $categories
        ]);
    }
    
    /**
     * Show the form for creating a new listing.
     *
     * @return \Illuminate\View\View
     */
    public function createListing()
    {
        $this->middleware('auth');
        
        $categories = [
            'recyclable_materials' => __('Recyclable Materials'),
            'equipment_machinery' => __('Equipment & Machinery'),
            'collection_services' => __('Collection Services'),
            'consulting_services' => __('Consulting Services'),
            'training_education' => __('Training & Education'),
            'composting_services' => __('Composting Services')
        ];
        
        return view('opportunities.circular-economy.waste.create-listing', [
            'categories' => $categories
        ]);
    }
    
    /**
     * Store a newly created listing.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeListing(Request $request)
    {
        $this->middleware('auth');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_unit' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $listing = new WasteListing();
        $listing->user_id = Auth::id();
        $listing->title = $request->title;
        $listing->description = $request->description;
        $listing->category = $request->category;
        $listing->price = $request->price;
        $listing->price_unit = $request->price_unit;
        $listing->location = $request->location;
        $listing->is_available = true;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug(substr($request->title, 0, 20)) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/listings', $filename);
            $listing->image = 'storage/listings/' . $filename;
        }
        
        $listing->save();
        
        return redirect()->route('opportunities.circular-economy.waste.marketplace')
            ->with('success', __('Listing created successfully.'));
    }
    
    /**
     * Display the specified listing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showListing($id)
    {
        $listing = WasteListing::findOrFail($id);
        
        return view('opportunities.circular-economy.waste.show-listing', [
            'listing' => $listing
        ]);
    }
    
    /**
     * Display listings for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function myListings()
    {
        $this->middleware('auth');
        
        $listings = WasteListing::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('opportunities.circular-economy.waste.my-listings', [
            'listings' => $listings
        ]);
    }
    
    /**
     * Toggle the availability status of a listing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleListingStatus($id)
    {
        $this->middleware('auth');
        
        $listing = WasteListing::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $listing->is_available = !$listing->is_available;
        $listing->save();
        
        return back()->with('success', __('Listing status updated successfully.'));
    }
} 