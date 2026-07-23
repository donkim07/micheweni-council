<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OpportunityController;
use App\Http\Controllers\Admin\Government\SiteConfigController;
use Illuminate\Support\Facades\Route;

// Add a route for the home page configuration guide
Route::get('/home-config-guide', [DashboardController::class, 'homeConfigGuide'])->name('home-config-guide');

// Opportunities management routes
Route::group(['prefix' => 'opportunities', 'as' => 'opportunities.'], function () {
    Route::get('/', [OpportunityController::class, 'index'])->name('index');
    Route::get('/create', [OpportunityController::class, 'create'])->name('create');
    Route::post('/', [OpportunityController::class, 'store'])->name('store');
    Route::get('/{id}', [OpportunityController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [OpportunityController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OpportunityController::class, 'update'])->name('update');
    Route::delete('/{id}', [OpportunityController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/toggle', [OpportunityController::class, 'toggle'])->name('toggle');
});

// Site Configuration Routes
Route::prefix('site-config')->name('site-config.')->group(function () {
    // General site configuration
    Route::get('/', [SiteConfigController::class, 'index'])->name('index');
    Route::get('/create', [SiteConfigController::class, 'create'])->name('create');
    Route::post('/', [SiteConfigController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SiteConfigController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SiteConfigController::class, 'update'])->name('update');
    Route::delete('/{id}', [SiteConfigController::class, 'destroy'])->name('destroy');
    
    // Contact information
    Route::get('/contact', [SiteConfigController::class, 'editContact'])->name('edit-contact');
    Route::post('/contact', [SiteConfigController::class, 'updateContact'])->name('update-contact');
    
    // Social media links
    Route::get('/social', [SiteConfigController::class, 'editSocial'])->name('edit-social');
    Route::post('/social', [SiteConfigController::class, 'updateSocial'])->name('update-social');
    
    // Leadership information
    Route::get('/leadership', [SiteConfigController::class, 'editLeadership'])->name('edit-leadership');
    Route::post('/leadership', [SiteConfigController::class, 'updateLeadership'])->name('update-leadership');
    
    // Statistics
    Route::get('/stats', [SiteConfigController::class, 'editStats'])->name('edit-stats');
    Route::post('/stats', [SiteConfigController::class, 'updateStats'])->name('update-stats');
}); 