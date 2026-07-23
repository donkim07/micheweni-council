<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('opportunities.about');
    }
} 