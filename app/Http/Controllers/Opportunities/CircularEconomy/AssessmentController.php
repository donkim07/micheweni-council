<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use App\Http\Controllers\Controller;

use App\Models\Opportunities\CircularEconomy\Content;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use App\Models\Opportunities\CircularEconomy\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AssessmentController extends Controller
{
    /**
     * Display the assessment tools page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get assessment sections content
        $introContent = Content::where('type', 'assessment_intro')
            ->where('is_active', true)
            ->first();
            
        // Get all assessment sections
        $sections = [
            'waste_collection' => [
                'title' => 'Waste Collection & Sorting',
                'icon' => 'trash',
                'description' => 'Evaluate your waste collection systems and sorting processes',
                'completed' => false,
                'order' => 1
            ],
            'recycling' => [
                'title' => 'Recycling Infrastructure',
                'icon' => 'recycle',
                'description' => 'Assess your recycling facilities and infrastructure',
                'completed' => false,
                'order' => 2
            ],
            'circular_design' => [
                'title' => 'Circular Product Design',
                'icon' => 'sync',
                'description' => 'Evaluate product design for circularity and reuse',
                'completed' => false,
                'order' => 3
            ],
            'policy' => [
                'title' => 'Policy & Governance',
                'icon' => 'gavel',
                'description' => 'Review waste management policies and governance structures',
                'completed' => false,
                'order' => 4
            ]
        ];
        
        // Get form builders for assessment
        $assessmentForms = FormBuilder::where('is_active', true)
            ->whereIn('slug', ['waste-collection-assessment', 'recycling-infrastructure-assessment', 'circular-design-assessment', 'policy-governance-assessment'])
            ->get();
            
        // Check for user's previous submissions
        $userSubmissions = null;
        $completedSections = 0;
        
        if (Auth::check()) {
            $userSubmissions = FormSubmission::where('user_id', Auth::id())
                ->where('status', 'completed')
                ->orderBy('created_at', 'desc')
                ->get();
                
            // Mark completed sections based on submissions
            foreach ($userSubmissions as $submission) {
                $sectionKey = $submission->meta_data['section'] ?? null;
                if ($sectionKey && isset($sections[$sectionKey])) {
                    $sections[$sectionKey]['completed'] = true;
                    $completedSections++;
                }
            }
        }
        
        // Calculate completion percentage
        $totalSections = count($sections);
        $completionPercentage = ($totalSections > 0) ? ($completedSections / $totalSections) * 100 : 0;
        
        return view('opportunities.circular-economy.assessment.index', compact(
            'introContent', 
            'sections', 
            'assessmentForms', 
            'userSubmissions',
            'completionPercentage'
        ));
    }
    
    /**
     * Display a specific assessment section
     *
     * @param string $section
     * @return \Illuminate\View\View
     */
    public function section($section)
    {
        // Special handling for introduction section
        if ($section === 'introduction') {
            // Redirect to the first actual assessment section
            return redirect()->route('opportunities.circular-economy.assessment.section', 'waste_collection');
        }
        
        // Validate section exists
        $validSections = ['waste_collection', 'recycling', 'circular_design', 'policy'];
        if (!in_array($section, $validSections)) {
            abort(404, 'Assessment section not found');
        }
        
        // Get section title and content
        $sectionTitles = [
            'waste_collection' => 'Waste Collection & Sorting',
            'recycling' => 'Recycling Infrastructure',
            'circular_design' => 'Circular Product Design',
            'policy' => 'Policy & Governance'
        ];
        
        // Get form for this section
        $sectionSlugs = [
            'waste_collection' => 'waste-collection-assessment',
            'recycling' => 'recycling-infrastructure-assessment',
            'circular_design' => 'circular-design-assessment',
            'policy' => 'policy-governance-assessment'
        ];
        
        // Get form for this section
        $form = FormBuilder::where('slug', $sectionSlugs[$section] ?? '')
            ->where('is_active', true)
            ->first();
            
        if (!$form) {
            abort(404, 'Assessment form not found');
        }
        
        // Get user's previous submission for this section
        $previousSubmission = null;
        if (Auth::check()) {
            $previousSubmission = FormSubmission::where('user_id', Auth::id())
                ->where('form_builder_id', $form->id)
                ->where('status', 'completed')
                ->orderBy('created_at', 'desc')
                ->first();
        }
        
        return view('opportunities.circular-economy.assessment.section', [
            'sectionKey' => $section,
            'sectionTitle' => $sectionTitles[$section] ?? 'Assessment',
            'form' => $form,
            'previousSubmission' => $previousSubmission
        ]);
    }
    
    /**
     * Store assessment submission
     *
     * @param Request $request
     * @param string $section
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitSection(Request $request, $section)
    {
        // Validate section exists
        $validSections = ['waste_collection', 'recycling', 'circular_design', 'policy'];
        if (!in_array($section, $validSections)) {
            abort(404, 'Assessment section not found');
        }
        
        // Get section slugs
        $sectionSlugs = [
            'waste_collection' => 'waste-collection-assessment',
            'recycling' => 'recycling-infrastructure-assessment',
            'circular_design' => 'circular-design-assessment',
            'policy' => 'policy-governance-assessment'
        ];
        
        // Get form for this section
        $form = FormBuilder::where('slug', $sectionSlugs[$section] ?? '')
            ->where('is_active', true)
            ->first();
            
        if (!$form) {
            abort(404, 'Assessment form not found');
        }
        
        // Validate form inputs based on form fields
        $validationRules = [];
        $formFields = $form->fields;
        
        if (!empty($formFields)) {
            foreach ($formFields as $field) {
                if (!empty($field['name']) && isset($field['required']) && $field['required']) {
                    $validationRules[$field['name']] = 'required';
                }
            }
        }
        
        $validatedData = $request->validate($validationRules);
        
        // Create or update submission
        $submission = new FormSubmission();
        $submission->form_builder_id = $form->id;
        $submission->user_id = Auth::id() ?? null;
        $submission->data = json_encode($validatedData);
        $submission->status = 'completed';
        
        // Set metadata as a JSON field
        $metaData = [
            'section' => $section,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];
        $submission->meta_data = json_encode($metaData);
        
        $submission->save();
        
        return redirect()->route('opportunities.circular-economy.assessment.section.results', [
            'section' => $section,
            'submission' => $submission->id
        ]);
    }
    
    /**
     * Display assessment results
     *
     * @param string $section
     * @param int $submissionId
     * @return \Illuminate\View\View
     */
    public function results($section, $submissionId)
    {
        $submission = FormSubmission::findOrFail($submissionId);
        
        // Check if user is authorized to view this submission
        if (Auth::check() && $submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Get form for this section
        $form = $submission->formBuilder;
        
        // Calculate score and recommendations
        $formData = json_decode($submission->data, true);
        $formFields = $form ? json_decode($form->fields, true) : [];
        $score = $this->calculateSectionScore($formData, $formFields);
        $recommendations = $this->generateRecommendations($section, $formData, $score);
        
        return view('opportunities.circular-economy.assessment.results', [
            'section' => $section,
            'submission' => $submission,
            'form' => $form,
            'score' => $score,
            'recommendations' => $recommendations
        ]);
    }
    
    /**
     * Calculate score for section based on form data
     *
     * @param array $formData
     * @param array $formFields
     * @return array
     */
    private function calculateSectionScore($formData, $formFields)
    {
        $totalPoints = 0;
        $earnedPoints = 0;
        $categoryScores = [];
        
        // Process each field
        if (!empty($formFields) && is_array($formFields)) {
            foreach ($formFields as $field) {
                if (empty($field['scoring']) || empty($field['name'])) {
                    continue;
                }
                
                $fieldName = $field['name'];
                $category = $field['category'] ?? 'general';
                
                if (!isset($categoryScores[$category])) {
                    $categoryScores[$category] = [
                        'total' => 0,
                        'earned' => 0
                    ];
                }
                
                // Get field value from submission
                $value = $formData[$fieldName] ?? null;
                
                // Calculate points
                $fieldTotalPoints = $field['scoring']['max_points'] ?? 0;
                $fieldEarnedPoints = 0;
                
                if ($value !== null) {
                    if ($field['type'] === 'radio' || $field['type'] === 'select') {
                        // For single choice, lookup the option points
                        foreach ($field['options'] ?? [] as $option) {
                            if ($option['value'] == $value && isset($option['points'])) {
                                $fieldEarnedPoints = $option['points'];
                                break;
                            }
                        }
                    } elseif ($field['type'] === 'checkbox') {
                        // For checkboxes, sum the points of selected options
                        $selectedValues = is_array($value) ? $value : [$value];
                        foreach ($field['options'] ?? [] as $option) {
                            if (in_array($option['value'], $selectedValues) && isset($option['points'])) {
                                $fieldEarnedPoints += $option['points'];
                            }
                        }
                    } elseif ($field['type'] === 'range') {
                        // For range, calculate proportional points
                        $min = $field['min'] ?? 0;
                        $max = $field['max'] ?? 100;
                        $range = $max - $min;
                        if ($range > 0) {
                            $fieldEarnedPoints = ($value - $min) / $range * $fieldTotalPoints;
                        }
                    }
                }
                
                // Add to totals
                $totalPoints += $fieldTotalPoints;
                $earnedPoints += $fieldEarnedPoints;
                
                // Add to category scores
                $categoryScores[$category]['total'] += $fieldTotalPoints;
                $categoryScores[$category]['earned'] += $fieldEarnedPoints;
            }
        }
        
        // Calculate overall percentage
        $overallPercentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
        
        // Calculate category percentages
        foreach ($categoryScores as &$categoryScore) {
            $categoryScore['percentage'] = $categoryScore['total'] > 0 
                ? round(($categoryScore['earned'] / $categoryScore['total']) * 100) 
                : 0;
        }
        
        return [
            'total_points' => $totalPoints,
            'earned_points' => $earnedPoints,
            'overall_percentage' => $overallPercentage,
            'categories' => $categoryScores
        ];
    }
    
    /**
     * Generate recommendations based on assessment results
     *
     * @param string $section
     * @param array $formData
     * @param array $score
     * @return array
     */
    private function generateRecommendations($section, $formData, $score)
    {
        $recommendations = [];
        
        // Add section-specific recommendations based on score
        if ($section === 'waste_collection') {
            if ($score['overall_percentage'] < 30) {
                $recommendations[] = [
                    'title' => 'Establish Basic Waste Collection',
                    'description' => 'Implement a regular waste collection schedule for households and businesses.',
                    'priority' => 'high'
                ];
                $recommendations[] = [
                    'title' => 'Waste Sorting Education',
                    'description' => 'Educate residents about basic waste sorting practices.',
                    'priority' => 'high'
                ];
            } elseif ($score['overall_percentage'] < 70) {
                $recommendations[] = [
                    'title' => 'Improve Collection Coverage',
                    'description' => 'Extend waste collection services to underserved areas.',
                    'priority' => 'medium'
                ];
                $recommendations[] = [
                    'title' => 'Enhanced Sorting Infrastructure',
                    'description' => 'Introduce more sorting categories and appropriate containers.',
                    'priority' => 'medium'
                ];
            } else {
                $recommendations[] = [
                    'title' => 'Advanced Collection Technology',
                    'description' => 'Implement smart waste bins and route optimization.',
                    'priority' => 'low'
                ];
                $recommendations[] = [
                    'title' => 'Community Engagement Programs',
                    'description' => 'Develop programs to maintain high community participation.',
                    'priority' => 'medium'
                ];
            }
        } elseif ($section === 'recycling') {
            // Recycling-specific recommendations
            if ($score['overall_percentage'] < 30) {
                $recommendations[] = [
                    'title' => 'Basic Recycling Facilities',
                    'description' => 'Establish facilities for processing common recyclables.',
                    'priority' => 'high'
                ];
            } elseif ($score['overall_percentage'] < 70) {
                $recommendations[] = [
                    'title' => 'Expand Material Processing',
                    'description' => 'Add capacity for processing additional types of materials.',
                    'priority' => 'medium'
                ];
            } else {
                $recommendations[] = [
                    'title' => 'Innovation in Recycling',
                    'description' => 'Implement advanced technologies for difficult-to-recycle materials.',
                    'priority' => 'low'
                ];
            }
        } elseif ($section === 'circular_design') {
            // Circular design recommendations
            if ($score['overall_percentage'] < 40) {
                $recommendations[] = [
                    'title' => 'Design for Durability',
                    'description' => 'Encourage product designs that last longer and are repairable.',
                    'priority' => 'high'
                ];
            } else {
                $recommendations[] = [
                    'title' => 'Closed-Loop Systems',
                    'description' => 'Develop systems where products are designed for full material recovery.',
                    'priority' => 'medium'
                ];
            }
        } elseif ($section === 'policy') {
            // Policy recommendations
            if ($score['overall_percentage'] < 50) {
                $recommendations[] = [
                    'title' => 'Basic Waste Management Regulations',
                    'description' => 'Establish core regulations for waste handling and disposal.',
                    'priority' => 'high'
                ];
            } else {
                $recommendations[] = [
                    'title' => 'Extended Producer Responsibility',
                    'description' => 'Implement policies that make producers responsible for post-consumer waste.',
                    'priority' => 'medium'
                ];
            }
        }
        
        // Add general recommendations
        if ($score['overall_percentage'] < 40) {
            $recommendations[] = [
                'title' => 'Develop Basic Infrastructure',
                'description' => 'Focus on establishing fundamental waste management systems.',
                'priority' => 'high'
            ];
        } elseif ($score['overall_percentage'] < 70) {
            $recommendations[] = [
                'title' => 'Enhance Existing Systems',
                'description' => 'Improve efficiency and coverage of current waste management practices.',
                'priority' => 'medium'
            ];
        } else {
            $recommendations[] = [
                'title' => 'Innovation and Leadership',
                'description' => 'Explore cutting-edge solutions and share best practices.',
                'priority' => 'low'
            ];
        }
        
        return $recommendations;
    }
    
    /**
     * Continue assessment from last incomplete section
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function continue()
    {
        // Get all assessment sections in order
        $sections = [
            'waste_collection',
            'recycling',
            'circular_design',
            'policy'
        ];
        
        // Section slugs for form lookup
        $sectionSlugs = [
            'waste_collection' => 'waste-collection-assessment',
            'recycling' => 'recycling-infrastructure-assessment',
            'circular_design' => 'circular-design-assessment',
            'policy' => 'policy-governance-assessment'
        ];
        
        // Check for user's previous submissions
        $completedSections = [];
        if (Auth::check()) {
            foreach ($sections as $section) {
                $form = FormBuilder::where('slug', $sectionSlugs[$section] ?? '')
                    ->where('is_active', true)
                    ->first();
                    
                if ($form) {
                    $submission = FormSubmission::where('user_id', Auth::id())
                        ->where('form_builder_id', $form->id)
                        ->where('status', 'completed')
                        ->first();
                        
                    if ($submission) {
                        $completedSections[] = $section;
                    }
                }
            }
        }
        
        // Find first incomplete section
        $nextSection = null;
        foreach ($sections as $section) {
            if (!in_array($section, $completedSections)) {
                $nextSection = $section;
                break;
            }
        }
        
        // If all sections are complete, go to results
        if (!$nextSection) {
            return redirect()->route('opportunities.circular-economy.assessment.showResults');
        }
        
        // Redirect to next incomplete section
        return redirect()->route('opportunities.circular-economy.assessment.section', $nextSection);
    }
    
    /**
     * Show overall assessment results
     *
     * @return \Illuminate\View\View
     */
    public function showResults()
    {
        // Get all assessment sections
        $sections = [
            'waste_collection',
            'recycling',
            'circular_design',
            'policy'
        ];
        
        // Section slugs for form lookup
        $sectionSlugs = [
            'waste_collection' => 'waste-collection-assessment',
            'recycling' => 'recycling-infrastructure-assessment',
            'circular_design' => 'circular-design-assessment',
            'policy' => 'policy-governance-assessment'
        ];
        
        // Section titles for display
        $sectionTitles = [
            'waste_collection' => 'Waste Collection & Sorting',
            'recycling' => 'Recycling Infrastructure',
            'circular_design' => 'Circular Product Design',
            'policy' => 'Policy & Governance'
        ];
        
        // Check for user's previous submissions
        $submissions = [];
        $scores = [];
        $totalScore = 0;
        $sectionCount = 0;
        
        if (Auth::check()) {
            foreach ($sections as $section) {
                $form = FormBuilder::where('slug', $sectionSlugs[$section] ?? '')
                    ->where('is_active', true)
                    ->first();
                    
                if ($form) {
                    $submission = FormSubmission::where('user_id', Auth::id())
                        ->where('form_builder_id', $form->id)
                        ->where('status', 'completed')
                        ->orderBy('created_at', 'desc')
                        ->first();
                        
                    if ($submission) {
                        $submissions[$section] = $submission;
                        
                        // Calculate section score
                        $formData = json_decode($submission->data, true);
                        $formFields = $form->fields;
                        $sectionScore = $this->calculateSectionScore($formData, $formFields);
                        $scores[$section] = $sectionScore;
                        
                        // Add to total score
                        $totalScore += $sectionScore['percentage'] ?? 0;
                        $sectionCount++;
                    }
                }
            }
        }
        
        // Calculate overall score
        $overallScore = $sectionCount > 0 ? ($totalScore / $sectionCount) : 0;
        
        // Generate overall recommendations
        $recommendations = $this->generateOverallRecommendations($scores);
        
        return view('opportunities.circular-economy.assessment.overall-results', [
            'sections' => $sections,
            'sectionTitles' => $sectionTitles,
            'submissions' => $submissions,
            'scores' => $scores,
            'overallScore' => $overallScore,
            'recommendations' => $recommendations
        ]);
    }
    
    /**
     * Generate overall recommendations based on all section scores
     *
     * @param array $scores
     * @return array
     */
    private function generateOverallRecommendations($scores)
    {
        $recommendations = [
            'high_priority' => [],
            'medium_priority' => [],
            'low_priority' => []
        ];
        
        // Add recommendations based on section scores
        foreach ($scores as $section => $score) {
            $sectionPercentage = $score['percentage'] ?? 0;
            
            if ($sectionPercentage < 50) {
                // High priority recommendations for poor performing areas
                switch ($section) {
                    case 'waste_collection':
                        $recommendations['high_priority'][] = 'Implement a structured waste collection system with regular schedules';
                        $recommendations['high_priority'][] = 'Establish waste sorting stations in key areas';
                        break;
                        
                    case 'recycling':
                        $recommendations['high_priority'][] = 'Develop basic recycling infrastructure for most common materials';
                        $recommendations['high_priority'][] = 'Create incentives for recycling participation';
                        break;
                        
                    case 'circular_design':
                        $recommendations['high_priority'][] = 'Begin education programs on circular economy principles';
                        $recommendations['high_priority'][] = 'Identify key products for circular redesign';
                        break;
                        
                    case 'policy':
                        $recommendations['high_priority'][] = 'Develop core waste management policies and regulations';
                        $recommendations['high_priority'][] = 'Establish enforcement mechanisms for proper waste disposal';
                        break;
                }
            } else if ($sectionPercentage < 75) {
                // Medium priority recommendations for average performing areas
                switch ($section) {
                    case 'waste_collection':
                        $recommendations['medium_priority'][] = 'Optimize waste collection routes for efficiency';
                        $recommendations['medium_priority'][] = 'Expand sorting capabilities to more waste types';
                        break;
                        
                    case 'recycling':
                        $recommendations['medium_priority'][] = 'Enhance processing capabilities for existing recyclables';
                        $recommendations['medium_priority'][] = 'Develop local markets for recycled materials';
                        break;
                        
                    case 'circular_design':
                        $recommendations['medium_priority'][] = 'Implement pilot programs for circular product design';
                        $recommendations['medium_priority'][] = 'Develop repair and reuse networks';
                        break;
                        
                    case 'policy':
                        $recommendations['medium_priority'][] = 'Refine existing policies to address gaps';
                        $recommendations['medium_priority'][] = 'Develop incentives for sustainable waste practices';
                        break;
                }
            } else {
                // Low priority recommendations for high performing areas
                switch ($section) {
                    case 'waste_collection':
                        $recommendations['low_priority'][] = 'Implement advanced tracking systems for waste collection';
                        $recommendations['low_priority'][] = 'Explore innovative methods for difficult-to-sort materials';
                        break;
                        
                    case 'recycling':
                        $recommendations['low_priority'][] = 'Explore advanced recycling technologies for complex materials';
                        $recommendations['low_priority'][] = 'Develop closed-loop systems for key material streams';
                        break;
                        
                    case 'circular_design':
                        $recommendations['low_priority'][] = 'Establish comprehensive design guidelines for circularity';
                        $recommendations['low_priority'][] = 'Create innovation centers for circular product development';
                        break;
                        
                    case 'policy':
                        $recommendations['low_priority'][] = 'Develop leading-edge policies for zero waste targets';
                        $recommendations['low_priority'][] = 'Create comprehensive monitoring and reporting systems';
                        break;
                }
            }
        }
        
        return $recommendations;
    }
    
    /**
     * Generate PDF report for assessment submission
     *
     * @param int $submissionId
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($submissionId)
    {
        // Find the submission
        $submission = FormSubmission::findOrFail($submissionId);
        
        // Check if user is authorized to view this submission
        if (Auth::check() && $submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Get form for this section
        $form = $submission->formBuilder;
        
        // Get section name
        $section = $submission->section;
        $sectionName = ucwords(str_replace('_', ' ', $section));
        
        // Calculate score and recommendations
        $formData = json_decode($submission->data, true);
        $formFields = $form ? json_decode($form->fields, true) : [];
        $score = $this->calculateSectionScore($formData, $formFields);
        $recommendations = $this->generateRecommendations($section, $formData, $score);
        
        $overallScore = $score['overall_percentage'] ?? 0;
        
        // Generate PDF with view
        $pdf = Pdf::loadView('opportunities.circular-economy.assessment.pdf', [
            'submission' => $submission,
            'section' => $section,
            'sectionName' => $sectionName,
            'score' => $score,
            'overallScore' => $overallScore,
            'recommendations' => $recommendations
        ]);
        
        // Download PDF
        return $pdf->download('assessment-report-' . $submissionId . '.pdf');
    }
} 