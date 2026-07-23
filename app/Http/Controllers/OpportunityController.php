<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunities\Opportunity;
use App\Models\Opportunities\CircularEconomy\SavedOpportunity;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the opportunities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Define categories for dropdown
        $categories = [
            'circular-economy' => 'Circular Economy',
            'business' => 'Business',
            'agriculture' => 'Agriculture',
            'tourism' => 'Tourism & Culture',
        ];
        
        // Get opportunities with user-created first, then featured ones
        $opportunities = Opportunity::where('is_active', true)
            ->orderByRaw("CASE WHEN type = 'opportunity' THEN 1 WHEN type = 'featured_opportunity' THEN 2 ELSE 3 END")
            ->latest()
            ->paginate(9);
        
        // Get user's saved opportunities
        $savedOpportunities = [];
        if (Auth::check()) {
            $savedOpportunities = SavedOpportunity::where('user_id', Auth::id())
                ->pluck('opportunity_id')
                ->toArray();
        }
        
        return view('opportunities.index', compact('opportunities', 'categories', 'savedOpportunities'));
    }
    
    /**
     * Display a specific opportunity
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        
        // Check if opportunity is of correct type
        if (!in_array($opportunity->type, ['featured_opportunity', 'opportunity'])) {
            abort(404);
        }
        
        // Get related opportunities
        $relatedOpportunities = Opportunity::where('type', 'opportunity')
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->take(3)
            ->get();
            
        return view('opportunities.show', compact('opportunity', 'relatedOpportunities'));
    }
    
    /**
     * Search for opportunities
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $category = $request->input('category');
        
        $queryBuilder = Opportunity::where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->where('is_active', true)
            ->whereIn('type', ['opportunity', 'featured_opportunity']);
            
        if (!empty($category)) {
            $queryBuilder->where('category', $category);
        }
        
        $opportunities = $queryBuilder->paginate(12);
        
        return view('opportunities.search', compact('opportunities', 'query', 'category'));
    }
    
    /**
     * Save an opportunity for a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to save opportunities'
            ], 401);
        }
        
        $id = $request->input('id');
        
        // Check if opportunity exists
        $opportunity = Opportunity::findOrFail($id);
        
        // Check if already saved
        $existing = SavedOpportunity::where('user_id', Auth::id())
            ->where('opportunity_id', $id)
            ->first();
            
        if ($existing) {
            // If already saved, remove it
            $existing->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Opportunity removed from saved items',
                'action' => 'removed'
            ]);
        }
        
        // Create new saved opportunity
        SavedOpportunity::create([
            'user_id' => Auth::id(),
            'opportunity_id' => $id,
            'notes' => null
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Opportunity saved successfully',
            'action' => 'saved'
        ]);
    }
    
    /**
     * Display user's saved opportunities
     *
     * @return \Illuminate\View\View
     */
    public function savedOpportunities()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $savedOpportunities = SavedOpportunity::where('user_id', Auth::id())
            ->with('opportunity')
            ->get()
            ->pluck('opportunity');
        
        return view('opportunities.saved', compact('savedOpportunities'));
    }
    
    /**
     * Display user's opportunity applications
     *
     * @return \Illuminate\View\View
     */
    public function applications()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Get user's applications
        $applications = [];
        
        return view('opportunities.applications', compact('applications'));
    }
    
    /**
     * Display contact page
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('opportunities.contact');
    }
    
    /**
     * Display opportunities by category
     *
     * @param string $category
     * @return \Illuminate\View\View
     */
    public function byCategory($category)
    {
        // Check if this is a valid category
        $validCategories = [
            'circular-economy' => 'Circular Economy',
            'business' => 'Business',
            'agriculture' => 'Agriculture',
            'tourism' => 'Tourism & Culture'
        ];
        
        if (!array_key_exists($category, $validCategories)) {
            abort(404);
        }
        
        // Get opportunities for this category with user-created first, then featured ones
        $opportunities = Opportunity::where('category', $category)
            ->where('is_active', true)
            ->orderByRaw("CASE WHEN type = 'opportunity' THEN 1 WHEN type = 'featured_opportunity' THEN 2 ELSE 3 END")
            ->latest()
            ->paginate(9);
        
        $categoryName = $validCategories[$category];
        
        // Get user's saved opportunities
        $savedOpportunities = [];
        if (Auth::check()) {
            $savedOpportunities = SavedOpportunity::where('user_id', Auth::id())
                ->pluck('opportunity_id')
                ->toArray();
        }
        
        return view('opportunities.category', compact('opportunities', 'category', 'categoryName', 'savedOpportunities'));
    }
}
