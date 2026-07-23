<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opportunities\CircularEconomy\Template;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing templates
        DB::table('templates')->truncate();
        
        // Create text templates
        $this->createTextTemplates();
        
        // Create card templates
        $this->createCardTemplates();
        
        // Create image templates
        $this->createImageTemplates();
        
        // Create button templates
        $this->createButtonTemplates();
    }
    
    /**
     * Create text templates
     */
    private function createTextTemplates()
    {
        // Standard Text
        Template::create([
            'name' => 'Standard Text',
            'identifier' => 'standard-text',
            'type' => 'text',
            'description' => 'Basic text component with standard formatting',
            'thumbnail' => 'images/templates/text-standard.jpg',
            'category' => 'basic',
            'default_content' => [
                'content' => '<p>Add your content here</p>'
            ],
            'is_active' => true
        ]);
        
        // Featured Text
        Template::create([
            'name' => 'Featured Text',
            'identifier' => 'featured-text',
            'type' => 'text',
            'description' => 'Highlighted text with a border and background',
            'thumbnail' => 'images/templates/text-featured.jpg',
            'category' => 'featured',
            'css_classes' => 'bg-light border rounded p-4',
            'default_content' => [
                'content' => '<p>This is featured text content that stands out from the rest of your page.</p>'
            ],
            'is_active' => true
        ]);
        
        // Quote Text
        Template::create([
            'name' => 'Quote/Testimonial',
            'identifier' => 'quote-text',
            'type' => 'text',
            'description' => 'Styled blockquote for testimonials or quotes',
            'thumbnail' => 'images/templates/text-quote.jpg',
            'category' => 'special',
            'css_classes' => 'blockquote border-start border-primary border-3 ps-4 fst-italic',
            'default_content' => [
                'content' => '<p>"This is a quote or testimonial that highlights important feedback or statements."</p><footer class="blockquote-footer">Someone famous</footer>'
            ],
            'is_active' => true
        ]);
    }
    
    /**
     * Create card templates
     */
    private function createCardTemplates()
    {
        // Standard Card
        Template::create([
            'name' => 'Standard Card',
            'identifier' => 'standard-card',
            'type' => 'card',
            'description' => 'Basic card with image on top',
            'thumbnail' => 'images/templates/card-standard.jpg',
            'category' => 'basic',
            'default_content' => [
                'title' => 'Card Title',
                'subtitle' => 'Card Subtitle',
                'content' => '<p>This is the card content. Add your text here.</p>',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'button_style' => 'primary'
            ],
            'is_active' => true
        ]);
        
        // Horizontal Card
        Template::create([
            'name' => 'Horizontal Card',
            'identifier' => 'horizontal-card',
            'type' => 'card',
            'description' => 'Card with image on the side',
            'thumbnail' => 'images/templates/card-horizontal.jpg',
            'category' => 'layout',
            'default_content' => [
                'title' => 'Horizontal Card',
                'subtitle' => 'Image on the side',
                'content' => '<p>This card uses a horizontal layout with the image on the side.</p>',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'button_style' => 'primary'
            ],
            'is_active' => true
        ]);
        
        // Overlay Card
        Template::create([
            'name' => 'Image Overlay Card',
            'identifier' => 'overlay-card',
            'type' => 'card',
            'description' => 'Card with text overlaid on the image',
            'thumbnail' => 'images/templates/card-overlay.jpg',
            'category' => 'special',
            'default_content' => [
                'title' => 'Overlay Card',
                'subtitle' => 'Text on image',
                'content' => '<p>This card displays text on top of the background image.</p>',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'button_style' => 'light'
            ],
            'is_active' => true
        ]);
        
        // Featured Card
        Template::create([
            'name' => 'Featured Card',
            'identifier' => 'featured-card',
            'type' => 'card',
            'description' => 'Highlighted card with shadow and hover effects',
            'thumbnail' => 'images/templates/card-featured.jpg',
            'category' => 'featured',
            'default_content' => [
                'title' => 'Featured Card',
                'subtitle' => 'Special design',
                'content' => '<p>This card has special styling to make it stand out.</p>',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'button_style' => 'primary'
            ],
            'is_active' => true
        ]);
    }
    
    /**
     * Create image templates
     */
    private function createImageTemplates()
    {
        // Standard Image
        Template::create([
            'name' => 'Standard Image',
            'identifier' => 'standard-image',
            'type' => 'image',
            'description' => 'Basic responsive image',
            'thumbnail' => 'images/templates/image-standard.jpg',
            'category' => 'basic',
            'default_content' => [
                'alt_text' => 'Image description',
                'caption' => '',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
        
        // Rounded Image
        Template::create([
            'name' => 'Rounded Image',
            'identifier' => 'rounded-image',
            'type' => 'image',
            'description' => 'Circular image, perfect for profiles',
            'thumbnail' => 'images/templates/image-rounded.jpg',
            'category' => 'special',
            'default_content' => [
                'alt_text' => 'Profile image',
                'caption' => '',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
        
        // Captioned Image
        Template::create([
            'name' => 'Captioned Image',
            'identifier' => 'captioned-image',
            'type' => 'image',
            'description' => 'Image with a caption underneath',
            'thumbnail' => 'images/templates/image-captioned.jpg',
            'category' => 'basic',
            'default_content' => [
                'alt_text' => 'Image description',
                'caption' => 'This is the image caption',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
        
        // Featured Image
        Template::create([
            'name' => 'Featured Image',
            'identifier' => 'featured-image',
            'type' => 'image',
            'description' => 'Image with shadow and border effects',
            'thumbnail' => 'images/templates/image-featured.jpg',
            'category' => 'featured',
            'default_content' => [
                'alt_text' => 'Featured image',
                'caption' => '',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
    }
    
    /**
     * Create button templates
     */
    private function createButtonTemplates()
    {
        // Primary Button
        Template::create([
            'name' => 'Primary Button',
            'identifier' => 'primary-button',
            'type' => 'button',
            'description' => 'Standard primary button',
            'thumbnail' => 'images/templates/button-primary.jpg',
            'category' => 'basic',
            'default_content' => [
                'button_text' => 'Click Me',
                'button_url' => '#',
                'button_style' => 'primary',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
        
        // Outline Button
        Template::create([
            'name' => 'Outline Button',
            'identifier' => 'outline-button',
            'type' => 'button',
            'description' => 'Button with outline style',
            'thumbnail' => 'images/templates/button-outline.jpg',
            'category' => 'basic',
            'default_content' => [
                'button_text' => 'Click Me',
                'button_url' => '#',
                'button_style' => 'primary',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
        
        // Link Button
        Template::create([
            'name' => 'Link Button',
            'identifier' => 'link-button',
            'type' => 'button',
            'description' => 'Button styled as a link',
            'thumbnail' => 'images/templates/button-link.jpg',
            'category' => 'basic',
            'default_content' => [
                'button_text' => 'Click Me',
                'button_url' => '#',
                'button_style' => 'primary',
                'alignment' => 'center',
                'icon' => 'arrow-right'
            ],
            'is_active' => true
        ]);
        
        // Rounded Button
        Template::create([
            'name' => 'Rounded Button',
            'identifier' => 'rounded-button',
            'type' => 'button',
            'description' => 'Button with fully rounded corners',
            'thumbnail' => 'images/templates/button-rounded.jpg',
            'category' => 'special',
            'default_content' => [
                'button_text' => 'Click Me',
                'button_url' => '#',
                'button_style' => 'primary',
                'alignment' => 'center'
            ],
            'is_active' => true
        ]);
        
        // Animated Button
        Template::create([
            'name' => 'Animated Button',
            'identifier' => 'animated-button',
            'type' => 'button',
            'description' => 'Button with hover animation',
            'thumbnail' => 'images/templates/button-animated.jpg',
            'category' => 'special',
            'default_content' => [
                'button_text' => 'Click Me',
                'button_url' => '#',
                'button_style' => 'primary',
                'alignment' => 'center',
                'icon' => 'arrow-right'
            ],
            'is_active' => true
        ]);
    }
} 