<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Check if the language is supported
        if (!in_array($locale, Config::get('app.supported_locales', ['en']))) {
            $locale = Config::get('app.fallback_locale', 'en');
        }
        
        // Store the locale in session
        Session::put('locale', $locale);
        
        // Get the previous URL or default to home
        $redirect = url()->previous() ?: route('home');
        
        return redirect($redirect)->with('success', __('Language switched successfully.'));
    }
}
