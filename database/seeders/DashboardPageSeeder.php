<?php

namespace Database\Seeders;

use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Content;
use Illuminate\Database\Seeder;

class DashboardPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the dashboard page
        $dashboardPage = Page::updateOrCreate(
            ['slug' => 'dashboard'],
            [
                'title' => 'Interactive Data Dashboard',
                'description' => 'Explore waste management data with interactive visualizations and country comparisons.',
                'template' => 'dashboard',
                'is_active' => true,
                'show_in_menu' => true,
                'menu_order' => 3,
                'show_in_navigation' => true,
                'navigation_order' => 4,
            ]
        );

        // Create dashboard sections
        $this->createDashboardSections($dashboardPage);
    }

    /**
     * Create content blocks for dashboard sections
     */
    private function createDashboardSections($page): void
    {
        $sections = [
            [
                'title' => 'Waste Management Data Explorer',
                'title_sw' => 'Kichunguzi cha Data ya Usimamizi wa Taka',
                'identifier' => 'dashboard_intro',
                'content' => '<p>Explore and visualize waste management data from across the region. Compare countries, track progress over time, and gain insights into circular economy implementation.</p>',
                'content_sw' => '<p>Chunguza na ona data ya usimamizi wa taka kutoka kote katika mkoa. Linganisha nchi, fuatilia maendeleo kwa muda, na pata maarifa kuhusu utekelezaji wa uchumi wa mzunguko.</p>',
                'type' => 'html',
                'section' => 'intro',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation' => 'fade-in',
                    'background_color' => '#f8fafc',
                ]),
            ],
            [
                'title' => 'Country Profiles',
                'title_sw' => 'Profaili za Nchi',
                'identifier' => 'dashboard_country_profiles',
                'content' => '<p>Select a country to view detailed waste management statistics and performance metrics.</p>',
                'content_sw' => '<p>Chagua nchi kuona takwimu za kina za usimamizi wa taka na vipimo vya utendaji.</p>',
                'type' => 'html',
                'section' => 'country_profiles',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'countries' => [
                        [
                            'name' => 'Kenya',
                            'flag' => '🇰🇪',
                            'key_stats' => [
                                'waste_per_capita' => '0.4 kg/day',
                                'circularity_rate' => '72%',
                                'recycling_rate' => '45%',
                                'landfill_diversion' => '38%',
                            ]
                        ],
                        [
                            'name' => 'Tanzania',
                            'flag' => '🇹🇿',
                            'key_stats' => [
                                'waste_per_capita' => '0.35 kg/day',
                                'circularity_rate' => '65%',
                                'recycling_rate' => '38%',
                                'landfill_diversion' => '31%',
                            ]
                        ],
                        [
                            'name' => 'Rwanda',
                            'flag' => '🇷🇼',
                            'key_stats' => [
                                'waste_per_capita' => '0.42 kg/day',
                                'circularity_rate' => '78%',
                                'recycling_rate' => '56%',
                                'landfill_diversion' => '49%',
                            ]
                        ],
                    ]
                ]),
            ],
            [
                'title' => 'Interactive Data Visualizations',
                'title_sw' => 'Michoro ya Data Inayoweza Kutumika',
                'identifier' => 'dashboard_charts',
                'content' => '<p>Explore waste management data through interactive charts and visualizations.</p>',
                'content_sw' => '<p>Chunguza data ya usimamizi wa taka kupitia chati na michoro inayoweza kutumika.</p>',
                'type' => 'html',
                'section' => 'charts',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'charts' => [
                        [
                            'title' => 'Waste Composition by Country',
                            'type' => 'pie',
                            'description' => 'The breakdown of waste types across different countries',
                            'data_url' => '/api/data/waste-composition',
                            'animation' => 'fade-in',
                        ],
                        [
                            'title' => 'Recycling Rate Trends (2019-2023)',
                            'type' => 'line',
                            'description' => 'How recycling rates have changed over the past five years',
                            'data_url' => '/api/data/recycling-trends',
                            'animation' => 'slide-in-right',
                        ],
                    ]
                ]),
            ],
            [
                'title' => 'Country Comparison Tool',
                'title_sw' => 'Zana ya Kulinganisha Nchi',
                'identifier' => 'dashboard_comparison',
                'content' => '<p>Compare waste management metrics between two countries side-by-side.</p>',
                'content_sw' => '<p>Linganisha vipimo vya usimamizi wa taka kati ya nchi mbili kando kwa kando.</p>',
                'type' => 'html',
                'section' => 'comparison',
                'order' => 1,
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation' => 'fade-in',
                    'countries' => ['Kenya', 'Tanzania', 'Rwanda', 'Uganda', 'Ethiopia'],
                    'metrics' => [
                        'Waste generation per capita',
                        'Recycling rate',
                        'Landfill diversion rate',
                        'Circularity index',
                    ]
                ]),
            ],
        ];

        foreach ($sections as $sectionData) {
            Content::updateOrCreate(
                [
                    'page_id' => $page->id, 
                    'section' => $sectionData['section'], 
                    'identifier' => $sectionData['identifier']
                ],
                $sectionData
            );
        }
    }
} 