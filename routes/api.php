<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Google Maps API Key
Route::get('/google-maps-api-key', [ApiController::class, 'getGoogleMapsApiKey']);

// Test endpoint
Route::get('/test', [ApiController::class, 'test']);

// Get visitor locations for world map
Route::get('/visitor-locations', [ApiController::class, 'visitorLocations']); 