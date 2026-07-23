<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Statistics;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $statistics = Statistics::orderBy('order')->paginate(10);
        return view('admin.government.statistics.index', compact('statistics'));
    }

    /**
     * Show the form for creating new statistics.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.statistics.create');
    }

    /**
     * Store newly created statistics in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateStatistics($request);
        
        Statistics::create($validated);
        
        return redirect()->route('admin.government.statistics.index')
            ->with('success', 'Statistics created successfully.');
    }

    /**
     * Display the specified statistics.
     *
     * @param  \App\Models\Government\Statistics  $statistic
     * @return \Illuminate\View\View
     */
    public function show(Statistics $statistic)
    {
        return view('admin.government.statistics.show', compact('statistic'));
    }

    /**
     * Show the form for editing the specified statistics.
     *
     * @param  \App\Models\Government\Statistics  $statistic
     * @return \Illuminate\View\View
     */
    public function edit(Statistics $statistic)
    {
        return view('admin.government.statistics.edit', compact('statistic'));
    }

    /**
     * Update the specified statistics in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Statistics  $statistic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Statistics $statistic)
    {
        $validated = $this->validateStatistics($request);
        
        $statistic->update($validated);
        
        return redirect()->route('admin.government.statistics.index')
            ->with('success', 'Statistics updated successfully.');
    }

    /**
     * Remove the specified statistics from storage.
     *
     * @param  \App\Models\Government\Statistics  $statistic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Statistics $statistic)
    {
        $statistic->delete();
        
        return redirect()->route('admin.government.statistics.index')
            ->with('success', 'Statistics deleted successfully.');
    }
    
    /**
     * Validate the statistics request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateStatistics(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:50',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
            'color' => 'nullable|string|max:30',
        ]);
    }
} 