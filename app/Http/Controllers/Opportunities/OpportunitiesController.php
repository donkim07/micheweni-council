<?php

namespace App\Http\Controllers\Opportunities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OpportunitiesController extends Controller
{
    /**
     * Display the opportunities main page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('opportunities.index');
    }
} 