<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;
use App\Models\User;
use App\Models\Opportunities\CircularEconomy\News;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    /**
     * Handle newsletter subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        // Check if already subscribed
        $exists = NewsletterSubscription::where('email', $validated['email'])->first();
        
        if ($exists) {
            return back()->with('info', 'You are already subscribed to our newsletter.');
        }
        // Get name from authenticated user if available
        if (Auth::check() && empty($validated['name'])) {
            $validated['name'] = Auth::user()->name;
        }

        // Create new subscription
        NewsletterSubscription::create([
            'email' => $validated['email'],
            'name' => $validated['name'] ?? null,
            'subscribed_at' => now(),
        ]);

        return back()->with('success', 'You have been successfully subscribed to our newsletter.');
    }

    /**
     * Handle newsletter unsubscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Find and delete subscription
        $subscription = NewsletterSubscription::where('email', $validated['email'])->first();
        
        if ($subscription) {
            $subscription->delete();
            return back()->with('success', 'You have been successfully unsubscribed from our newsletter.');
        }

        return back()->with('info', 'This email is not subscribed to our newsletter.');
    }
    
    /**
     * Send newsletter with latest news
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendNewsletter()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }
        
        // Get all active subscribers
        $subscribers = NewsletterSubscription::all();
        
        if ($subscribers->isEmpty()) {
            return back()->with('info', 'No subscribers found to send the newsletter.');
        }
        
        // Get latest news
        $latestNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();
            
        if ($latestNews->isEmpty()) {
            return back()->with('info', 'No published news available to include in the newsletter.');
        }
        
        $sentCount = 0;
        $failedCount = 0;
        
        // Send to each subscriber
        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewsletterEmail($latestNews, $subscriber));
                $sentCount++;
                // Add a small delay to prevent hitting rate limits
                usleep(100000); // 100ms delay
            } catch (\Exception $e) {
                $failedCount++;
                Log::error('Failed to send newsletter', [
                    'email' => $subscriber->email,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return back()->with('success', "Newsletter sent to {$sentCount} subscribers. Failed: {$failedCount}");
    }
    
    /**
     * Automatically send newsletter when new news is published
     * This method is called from an observer or event listener
     * 
     * @param News $news
     * @return void
     */
    public function sendNewsUpdate(News $news)
    {
        // Only send for newly published news
        if (!$news->is_published) {
            return;
        }
        
        // Get all active subscribers
        $subscribers = NewsletterSubscription::all();
        
        if ($subscribers->isEmpty()) {
            Log::info('No subscribers found to send news update.');
            return;
        }
        
        // Prepare news array with just this news item
        $newsItems = collect([$news]);
        
        // Send to each subscriber
        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewsletterEmail($newsItems, $subscriber, 'New Article Published'));
                // Add a small delay to prevent hitting rate limits
                usleep(100000); // 100ms delay
            } catch (\Exception $e) {
                Log::error('Failed to send news update', [
                    'email' => $subscriber->email,
                    'news_id' => $news->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        Log::info('News update sent to subscribers', ['news_id' => $news->id]);
    }
} 