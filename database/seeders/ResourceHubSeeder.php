<?php

namespace Database\Seeders;

use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Content;
use Illuminate\Database\Seeder;

class ResourceHubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the resource hub page
        $resourcePage = Page::updateOrCreate(
            ['slug' => 'resources'],
            [
                'title' => 'Resource Hub',
                'description' => 'Access educational materials, guides, and best practices for waste management and circular economy.',
                'template' => 'resources',
                'is_active' => true,
                'show_in_menu' => true,
                'menu_order' => 4,
                'show_in_navigation' => true,
                'navigation_order' => 5,
            ]
        );

        // Create intro section
        Content::updateOrCreate(
            [
                'page_id' => $resourcePage->id, 
                'identifier' => 'resource_intro'
            ],
            [
                'title' => 'Capacity Building & Learning Resources',
                'title_sw' => 'Ujenzi wa Uwezo & Rasilimali za Kujifunza',
                'content' => '<p>Enhance your knowledge and skills in waste management and circular economy principles through our comprehensive learning resources.</p>',
                'content_sw' => '<p>Boresha maarifa na ujuzi wako katika usimamizi wa taka na kanuni za uchumi wa mzunguko kupitia rasilimali zetu kamili za kujifunza.</p>',
                'type' => 'html',
                'section' => 'intro',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation' => 'fade-in',
                    'background_color' => '#f8fafc',
                ]),
            ]
        );

        // Create learning tracks section
        Content::updateOrCreate(
            [
                'page_id' => $resourcePage->id, 
                'identifier' => 'resource_learning_tracks'
            ],
            [
                'title' => 'Learning Tracks by Role',
                'title_sw' => 'Njia za Kujifunza kwa Wajibu',
                'content' => '<p>Choose your role to access tailored learning resources designed for your specific needs and responsibilities.</p>',
                'content_sw' => '<p>Chagua wajibu wako ili kupata rasilimali za kujifunza zilizoundwa mahsusi kwa mahitaji na majukumu yako maalum.</p>',
                'type' => 'html',
                'section' => 'learning_tracks',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'tracks' => [
                        [
                            'title' => 'Policy Maker',
                            'description' => 'Resources for developing effective waste management policies and regulations',
                            'icon' => 'fas fa-gavel',
                            'color' => '#b91c1c',
                            'modules' => [
                                'Policy Development Framework',
                                'Extended Producer Responsibility',
                                'Regulatory Best Practices',
                                'Incentive Mechanisms'
                            ]
                        ],
                        [
                            'title' => 'Data Collector',
                            'description' => 'Tools and methodologies for effective waste data collection',
                            'icon' => 'fas fa-clipboard-list',
                            'color' => '#2563eb',
                            'modules' => [
                                'Data Collection Methodologies',
                                'Survey Design',
                                'Field Assessment Techniques',
                                'Data Validation'
                            ]
                        ],
                        [
                            'title' => 'Analyst',
                            'description' => 'Advanced tools for analyzing waste management data',
                            'icon' => 'fas fa-chart-line',
                            'color' => '#7c3aed',
                            'modules' => [
                                'Data Analysis Techniques',
                                'Trend Identification',
                                'Visualization Methods',
                                'Predictive Modeling'
                            ]
                        ],
                        [
                            'title' => 'Public Communicator',
                            'description' => 'Strategies for effective public communication and engagement',
                            'icon' => 'fas fa-bullhorn',
                            'color' => '#059669',
                            'modules' => [
                                'Community Engagement',
                                'Awareness Campaign Design',
                                'Educational Material Development',
                                'Social Media Strategy'
                            ]
                        ],
                    ]
                ]),
            ]
        );

        // Create videos section
        Content::updateOrCreate(
            [
                'page_id' => $resourcePage->id, 
                'identifier' => 'resource_videos'
            ],
            [
                'title' => 'Educational Videos',
                'title_sw' => 'Video za Kielimu',
                'content' => '<p>Watch instructional videos on various aspects of waste management and circular economy principles.</p>',
                'content_sw' => '<p>Tazama video za mafunzo kuhusu vipengele mbalimbali vya usimamizi wa taka na kanuni za uchumi wa mzunguko.</p>',
                'type' => 'html',
                'section' => 'videos',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'videos' => [
                        [
                            'title' => 'Introduction to Circular Economy',
                            'description' => 'Learn the basic principles and benefits of circular economy',
                            'thumbnail' => 'images/videos/circular_economy_intro.jpg',
                            'duration' => '15:24',
                            'video_url' => 'https://example.com/videos/circular_economy_intro',
                            'animation' => 'fade-in'
                        ],
                        [
                            'title' => 'Waste Audit Methodology',
                            'description' => 'Step-by-step guide to conducting a comprehensive waste audit',
                            'thumbnail' => 'images/videos/waste_audit.jpg',
                            'duration' => '23:10',
                            'video_url' => 'https://example.com/videos/waste_audit',
                            'animation' => 'slide-in-right'
                        ],
                        [
                            'title' => 'Implementing Recycling Programs',
                            'description' => 'Best practices for setting up effective recycling systems',
                            'thumbnail' => 'images/videos/recycling_programs.jpg',
                            'duration' => '18:45',
                            'video_url' => 'https://example.com/videos/recycling_programs',
                            'animation' => 'slide-in-left'
                        ],
                    ]
                ]),
            ]
        );
    }
} 