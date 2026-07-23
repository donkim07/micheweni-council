<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Get the authenticated user
        $user = Auth::user();
        
        // Check if user has the required permission
        if ($user->hasPermission($permission)) {
            return $next($request);
        }
        
        // If we get here, the user doesn't have the required permission
        return redirect()->route('home')
            ->with('error', __('You do not have permission to access this page.'));
    }
} 