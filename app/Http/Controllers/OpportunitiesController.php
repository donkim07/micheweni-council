<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\SavedOpportunity;
use Illuminate\Support\Facades\Auth;

class OpportunitiesController extends Controller
{
    /**
     * Display the opportunities index page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get featured opportunities
        $featuredOpportunities = Content::where('type', 'featured_opportunity')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // Get regular opportunities
        $opportunities = Content::where('type', 'opportunity')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        // Get categories for filter
        $categories = [
            'circular-economy' => 'Circular Economy',
            'business' => 'Business',
            'agriculture' => 'Agriculture',
            'tourism' => 'Tourism & Culture'
        ];
        
        return view('opportunities.index', compact('featuredOpportunities', 'opportunities', 'categories'));
    }
    
    /**
     * Display a specific opportunity
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $opportunity = Content::findOrFail($id);
        
        // Check if opportunity is of correct type
        if (!in_array($opportunity->type, ['featured_opportunity', 'opportunity'])) {
            abort(404);
        }
        
        // Get related opportunities
        $relatedOpportunities = Content::where('type', 'opportunity')
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
        
        $opportunities = Content::where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->where('is_active', true)
            ->whereIn('type', ['opportunity', 'featured_opportunity']);
            
        if (!empty($category)) {
            $opportunities = $opportunities->whereRaw("JSON_EXTRACT(meta_data, '$.category') = ?", [$category]);
        }
        
        $opportunities = $opportunities->paginate(12);
        
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
        $type = $request->input('type');
        
        // Check if already saved
        $existing = SavedOpportunity::where('user_id', Auth::id())
            ->where('opportunity_id', $id)
            ->where('type', $type)
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
            'type' => $type
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
        
        $savedItems = SavedOpportunity::where('user_id', Auth::id())->get();
        
        $opportunities = collect();
        
        foreach ($savedItems as $item) {
            if ($item->type === 'opportunity') {
                $opportunity = Content::find($item->opportunity_id);
                if ($opportunity) {
                    $opportunities->push($opportunity);
                }
            }
        }
        
        return view('opportunities.saved', compact('opportunities'));
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
} 