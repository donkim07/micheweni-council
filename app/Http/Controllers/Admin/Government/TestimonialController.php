<?php

namespace App\Http\Controllers\Admin\Government;

use App\Http\Controllers\Controller;
use App\Models\Government\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the testimonials.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.government.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.government.testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $this->validateTestimonial($request);
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $this->uploadImage($request->file('avatar'), 'testimonials');
        }
        
        Testimonial::create($validated);
        
        return redirect()->route('admin.government.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified testimonial.
     *
     * @param  \App\Models\Government\Testimonial  $testimonial
     * @return \Illuminate\View\View
     */
    public function show(Testimonial $testimonial)
    {
        return view('admin.government.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified testimonial.
     *
     * @param  \App\Models\Government\Testimonial  $testimonial
     * @return \Illuminate\View\View
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.government.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Government\Testimonial  $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $this->validateTestimonial($request);
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($testimonial->avatar) {
                Storage::delete('public/' . $testimonial->avatar);
            }
            
            $validated['avatar'] = $this->uploadImage($request->file('avatar'), 'testimonials');
        }
        
        $testimonial->update($validated);
        
        return redirect()->route('admin.government.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified testimonial from storage.
     *
     * @param  \App\Models\Government\Testimonial  $testimonial
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete avatar if exists
        if ($testimonial->avatar) {
            Storage::delete('public/' . $testimonial->avatar);
        }
        
        $testimonial->delete();
        
        return redirect()->route('admin.government.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
    
    /**
     * Validate the testimonial request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateTestimonial(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:1024',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'boolean',
        ]);
    }
    
    /**
     * Upload an image and return the path.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  string  $path
     * @return string
     */
    private function uploadImage($image, $path)
    {
        $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/' . $path, $filename);
        return $path . '/' . $filename;
    }
} 