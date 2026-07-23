<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    /**
     * Display the services page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('opportunities.services');
    }
} 