<?php

namespace App\Http\Controllers\Government;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Role;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('government.contact.index');
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
        ]);

        try {
            // Log the submission
            Log::info('Contact form submitted', ['email' => $validated['email']]);

            // Get admin users to send the email to
            $adminRole = Role::where('slug', 'admin')->first();
            $adminUsers = $adminRole ? $adminRole->users : collect();
            
            // If no admin users found, use the default admin email from config
            if ($adminUsers->isEmpty()) {
                $adminEmails = [config('mail.admin_address')];
            } else {
                $adminEmails = $adminUsers->pluck('email')->toArray();
            }
            
            // Send email notification to all admin users
            Mail::to($adminEmails)
                ->send(new ContactFormSubmission($validated));

            return redirect()->route('government.contact')
                ->with('success', __('Thank you for your message. We will get back to you soon!'));
        } catch (\Exception $e) {
            Log::error('Failed to process contact form', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);

            return redirect()->route('government.contact')
                ->with('error', __('Sorry, there was an error processing your request. Please try again later.'));
        }
    }
}
