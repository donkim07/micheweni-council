<?php

namespace Database\Seeders;

use App\Models\Opportunities\CircularEconomy\Page;
use Illuminate\Database\Seeder;

class PageNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all pages
        $pages = Page::all();
        
        // Update navigation fields
        foreach ($pages as $index => $page) {
            // Set navigation fields based on menu fields for existing data
            $page->show_in_navigation = $page->show_in_menu ?? false;
            $page->navigation_order = $page->menu_order ?? $index;
            $page->save();
        }
        
        // Enable navigation for important pages
        $importantPages = [
            'about',
            'services',
            'resources',
            'contact',
        ];
        
        foreach ($importantPages as $index => $slug) {
            $page = Page::where('slug', $slug)->first();
            if ($page) {
                $page->show_in_navigation = true;
                $page->navigation_order = $index + 1;
                $page->save();
            }
        }
    }
} 