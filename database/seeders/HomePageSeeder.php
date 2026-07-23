<?php

namespace Database\Seeders;

use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the home page
        $homePage = Page::updateOrCreate(
            ['template' => 'home'],
            [
                'title' => 'Home',
                'slug' => 'home',
                'description' => 'Welcome to the Waste Management Portal - enabling communities to assess, monitor, and improve their circular economy and waste practices.',
                'is_active' => true,
                'show_in_menu' => true,
                'menu_order' => 1,
                'show_in_navigation' => true,
                'navigation_order' => 1,
            ]
        );

        // Create hero section content
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'section' => 'hero', 'order' => 1],
            [
                'title' => 'Building a Circular Economy Future',
                'title_sw' => 'Kujenga Uchumi wa Mzunguko wa Baadaye',
                'identifier' => 'home_hero',
                'content' => '<p>Join us in transforming waste management practices and building a sustainable circular economy. Monitor your progress, share insights, and contribute to a cleaner future.</p>',
                'content_sw' => '<p>Jiunge nasi katika kubadilisha mbinu za usimamizi wa taka na kujenga uchumi wa mzunguko endelevu. Fuatilia maendeleo yako, shiriki maarifa, na changia katika siku zijazo safi.</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation' => 'fade-in-left',
                    'button_text' => 'Start Assessment',
                    'button_link' => '/assessment',
                    'secondary_button_text' => 'View Map',
                    'secondary_button_link' => '/waste-locations',
                    'background_color' => '#15803d',
                    'text_color' => '#ffffff',
                ]),
            ]
        );

        // Create animated infographic section for circular economy
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'section' => 'circular_economy', 'order' => 1],
            [
                'title' => 'The Circular Economy Cycle',
                'title_sw' => 'Mzunguko wa Uchumi Duara',
                'identifier' => 'circular_economy_animation',
                'content' => '<p>Follow the journey of materials through a sustainable circular economy:</p>',
                'content_sw' => '<p>Fuata safari ya vifaa kupitia uchumi wa mzunguko endelevu:</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation_steps' => [
                        [
                            'title' => 'Raw Materials',
                            'description' => 'Responsible extraction of materials',
                            'icon' => 'fas fa-leaf',
                            'color' => '#4CAF50'
                        ],
                        [
                            'title' => 'Production',
                            'description' => 'Sustainable manufacturing processes',
                            'icon' => 'fas fa-industry',
                            'color' => '#2196F3'
                        ],
                        [
                            'title' => 'Consumption',
                            'description' => 'Mindful usage of products',
                            'icon' => 'fas fa-shopping-cart',
                            'color' => '#9C27B0'
                        ],
                        [
                            'title' => 'Collection',
                            'description' => 'Efficient waste collection systems',
                            'icon' => 'fas fa-trash-alt',
                            'color' => '#FF9800'
                        ],
                        [
                            'title' => 'Recycling',
                            'description' => 'Processing materials for reuse',
                            'icon' => 'fas fa-recycle',
                            'color' => '#00BCD4'
                        ],
                        [
                            'title' => 'Regeneration',
                            'description' => 'Return to useful raw materials',
                            'icon' => 'fas fa-sync-alt',
                            'color' => '#8BC34A'
                        ],
                    ]
                ]),
            ]
        );

        // Create achievements section
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'section' => 'achievements', 'order' => 1],
            [
                'title' => 'Latest Achievements',
                'title_sw' => 'Mafanikio ya Hivi Karibuni',
                'identifier' => 'home_achievements',
                'content' => '<p>Celebrating progress in our circular economy journey:</p>',
                'content_sw' => '<p>Kusherehekea maendeleo katika safari yetu ya uchumi wa mzunguko:</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'achievements' => [
                        [
                            'title' => 'Kenya reaches 72% Circularity!',
                            'description' => 'Through innovative policies and community engagement',
                            'icon' => '🏆',
                            'color' => '#FFC107',
                            'date' => '2023-11-15'
                        ],
                        [
                            'title' => 'Tanzania improves collection rate by 45%',
                            'description' => 'New collection systems implemented nationwide',
                            'icon' => '📈',
                            'color' => '#4CAF50',
                            'date' => '2023-10-22'
                        ],
                        [
                            'title' => 'Rwanda reduces landfill waste by 38%',
                            'description' => 'Through comprehensive recycling initiatives',
                            'icon' => '♻️',
                            'color' => '#2196F3',
                            'date' => '2023-09-10'
                        ],
                    ]
                ]),
            ]
        );

        // Create global snapshot section
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'section' => 'global_snapshot', 'order' => 1],
            [
                'title' => 'Global Progress Snapshot',
                'title_sw' => 'Picha ya Maendeleo ya Kimataifa',
                'identifier' => 'home_global_snapshot',
                'content' => '<p>Explore waste management progress across different countries:</p>',
                'content_sw' => '<p>Chunguza maendeleo ya usimamizi wa taka katika nchi mbalimbali:</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'map_data' => [
                        [
                            'country' => 'Kenya',
                            'progress' => 72,
                            'color' => '#4CAF50',
                            'details_url' => '/countries/kenya'
                        ],
                        [
                            'country' => 'Tanzania',
                            'progress' => 65,
                            'color' => '#8BC34A',
                            'details_url' => '/countries/tanzania'
                        ],
                        [
                            'country' => 'Rwanda',
                            'progress' => 78,
                            'color' => '#4CAF50',
                            'details_url' => '/countries/rwanda'
                        ],
                        [
                            'country' => 'Uganda',
                            'progress' => 52,
                            'color' => '#FFC107',
                            'details_url' => '/countries/uganda'
                        ],
                        [
                            'country' => 'Ethiopia',
                            'progress' => 45,
                            'color' => '#FF9800',
                            'details_url' => '/countries/ethiopia'
                        ],
                    ]
                ]),
            ]
        );

        // Create leaderboard section
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'section' => 'leaderboard', 'order' => 1],
            [
                'title' => 'Circularity Leaderboard',
                'title_sw' => 'Ubao wa Viongozi wa Mzunguko',
                'identifier' => 'home_leaderboard',
                'content' => '<p>Countries making the most progress in circular economy implementation:</p>',
                'content_sw' => '<p>Nchi zinazofanya maendeleo zaidi katika utekelezaji wa uchumi wa mzunguko:</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'leaders' => [
                        [
                            'position' => 1,
                            'country' => 'Rwanda',
                            'score' => 78,
                            'change' => '+5',
                            'badge' => 'gold'
                        ],
                        [
                            'position' => 2,
                            'country' => 'Kenya',
                            'score' => 72,
                            'change' => '+8',
                            'badge' => 'silver'
                        ],
                        [
                            'position' => 3,
                            'country' => 'Tanzania',
                            'score' => 65,
                            'change' => '+12',
                            'badge' => 'bronze'
                        ],
                        [
                            'position' => 4,
                            'country' => 'Uganda',
                            'score' => 52,
                            'change' => '+3',
                            'badge' => null
                        ],
                        [
                            'position' => 5,
                            'country' => 'Ethiopia',
                            'score' => 45,
                            'change' => '+7',
                            'badge' => null
                        ],
                    ]
                ]),
            ]
        );

        // Create services section heading
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'identifier' => 'home_services_heading'],
            [
                'title' => 'Our Services',
                'title_sw' => 'Huduma Zetu',
                'content' => '<p>Comprehensive tools and resources to improve waste management and circular economy practices</p>',
                'content_sw' => '<p>Zana na rasilimali kamili za kuboresha usimamizi wa taka na mbinu za uchumi wa mzunguko</p>',
                'type' => 'html',
                'section' => 'services',
                'order' => 1,
                'is_active' => true,
            ]
        );

        // Create featured services
        $services = [
            [
                'title' => 'Self-Assessment',
                'title_sw' => 'Tathmini-Binafsi',
                'identifier' => 'home_service_assessment',
                'content' => '<p>Evaluate your current waste management practices and identify areas for improvement with our interactive assessment tool.</p>',
                'content_sw' => '<p>Tathmini mbinu zako za sasa za usimamizi wa taka na tambua maeneo ya kuboresha na zana yetu ya tathmini.</p>',
                'type' => 'html',
                'section' => 'featured',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-clipboard-check',
                    'link' => '/assessment',
                    'button_text' => 'Start Assessment',
                    'image' => 'images/assessment.jpg'
                ]),
            ],
            [
                'title' => 'Data Dashboard',
                'title_sw' => 'Dashibodi ya Data',
                'identifier' => 'home_service_dashboard',
                'content' => '<p>Visualize waste management data with interactive charts and maps to track progress and identify trends.</p>',
                'content_sw' => '<p>Ona data ya usimamizi wa taka kwa chati na ramani za kuvutia ili kufuatilia maendeleo na kutambua mitindo.</p>',
                'type' => 'html',
                'section' => 'featured',
                'order' => 2,
                'is_active' => true,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-chart-bar',
                    'link' => '/data/dashboard',
                    'button_text' => 'View Dashboard',
                    'image' => 'images/dashboard.jpg'
                ]),
            ],
            [
                'title' => 'Learning Resources',
                'title_sw' => 'Rasilimali za Kujifunza',
                'identifier' => 'home_service_resources',
                'content' => '<p>Access educational materials, guides, and best practices to enhance your knowledge of circular economy principles.</p>',
                'content_sw' => '<p>Fikia nyenzo za elimu, miongozo, na mbinu bora ili kuongeza maarifa yako ya kanuni za uchumi wa mzunguko.</p>',
                'type' => 'html',
                'section' => 'featured',
                'order' => 3,
                'is_active' => true,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-graduation-cap',
                    'link' => '/resources',
                    'button_text' => 'Explore Resources',
                    'image' => 'images/resources.jpg'
                ]),
            ],
        ];

        foreach ($services as $serviceData) {
            Content::updateOrCreate(
                ['page_id' => $homePage->id, 'section' => $serviceData['section'], 'order' => $serviceData['order'], 'identifier' => $serviceData['identifier']],
                $serviceData
            );
        }

        // Create call to action section
        Content::updateOrCreate(
            ['page_id' => $homePage->id, 'identifier' => 'home_cta'],
            [
                'title' => 'Ready to Transform Your Waste Management?',
                'title_sw' => 'Tayari Kubadilisha Usimamizi Wako wa Taka?',
                'content' => '<p>Join our growing community of sustainability champions and start your journey towards a circular economy today.</p>',
                'content_sw' => '<p>Jiunge na jamii yetu inayokua ya mabingwa wa uendelevu na anza safari yako kuelekea uchumi wa mzunguko leo.</p>',
                'type' => 'html',
                'section' => 'cta',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'background_color' => '#15803d',
                    'text_color' => '#ffffff',
                    'primary_button' => 'Take Assessment',
                    'primary_button_link' => '/assessment',
                    'secondary_button' => 'Contact Us',
                    'secondary_button_link' => '/contact'
                ]),
            ]
        );
    }
} 