<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('opportunities.contact');
    }

    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy_policy' => 'required|accepted',
        ]);

        try {
            // Get admin email from config or use default
            $adminEmail = config('mail.admin_email', config('mail.from.address', 'admin@example.com'));
            
            // Send email to admin
            Mail::to($adminEmail)->send(new ContactFormSubmission($validated));
            
            // Log success
            Log::info('Contact form submitted', ['email' => $validated['email']]);
            
            return back()->with('success', 'Your message has been sent. Thank you!');
        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to send contact email', [
                'error' => $e->getMessage(),
                'email' => $validated['email']
            ]);
            
            return back()->with('error', 'There was a problem sending your message. Please try again later.')
                        ->withInput();
        }
    }
} 