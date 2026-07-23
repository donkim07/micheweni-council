<?php

namespace Database\Seeders;

use App\Models\Opportunities\CircularEconomy\Page;
use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AssessmentPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the assessment page
        $assessmentPage = Page::updateOrCreate(
            ['slug' => 'assessment'],
            [
                'title' => 'Waste Management Assessment',
                'description' => 'Evaluate your current waste management practices and identify areas for improvement.',
                'template' => 'assessment',
                'is_active' => true,
                'show_in_menu' => true,
                'menu_order' => 2,
                'show_in_navigation' => true,
                'navigation_order' => 3,
            ]
        );

        // Create intro section
        Content::updateOrCreate(
            ['page_id' => $assessmentPage->id, 'section' => 'intro', 'order' => 1],
            [
                'title' => 'Self-Assessment Journey',
                'title_sw' => 'Safari ya Tathmini-Binafsi',
                'identifier' => 'assessment_intro',
                'content' => '<p>Embark on an interactive journey to evaluate and improve your waste management practices. This assessment will guide you through key areas and provide personalized recommendations.</p>',
                'content_sw' => '<p>Anzisha safari ya kuvutia ili kutathmini na kuboresha mbinu zako za usimamizi wa taka. Tathmini hii itakuongoza kupitia maeneo muhimu na kutoa mapendekezo ya kibinafsi.</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation' => 'fade-in',
                    'icon' => 'fas fa-clipboard-check',
                    'background_color' => '#f8fafc',
                ]),
            ]
        );

        // Create the main assessment form
        $wasteCollectionForm = FormBuilder::updateOrCreate(
            ['slug' => 'waste-collection-assessment'],
            [
                'title' => 'Waste Collection & Sorting',
                'description' => 'Evaluate your waste collection and sorting systems',
                'icon' => 'fas fa-trash-alt',
                'is_active' => true,
                'fields' => json_encode($this->getWasteCollectionFormSchema()),
            ]
        );

        $recyclingForm = FormBuilder::updateOrCreate(
            ['slug' => 'recycling-infrastructure-assessment'],
            [
                'title' => 'Recycling Infrastructure',
                'description' => 'Assess your recycling facilities and processes',
                'icon' => 'fas fa-recycle',
                'is_active' => true,
                'fields' => json_encode($this->getRecyclingFormSchema()),
            ]
        );

        $circularDesignForm = FormBuilder::updateOrCreate(
            ['slug' => 'circular-design-assessment'],
            [
                'title' => 'Circular Product Design',
                'description' => 'Evaluate how products are designed for circularity',
                'icon' => 'fas fa-sync-alt',
                'is_active' => true,
                'fields' => json_encode($this->getCircularDesignFormSchema()),
            ]
        );

        $policyForm = FormBuilder::updateOrCreate(
            ['slug' => 'policy-governance-assessment'],
            [
                'title' => 'Policy & Governance',
                'description' => 'Assess waste management policies and governance',
                'icon' => 'fas fa-gavel',
                'is_active' => true,
                'fields' => json_encode($this->getPolicyFormSchema()),
            ]
        );

        // Link forms to content sections
        Content::updateOrCreate(
            ['page_id' => $assessmentPage->id, 'section' => 'assessment', 'order' => 1],
            [
                'title' => 'Waste Collection & Sorting',
                'title_sw' => 'Ukusanyaji na Uchambuzi wa Taka',
                'identifier' => 'waste_collection_section',
                'content' => '<p>Evaluate your current waste collection systems, frequency, coverage, and sorting practices.</p>',
                'content_sw' => '<p>Tathmini mifumo yako ya sasa ya ukusanyaji wa taka, mara kwa mara, upeo, na mbinu za uchambuzi.</p>',
                'type' => 'form',
                'is_active' => true,
                'form_builder_id' => $wasteCollectionForm->id,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-trash-alt',
                    'color' => '#2563eb',
                    'animation' => 'slide-in-left',
                    'section_number' => 1,
                ]),
            ]
        );

        Content::updateOrCreate(
            ['page_id' => $assessmentPage->id, 'section' => 'assessment', 'order' => 2],
            [
                'title' => 'Recycling Infrastructure',
                'title_sw' => 'Miundombinu ya Kuchakata',
                'identifier' => 'recycling_section',
                'content' => '<p>Assess your recycling facilities, processes, and capacity for different waste streams.</p>',
                'content_sw' => '<p>Tathmini vituo vyako vya kuchakata, michakato, na uwezo wa mtiririko tofauti wa taka.</p>',
                'type' => 'form',
                'is_active' => true,
                'form_builder_id' => $recyclingForm->id,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-recycle',
                    'color' => '#059669',
                    'animation' => 'slide-in-right',
                    'section_number' => 2,
                ]),
            ]
        );

        Content::updateOrCreate(
            ['page_id' => $assessmentPage->id, 'section' => 'assessment', 'order' => 3],
            [
                'title' => 'Circular Product Design',
                'title_sw' => 'Usanifu wa Bidhaa za Mzunguko',
                'identifier' => 'circular_design_section',
                'content' => '<p>Evaluate how products are designed for reuse, repair, and recycling in your region.</p>',
                'content_sw' => '<p>Tathmini jinsi bidhaa zinavyoundwa kwa ajili ya kutumia tena, kutengeneza, na kuchakata katika eneo lako.</p>',
                'type' => 'form',
                'is_active' => true,
                'form_builder_id' => $circularDesignForm->id,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-sync-alt',
                    'color' => '#7c3aed',
                    'animation' => 'slide-in-left',
                    'section_number' => 3,
                ]),
            ]
        );

        Content::updateOrCreate(
            ['page_id' => $assessmentPage->id, 'section' => 'assessment', 'order' => 4],
            [
                'title' => 'Policy & Governance',
                'title_sw' => 'Sera na Utawala',
                'identifier' => 'policy_section',
                'content' => '<p>Assess waste management policies, regulations, and governance structures.</p>',
                'content_sw' => '<p>Tathmini sera za usimamizi wa taka, kanuni, na miundo ya utawala.</p>',
                'type' => 'form',
                'is_active' => true,
                'form_builder_id' => $policyForm->id,
                'meta_data' => json_encode([
                    'icon' => 'fas fa-gavel',
                    'color' => '#b91c1c',
                    'animation' => 'slide-in-right',
                    'section_number' => 4,
                ]),
            ]
        );

        // Create summary section
        Content::updateOrCreate(
            ['page_id' => $assessmentPage->id, 'section' => 'summary', 'order' => 1],
            [
                'title' => 'Assessment Summary',
                'title_sw' => 'Muhtasari wa Tathmini',
                'identifier' => 'assessment_summary',
                'content' => '<p>Review your assessment results and get personalized recommendations for improvement.</p>',
                'content_sw' => '<p>Kagua matokeo ya tathmini yako na pata mapendekezo ya kibinafsi ya kuboresha.</p>',
                'type' => 'html',
                'is_active' => true,
                'meta_data' => json_encode([
                    'animation' => 'fade-in',
                    'icon' => 'fas fa-chart-pie',
                    'background_color' => '#f8fafc',
                ]),
            ]
        );
    }

    /**
     * Get the form schema for waste collection assessment
     */
    private function getWasteCollectionFormSchema(): array
    {
        return [
            [
                'type' => 'heading',
                'label' => 'Waste Collection Coverage',
                'level' => 3
            ],
            [
                'type' => 'radio',
                'name' => 'collection_coverage',
                'label' => 'What percentage of your region has access to waste collection services?',
                'required' => true,
                'options' => [
                    ['label' => 'Less than 30%', 'value' => 'under_30'],
                    ['label' => '30-50%', 'value' => '30_50'],
                    ['label' => '51-70%', 'value' => '51_70'],
                    ['label' => '71-90%', 'value' => '71_90'],
                    ['label' => 'More than 90%', 'value' => 'over_90'],
                ]
            ],
            [
                'type' => 'radio',
                'name' => 'collection_frequency',
                'label' => 'How frequently is waste collected in most areas?',
                'required' => true,
                'options' => [
                    ['label' => 'Less than once a week', 'value' => 'less_than_weekly'],
                    ['label' => 'Once a week', 'value' => 'weekly'],
                    ['label' => 'Twice a week', 'value' => 'twice_weekly'],
                    ['label' => 'More than twice a week', 'value' => 'more_than_twice'],
                ]
            ],
            [
                'type' => 'divider'
            ],
            [
                'type' => 'heading',
                'label' => 'Waste Sorting Practices',
                'level' => 3
            ],
            [
                'type' => 'checkbox',
                'name' => 'waste_streams',
                'label' => 'Which waste streams are separately collected in your region?',
                'required' => true,
                'options' => [
                    ['label' => 'Organic/Food waste', 'value' => 'organic'],
                    ['label' => 'Paper and cardboard', 'value' => 'paper'],
                    ['label' => 'Plastics', 'value' => 'plastics'],
                    ['label' => 'Glass', 'value' => 'glass'],
                    ['label' => 'Metals', 'value' => 'metals'],
                    ['label' => 'E-waste', 'value' => 'ewaste'],
                    ['label' => 'Hazardous waste', 'value' => 'hazardous'],
                ]
            ],
            [
                'type' => 'radio',
                'name' => 'sorting_location',
                'label' => 'Where does most waste sorting occur?',
                'required' => true,
                'options' => [
                    ['label' => 'At source (households/businesses)', 'value' => 'source'],
                    ['label' => 'At collection points', 'value' => 'collection_points'],
                    ['label' => 'At central sorting facilities', 'value' => 'central_facilities'],
                    ['label' => 'Minimal sorting occurs', 'value' => 'minimal'],
                ]
            ],
        ];
    }

    /**
     * Get the form schema for recycling infrastructure assessment
     */
    private function getRecyclingFormSchema(): array
    {
        return [
            [
                'type' => 'heading',
                'label' => 'Recycling Facilities',
                'level' => 3
            ],
            [
                'type' => 'checkbox',
                'name' => 'recycling_facilities',
                'label' => 'What types of recycling facilities exist in your region?',
                'required' => true,
                'options' => [
                    ['label' => 'Material Recovery Facilities (MRFs)', 'value' => 'mrf'],
                    ['label' => 'Composting facilities', 'value' => 'composting'],
                    ['label' => 'Paper recycling plants', 'value' => 'paper'],
                    ['label' => 'Plastic recycling plants', 'value' => 'plastic'],
                    ['label' => 'Glass recycling facilities', 'value' => 'glass'],
                    ['label' => 'Metal recycling facilities', 'value' => 'metal'],
                    ['label' => 'E-waste recycling facilities', 'value' => 'ewaste'],
                ]
            ],
            [
                'type' => 'radio',
                'name' => 'recycling_capacity',
                'label' => 'What percentage of collected recyclable waste can be processed locally?',
                'required' => true,
                'options' => [
                    ['label' => 'Less than 20%', 'value' => 'under_20'],
                    ['label' => '20-40%', 'value' => '20_40'],
                    ['label' => '41-60%', 'value' => '41_60'],
                    ['label' => '61-80%', 'value' => '61_80'],
                    ['label' => 'More than 80%', 'value' => 'over_80'],
                ]
            ],
        ];
    }

    /**
     * Get the form schema for circular design assessment
     */
    private function getCircularDesignFormSchema(): array
    {
        return [
            [
                'type' => 'heading',
                'label' => 'Product Design Practices',
                'level' => 3
            ],
            [
                'type' => 'radio',
                'name' => 'design_principles',
                'label' => 'To what extent are circular design principles implemented in local manufacturing?',
                'required' => true,
                'options' => [
                    ['label' => 'Very limited implementation', 'value' => 'very_limited'],
                    ['label' => 'Some implementation in specific sectors', 'value' => 'some_sectors'],
                    ['label' => 'Moderate implementation across several sectors', 'value' => 'moderate'],
                    ['label' => 'Widespread implementation', 'value' => 'widespread'],
                    ['label' => 'Comprehensive implementation with strong oversight', 'value' => 'comprehensive'],
                ]
            ],
            [
                'type' => 'checkbox',
                'name' => 'design_strategies',
                'label' => 'Which circular design strategies are commonly used?',
                'required' => true,
                'options' => [
                    ['label' => 'Design for durability/longevity', 'value' => 'durability'],
                    ['label' => 'Design for repair/maintenance', 'value' => 'repair'],
                    ['label' => 'Design for reuse/redistribution', 'value' => 'reuse'],
                    ['label' => 'Design for refurbishment/remanufacturing', 'value' => 'refurbishment'],
                    ['label' => 'Design for recycling/biodegradability', 'value' => 'recycling'],
                    ['label' => 'None of the above', 'value' => 'none'],
                ]
            ],
        ];
    }

    /**
     * Get the form schema for policy assessment
     */
    private function getPolicyFormSchema(): array
    {
        return [
            [
                'type' => 'heading',
                'label' => 'Waste Management Policies',
                'level' => 3
            ],
            [
                'type' => 'radio',
                'name' => 'policy_framework',
                'label' => 'How would you rate the comprehensiveness of waste management policies in your region?',
                'required' => true,
                'options' => [
                    ['label' => 'Very limited or non-existent', 'value' => 'very_limited'],
                    ['label' => 'Basic framework with significant gaps', 'value' => 'basic'],
                    ['label' => 'Moderate framework covering main waste streams', 'value' => 'moderate'],
                    ['label' => 'Comprehensive framework with some implementation challenges', 'value' => 'comprehensive'],
                    ['label' => 'Highly developed with strong implementation', 'value' => 'highly_developed'],
                ]
            ],
            [
                'type' => 'checkbox',
                'name' => 'policy_instruments',
                'label' => 'Which policy instruments are currently in use?',
                'required' => true,
                'options' => [
                    ['label' => 'Landfill/waste disposal taxes', 'value' => 'disposal_taxes'],
                    ['label' => 'Extended Producer Responsibility (EPR) schemes', 'value' => 'epr'],
                    ['label' => 'Bans on specific single-use items', 'value' => 'single_use_bans'],
                    ['label' => 'Recycling targets', 'value' => 'recycling_targets'],
                    ['label' => 'Pay-as-you-throw systems', 'value' => 'payt'],
                    ['label' => 'Green public procurement', 'value' => 'green_procurement'],
                    ['label' => 'None of the above', 'value' => 'none'],
                ]
            ],
        ];
    }
} 