<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Display a listing of newsletter subscriptions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $subscriptions = NewsletterSubscription::orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.newsletter-subscriptions.index', compact('subscriptions'));
    }

    /**
     * Remove the specified subscription from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = NewsletterSubscription::findOrFail($id);
        $subscription->delete();
        
        return redirect()->route('admin.newsletter-subscriptions.index')
            ->with('success', 'Subscription deleted successfully');
    }
    
    /**
     * Export subscriptions as CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $subscriptions = NewsletterSubscription::where('status', 'subscribed')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter_subscribers.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($subscriptions) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Email', 'Name', 'Status', 'Subscribed Date']);
            
            // Add rows
            foreach ($subscriptions as $subscription) {
                fputcsv($file, [
                    $subscription->email,
                    $subscription->name,
                    $subscription->status,
                    $subscription->subscribed_at ? $subscription->subscribed_at->format('Y-m-d H:i:s') : $subscription->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
} 