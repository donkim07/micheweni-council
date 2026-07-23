<?php

namespace Database\Seeders;

use App\Models\Opportunities\CircularEconomy\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Card Templates
        $this->createCardTemplates();
        
        // Grid Templates
        $this->createGridTemplates();
        
        // Form Templates
        $this->createFormTemplates();
        
        // CTA Templates
        $this->createCtaTemplates();
        
        // Hero Templates
        $this->createHeroTemplates();
    }
    
    /**
     * Create card templates
     */
    private function createCardTemplates(): void
    {
        // Standard Card
        Template::create([
            'name' => 'Standard Card',
            'identifier' => 'card-standard',
            'category' => 'card',
            'type' => 'card',
            'description' => 'Standard card with image, title, description and button',
            'animation' => 'fade-in-up',
            'hover_effect' => 'card-hover-effect',
            'settings' => [
                'image_position' => 'top',
                'text_alignment' => 'left',
                'card_padding' => '1.5rem',
                'border_radius' => '0.5rem',
                'shadow' => 'shadow-sm',
            ],
            'default_content' => [
                'title' => 'Card Title',
                'subtitle' => 'Card Subtitle',
                'content' => 'This is the card description text.',
                'button_text' => 'Learn More',
                'button_url' => '#',
                'image' => null,
            ],
        ]);
        
        // Feature Card
        Template::create([
            'name' => 'Feature Card',
            'identifier' => 'card-feature',
            'category' => 'card',
            'type' => 'card',
            'description' => 'Feature card with icon, title and description',
            'animation' => 'fade-in-up',
            'hover_effect' => 'card-hover-effect',
            'settings' => [
                'icon_position' => 'top',
                'text_alignment' => 'center',
                'card_padding' => '2rem',
                'border_radius' => '0.75rem',
                'shadow' => 'shadow',
            ],
            'default_content' => [
                'title' => 'Feature Title',
                'subtitle' => '',
                'content' => 'Key feature description text.',
                'icon' => 'fas fa-star',
                'button_text' => '',
                'button_url' => '#',
            ],
        ]);
        
        // News Card
        Template::create([
            'name' => 'News Card',
            'identifier' => 'card-news',
            'category' => 'card',
            'type' => 'card',
            'description' => 'Card designed for news articles with category badge',
            'animation' => 'fade-in-up',
            'hover_effect' => 'card-hover-effect',
            'settings' => [
                'image_position' => 'top',
                'text_alignment' => 'left',
                'card_padding' => '1.25rem',
                'border_radius' => '0.5rem',
                'shadow' => 'shadow-sm',
                'badge_style' => 'success',
            ],
            'default_content' => [
                'title' => 'News Title',
                'subtitle' => '',
                'content' => 'News article excerpt or summary.',
                'category' => 'News',
                'date' => now()->format('M d, Y'),
                'button_text' => 'Read More',
                'button_url' => '#',
            ],
        ]);
        
        // Testimonial Card
        Template::create([
            'name' => 'Testimonial Card',
            'identifier' => 'card-testimonial',
            'category' => 'card',
            'type' => 'card',
            'description' => 'Card designed for testimonials with quote styling',
            'animation' => 'fade-in-up',
            'hover_effect' => 'card-hover-effect',
            'settings' => [
                'image_position' => 'bottom',
                'text_alignment' => 'center',
                'card_padding' => '2rem',
                'border_radius' => '0.5rem',
                'shadow' => 'shadow',
                'quote_style' => 'primary',
            ],
            'default_content' => [
                'quote' => 'This is a great testimonial quote from a satisfied customer.',
                'author_name' => 'John Doe',
                'author_title' => 'CEO, Company Inc',
                'author_image' => null,
                'company_logo' => null,
            ],
        ]);
    }
    
    /**
     * Create grid templates
     */
    private function createGridTemplates(): void
    {
        // Masonry Grid
        Template::create([
            'name' => 'Masonry Grid',
            'identifier' => 'grid-masonry',
            'category' => 'grid',
            'type' => 'grid',
            'description' => 'Variable height grid layout with masonry effect',
            'animation' => 'staggered-fade-in',
            'hover_effect' => '',
            'settings' => [
                'columns_desktop' => 3,
                'columns_tablet' => 2,
                'columns_mobile' => 1,
                'gap' => '1.5rem',
                'filter_enabled' => true,
            ],
            'default_content' => [
                'items' => [],
                'categories' => [],
            ],
        ]);
        
        // Feature Grid
        Template::create([
            'name' => 'Feature Grid',
            'identifier' => 'grid-feature',
            'category' => 'grid',
            'type' => 'grid',
            'description' => 'Equal height grid for features with icons',
            'animation' => 'staggered-fade-in',
            'hover_effect' => '',
            'settings' => [
                'columns_desktop' => 3,
                'columns_tablet' => 2,
                'columns_mobile' => 1,
                'gap' => '1.5rem',
                'equal_height' => true,
            ],
            'default_content' => [
                'items' => [],
                'title' => 'Our Features',
                'subtitle' => 'Explore what we offer',
            ],
        ]);
        
        // News Grid
        Template::create([
            'name' => 'News Grid',
            'identifier' => 'grid-news',
            'category' => 'grid',
            'type' => 'grid',
            'description' => 'News article grid with featured first item',
            'animation' => 'staggered-fade-in',
            'hover_effect' => '',
            'settings' => [
                'columns_desktop' => 3,
                'columns_tablet' => 2,
                'columns_mobile' => 1,
                'gap' => '1.5rem',
                'featured_first' => true,
            ],
            'default_content' => [
                'items' => [],
                'title' => 'Latest News',
                'subtitle' => 'Stay updated with our recent articles',
            ],
        ]);
    }
    
    /**
     * Create form templates
     */
    private function createFormTemplates(): void
    {
        // Contact Form
        Template::create([
            'name' => 'Contact Form',
            'identifier' => 'form-contact',
            'category' => 'form',
            'type' => 'form',
            'description' => 'Standard contact form with name, email, subject and message',
            'animation' => 'fade-in-up',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'standard',
                'button_style' => 'success',
                'show_labels' => true,
                'field_animation' => true,
            ],
            'default_content' => [
                'title' => 'Contact Us',
                'subtitle' => 'We\'d love to hear from you',
                'submit_text' => 'Send Message',
                'success_message' => 'Your message has been sent successfully!',
                'fields' => [
                    [
                        'type' => 'text',
                        'name' => 'name',
                        'label' => 'Your Name',
                        'placeholder' => 'Enter your name',
                        'required' => true,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'email',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email address',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'subject',
                        'label' => 'Subject',
                        'placeholder' => 'Enter message subject',
                        'required' => true,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'message',
                        'label' => 'Your Message',
                        'placeholder' => 'Type your message here',
                        'required' => true,
                        'rows' => 5,
                    ],
                ],
            ],
        ]);
        
        // Booking Form
        Template::create([
            'name' => 'Booking Form',
            'identifier' => 'form-booking',
            'category' => 'form',
            'type' => 'form',
            'description' => 'Multi-step booking form with date selection',
            'animation' => 'fade-in-up',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'multi-step',
                'button_style' => 'primary',
                'show_labels' => true,
                'show_progress' => true,
                'steps' => 3,
            ],
            'default_content' => [
                'title' => 'Book an Appointment',
                'subtitle' => 'Select your preferred date and time',
                'submit_text' => 'Complete Booking',
                'success_message' => 'Your booking has been confirmed!',
                'steps' => [
                    [
                        'title' => 'Select Service',
                        'fields' => [
                            [
                                'type' => 'select',
                                'name' => 'service',
                                'label' => 'Service',
                                'options' => ['Option 1', 'Option 2', 'Option 3'],
                                'required' => true,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Choose Date & Time',
                        'fields' => [
                            [
                                'type' => 'date',
                                'name' => 'date',
                                'label' => 'Date',
                                'required' => true,
                            ],
                            [
                                'type' => 'time',
                                'name' => 'time',
                                'label' => 'Time',
                                'required' => true,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Your Information',
                        'fields' => [
                            [
                                'type' => 'text',
                                'name' => 'name',
                                'label' => 'Your Name',
                                'required' => true,
                            ],
                            [
                                'type' => 'email',
                                'name' => 'email',
                                'label' => 'Email Address',
                                'required' => true,
                            ],
                            [
                                'type' => 'tel',
                                'name' => 'phone',
                                'label' => 'Phone Number',
                                'required' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        
        // Feedback Form
        Template::create([
            'name' => 'Feedback Form',
            'identifier' => 'form-feedback',
            'category' => 'form',
            'type' => 'form',
            'description' => 'Feedback form with ratings and comment',
            'animation' => 'fade-in-up',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'compact',
                'button_style' => 'success',
                'show_labels' => true,
                'rating_type' => 'stars',
            ],
            'default_content' => [
                'title' => 'Share Your Feedback',
                'subtitle' => 'We value your opinion',
                'submit_text' => 'Submit Feedback',
                'success_message' => 'Thank you for your feedback!',
                'fields' => [
                    [
                        'type' => 'rating',
                        'name' => 'rating',
                        'label' => 'Your Rating',
                        'max' => 5,
                        'required' => true,
                    ],
                    [
                        'type' => 'textarea',
                        'name' => 'comments',
                        'label' => 'Comments',
                        'placeholder' => 'Tell us your thoughts',
                        'required' => true,
                        'rows' => 3,
                    ],
                    [
                        'type' => 'text',
                        'name' => 'name',
                        'label' => 'Your Name',
                        'placeholder' => 'Enter your name (optional)',
                        'required' => false,
                    ],
                    [
                        'type' => 'email',
                        'name' => 'email',
                        'label' => 'Email Address',
                        'placeholder' => 'Enter your email (optional)',
                        'required' => false,
                    ],
                ],
            ],
        ]);
    }
    
    /**
     * Create CTA templates
     */
    private function createCtaTemplates(): void
    {
        // Split CTA
        Template::create([
            'name' => 'Split CTA',
            'identifier' => 'cta-split',
            'category' => 'cta',
            'type' => 'cta',
            'description' => 'Split layout CTA with image and text/button',
            'animation' => 'fade-in',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'split',
                'image_position' => 'left',
                'button_style' => 'success',
                'background_color' => '#ffffff',
                'text_color' => '#212529',
                'overlay_opacity' => 0,
            ],
            'default_content' => [
                'title' => 'Ready to Get Started?',
                'subtitle' => 'Join thousands of satisfied customers today',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'button_text' => 'Get Started',
                'button_url' => '#',
                'image' => null,
            ],
        ]);
        
        // Banner CTA
        Template::create([
            'name' => 'Banner CTA',
            'identifier' => 'cta-banner',
            'category' => 'cta',
            'type' => 'cta',
            'description' => 'Full width banner with accent background',
            'animation' => 'fade-in',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'banner',
                'button_style' => 'light',
                'background_color' => '#198754',
                'text_color' => '#ffffff',
                'text_alignment' => 'center',
                'padding' => '3rem',
            ],
            'default_content' => [
                'title' => 'Special Offer',
                'content' => 'Take advantage of our limited time offer and save today!',
                'button_text' => 'Learn More',
                'button_url' => '#',
            ],
        ]);
    }
    
    /**
     * Create hero templates
     */
    private function createHeroTemplates(): void
    {
        // Split Hero
        Template::create([
            'name' => 'Split Hero',
            'identifier' => 'hero-split',
            'category' => 'hero',
            'type' => 'hero',
            'description' => 'Split layout hero with image and content',
            'animation' => 'fade-in',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'split',
                'image_position' => 'right',
                'button_style' => 'success',
                'height' => 'medium',
                'overlay_opacity' => 0,
                'background_color' => '#ffffff',
                'text_color' => '#212529',
            ],
            'default_content' => [
                'title' => 'Welcome to Our Platform',
                'subtitle' => 'The best solution for your needs',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'button_text' => 'Get Started',
                'button_url' => '#',
                'secondary_button_text' => 'Learn More',
                'secondary_button_url' => '#',
                'image' => null,
            ],
        ]);
        
        // Full Width Hero
        Template::create([
            'name' => 'Full Width Hero',
            'identifier' => 'hero-full',
            'category' => 'hero',
            'type' => 'hero',
            'description' => 'Full width hero with background image',
            'animation' => 'fade-in',
            'hover_effect' => '',
            'settings' => [
                'layout' => 'full',
                'text_alignment' => 'center',
                'button_style' => 'outline-light',
                'height' => 'large',
                'overlay_opacity' => 0.5,
                'overlay_color' => '#000000',
                'text_color' => '#ffffff',
            ],
            'default_content' => [
                'title' => 'Powerful Solutions for Your Business',
                'subtitle' => 'Trusted by thousands worldwide',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis.',
                'button_text' => 'Explore Now',
                'button_url' => '#',
                'secondary_button_text' => 'Contact Us',
                'secondary_button_url' => '#',
                'background_image' => null,
            ],
        ]);
    }
} 