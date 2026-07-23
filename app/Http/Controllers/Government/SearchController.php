<?php

namespace App\Http\Controllers\Government;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Government\Service;
use App\Models\Government\Department;
use App\Models\Government\News;
use App\Models\Government\Project;
use App\Models\Government\Publication;
use App\Models\Government\Announcement;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Handle the search request
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search term');
        }
        
        // Search in services
        $services = Service::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('short_description', 'like', "%{$query}%")
            ->get();
            
        // Search in departments
        $departments = Department::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
            
        // Search in news
        $news = News::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->orWhere('excerpt', 'like', "%{$query}%")
            ->get();
            
        // Search in projects
        $projects = Project::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
            
        // Search in publications
        $publications = Publication::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
            
        // Search in announcements
        $announcements = Announcement::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get();
        
        // Count total results
        $totalResults = $services->count() + $departments->count() + $news->count() + 
                        $projects->count() + $publications->count() + $announcements->count();
        
        return view('government.search.results', compact(
            'query', 
            'services', 
            'departments', 
            'news', 
            'projects', 
            'publications', 
            'announcements',
            'totalResults'
        ));
    }
} 