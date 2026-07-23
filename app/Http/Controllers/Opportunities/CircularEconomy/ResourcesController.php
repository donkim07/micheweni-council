<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourcesController extends Controller
{
    /**
     * Display the resources page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('opportunities.circular-economy.resources.index');
    }
} 