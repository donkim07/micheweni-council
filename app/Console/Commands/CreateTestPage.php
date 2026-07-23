<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Models\Section;
use App\Models\Content;

class CreateTestPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:create-page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test page with sections and content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test page...');
        
        // Create a test page
        $page = Page::create([
            'title' => 'Test Page',
            'slug' => 'test-page-' . uniqid(),
            'description' => 'This is a test page for layout builder testing',
            'template' => 'default',
            'is_active' => true,
            'show_in_menu' => true,
            'menu_order' => 1,
        ]);
        
        $this->info('Page created with ID: ' . $page->id);
        
        // Create a header section
        $headerSection = Section::create([
            'page_id' => $page->id,
            'title' => 'Header Section',
            'identifier' => 'header-section-' . uniqid(),
            'type' => 'content',
            'order' => 0,
            'is_active' => true,
        ]);
        
        $this->info('Header section created with ID: ' . $headerSection->id);
        
        // Create a header content
        Content::create([
            'section_id' => $headerSection->id,
            'title' => 'Header',
            'identifier' => 'header-' . uniqid(),
            'type' => 'text',
            'value' => '<h1>Welcome to the Test Page</h1><p>This is a test page for the layout builder.</p>',
            'template' => 'standard',
            'column_width' => 'col-12',
            'order' => 0,
            'is_active' => true,
            'meta' => json_encode([
                'text_alignment' => 'center',
                'heading_type' => 'h1',
                'heading_text' => 'Welcome to the Test Page',
            ]),
        ]);
        
        // Create a main content section
        $mainSection = Section::create([
            'page_id' => $page->id,
            'title' => 'Main Content Section',
            'identifier' => 'main-section-' . uniqid(),
            'type' => 'content',
            'order' => 1,
            'is_active' => true,
        ]);
        
        $this->info('Main section created with ID: ' . $mainSection->id);
        
        // Create some test content components
        
        // Text component
        Content::create([
            'section_id' => $mainSection->id,
            'title' => 'Text Component',
            'identifier' => 'text-' . uniqid(),
            'type' => 'text',
            'value' => '<p>This is a sample text component.</p>',
            'template' => 'standard',
            'column_width' => 'col-md-6',
            'order' => 0,
            'is_active' => true,
            'meta' => json_encode([
                'text_alignment' => 'left',
                'heading_type' => 'none',
            ]),
        ]);
        
        // Card component
        Content::create([
            'section_id' => $mainSection->id,
            'title' => 'Card Component',
            'identifier' => 'card-' . uniqid(),
            'type' => 'card',
            'value' => '<p>This is a sample card component.</p>',
            'template' => 'standard',
            'column_width' => 'col-md-6',
            'order' => 1,
            'is_active' => true,
            'meta' => json_encode([
                'title' => 'Sample Card',
                'subtitle' => 'Card Subtitle',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'button_style' => 'primary',
            ]),
        ]);
        
        // Create a footer section
        $footerSection = Section::create([
            'page_id' => $page->id,
            'title' => 'Footer Section',
            'identifier' => 'footer-section-' . uniqid(),
            'type' => 'content',
            'order' => 2,
            'is_active' => true,
        ]);
        
        $this->info('Footer section created with ID: ' . $footerSection->id);
        
        // Create footer content
        Content::create([
            'section_id' => $footerSection->id,
            'title' => 'Footer',
            'identifier' => 'footer-' . uniqid(),
            'type' => 'text',
            'value' => '<p class="text-center">&copy; 2025 Test Page. All rights reserved.</p>',
            'template' => 'standard',
            'column_width' => 'col-12',
            'order' => 0,
            'is_active' => true,
            'meta' => json_encode([
                'text_alignment' => 'center',
                'heading_type' => 'none',
            ]),
        ]);
        
        $this->info('Test page created successfully with 3 sections and content!');
        
        return Command::SUCCESS;
    }
}