<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Announcement;
use App\Models\Government\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the announcements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $announcements = Announcement::with('department')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.government.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.government.announcements.create', compact('departments'));
    }

    /**
     * Store a newly created announcement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateAnnouncement($request);
        
        Announcement::create($validated);
        
        return redirect()->route('admin.government.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    /**
     * Display the specified announcement.
     *
     * @param  \App\Models\Government\Announcement  $announcement
     * @return \Illuminate\View\View
     */
    public function show(Announcement $announcement)
    {
        $announcement->load('department');
        return view('admin.government.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified announcement.
     *
     * @param  \App\Models\Government\Announcement  $announcement
     * @return \Illuminate\View\View
     */
    public function edit(Announcement $announcement)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.government.announcements.edit', compact('announcement', 'departments'));
    }

    /**
     * Update the specified announcement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Announcement  $announcement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $this->validateAnnouncement($request);
        
        $announcement->update($validated);
        
        return redirect()->route('admin.government.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement from storage.
     *
     * @param  \App\Models\Government\Announcement  $announcement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        return redirect()->route('admin.government.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
    
    /**
     * Validate the announcement request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateAnnouncement(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'department_id' => 'nullable|exists:government_departments,id',
            'type' => 'required|in:alert,info,warning,success',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);
    }
} 