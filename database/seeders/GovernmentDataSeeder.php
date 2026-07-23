<?php

namespace Database\Seeders;

use App\Models\Government\Announcement;
use App\Models\Government\Department;
use App\Models\Government\News;
use App\Models\Government\NewsCategory;
use App\Models\Government\Project;
use App\Models\Government\ProjectCategory;
use App\Models\Government\Service;
use App\Models\Government\Statistics;
use App\Models\Government\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GovernmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Department data
        $this->createDepartments();
        
        // Create Services data
        $this->createServices();
        
        // Create Project Categories
        $this->createProjectCategories();
        
        // Create Projects
        $this->createProjects();
        
        // Create News Categories
        $this->createNewsCategories();
        
        // Create News
        $this->createNews();
        
        // Create Announcements
        $this->createAnnouncements();
        
        // Create Testimonials
        $this->createTestimonials();
        
        // Create Statistics
        $this->createStatistics();
    }
    
    /**
     * Create departments data.
     *
     * @return void
     */
    private function createDepartments()
    {
        $departments = [
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'The Education Department is responsible for managing all educational institutions and programs in Micheweni District.',
                'head_name' => 'Mr. Hassan Omar',
                'head_title' => 'Director of Education',
                'contact_email' => 'education@micheweni.go.tz',
                'contact_phone' => '+255 777 111 222',
                'location' => 'Main Government Building, Floor 2, Micheweni',
                'status' => 'active',
                'order' => 1
            ],
            [
                'name' => 'Health',
                'slug' => 'health',
                'description' => 'The Health Department oversees all healthcare facilities and public health initiatives in Micheweni District.',
                'head_name' => 'Dr. Amina Juma',
                'head_title' => 'Director of Health Services',
                'contact_email' => 'health@micheweni.go.tz',
                'contact_phone' => '+255 777 333 444',
                'location' => 'Health Complex, Micheweni Central',
                'status' => 'active',
                'order' => 2
            ],
            [
                'name' => 'Infrastructure',
                'slug' => 'infrastructure',
                'description' => 'The Infrastructure Department manages roads, public works, and transportation systems in Micheweni District.',
                'head_name' => 'Eng. Ali Khamis',
                'head_title' => 'Director of Infrastructure',
                'contact_email' => 'infrastructure@micheweni.go.tz',
                'contact_phone' => '+255 777 555 666',
                'location' => 'Technical Building, Micheweni South',
                'status' => 'active',
                'order' => 3
            ],
            [
                'name' => 'Agriculture',
                'slug' => 'agriculture',
                'description' => 'The Agriculture Department supports farmers and promotes sustainable agricultural practices in Micheweni District.',
                'head_name' => 'Ms. Maryam Said',
                'head_title' => 'Director of Agriculture',
                'contact_email' => 'agriculture@micheweni.go.tz',
                'contact_phone' => '+255 777 777 888',
                'location' => 'Agricultural Extension Center, Micheweni East',
                'status' => 'active',
                'order' => 4
            ],
            [
                'name' => 'Finance',
                'slug' => 'finance',
                'description' => 'The Finance Department manages the district\'s budget, revenue collection, and financial planning.',
                'head_name' => 'Mr. Ibrahim Ahmed',
                'head_title' => 'Director of Finance',
                'contact_email' => 'finance@micheweni.go.tz',
                'contact_phone' => '+255 777 999 000',
                'location' => 'Main Government Building, Floor 1, Micheweni',
                'status' => 'active',
                'order' => 5
            ],
            [
                'name' => 'Environment',
                'slug' => 'environment',
                'description' => 'The Environment Department oversees environmental protection, waste management, and conservation programs.',
                'head_name' => 'Ms. Saida Mohammed',
                'head_title' => 'Director of Environment',
                'contact_email' => 'environment@micheweni.go.tz',
                'contact_phone' => '+255 777 121 212',
                'location' => 'Green Building, Micheweni Central',
                'status' => 'active',
                'order' => 6
            ],
        ];
        
        foreach ($departments as $department) {
            Department::create($department);
        }
    }
    
    /**
     * Create services data.
     *
     * @return void
     */
    private function createServices()
    {
        $departments = Department::all();
        
        $services = [
            [
                'title' => 'Business Permits',
                'slug' => 'business-permits',
                'short_description' => 'Apply for business permits and licenses for your commercial activities in Micheweni district.',
                'description' => 'The Business Permits service allows entrepreneurs and business owners to apply for and obtain the necessary permits and licenses to operate legally within Micheweni District. Our streamlined process ensures quick turnaround times and clear guidance on compliance requirements.',
                'icon' => 'fa-id-card',
                'department_id' => $departments->where('slug', 'finance')->first()->id,
                'status' => 'active',
                'is_featured' => true,
                'order' => 1
            ],
            [
                'title' => 'Building Permits',
                'slug' => 'building-permits',
                'short_description' => 'Get approvals for construction, renovation, and development projects in our district.',
                'description' => 'The Building Permits service provides approvals for construction, renovation, and development projects in Micheweni District. Our team ensures that all building projects meet safety codes, zoning regulations, and environmental standards to create a well-planned and safe community.',
                'icon' => 'fa-home',
                'department_id' => $departments->where('slug', 'infrastructure')->first()->id,
                'status' => 'active',
                'is_featured' => true,
                'order' => 2
            ],
            [
                'title' => 'Waste Management',
                'slug' => 'waste-management',
                'short_description' => 'Access our comprehensive waste management and circular economy services.',
                'description' => 'Our Waste Management service provides comprehensive solutions for waste collection, recycling, and disposal in Micheweni District. We are committed to implementing circular economy principles to reduce waste, promote recycling, and protect our environment for future generations.',
                'icon' => 'fa-recycle',
                'department_id' => $departments->where('slug', 'environment')->first()->id,
                'status' => 'active',
                'is_featured' => true,
                'order' => 3
            ],
            [
                'title' => 'Health Services',
                'slug' => 'health-services',
                'short_description' => 'Find healthcare facilities, vaccination programs, and public health initiatives.',
                'description' => 'Our Health Services provide information about healthcare facilities, vaccination programs, and public health initiatives in Micheweni District. We are committed to ensuring that all residents have access to quality healthcare services and preventive health programs.',
                'icon' => 'fa-heartbeat',
                'department_id' => $departments->where('slug', 'health')->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'order' => 4
            ],
            [
                'title' => 'Education Services',
                'slug' => 'education-services',
                'short_description' => 'Information about schools, enrollment, scholarships, and educational programs.',
                'description' => 'Our Education Services provide information about schools, enrollment procedures, scholarships, and educational programs in Micheweni District. We are dedicated to promoting quality education and ensuring that all children have access to learning opportunities.',
                'icon' => 'fa-graduation-cap',
                'department_id' => $departments->where('slug', 'education')->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'order' => 5
            ],
            [
                'title' => 'Agricultural Support',
                'slug' => 'agricultural-support',
                'short_description' => 'Support for farmers including extension services, training, and resources.',
                'description' => 'Our Agricultural Support service provides assistance to farmers through extension services, training programs, and access to resources and modern farming techniques. We aim to enhance agricultural productivity and promote sustainable farming practices in Micheweni District.',
                'icon' => 'fa-seedling',
                'department_id' => $departments->where('slug', 'agriculture')->first()->id,
                'status' => 'active',
                'is_featured' => false,
                'order' => 6
            ],
        ];
        
        foreach ($services as $service) {
            Service::create($service);
        }
    }
    
    /**
     * Create project categories data.
     *
     * @return void
     */
    private function createProjectCategories()
    {
        $categories = [
            [
                'name' => 'Infrastructure',
                'slug' => 'infrastructure',
                'description' => 'Projects related to roads, bridges, buildings, and other physical infrastructure.',
                'icon' => 'fa-road',
                'status' => 'active'
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Projects focused on schools, libraries, and educational facilities.',
                'icon' => 'fa-school',
                'status' => 'active'
            ],
            [
                'name' => 'Healthcare',
                'slug' => 'healthcare',
                'description' => 'Projects related to hospitals, clinics, and health service improvements.',
                'icon' => 'fa-hospital',
                'status' => 'active'
            ],
            [
                'name' => 'Environment',
                'slug' => 'environment',
                'description' => 'Projects focused on environmental conservation, waste management, and sustainability.',
                'icon' => 'fa-leaf',
                'status' => 'active'
            ],
            [
                'name' => 'Water & Sanitation',
                'slug' => 'water-sanitation',
                'description' => 'Projects related to water supply, sewerage, and sanitation facilities.',
                'icon' => 'fa-tint',
                'status' => 'active'
            ],
        ];
        
        foreach ($categories as $category) {
            ProjectCategory::create($category);
        }
    }
    
    /**
     * Create projects data.
     *
     * @return void
     */
    private function createProjects()
    {
        $departments = Department::all();
        $categories = ProjectCategory::all();
        
        $projects = [
            [
                'title' => 'Road Infrastructure Improvement',
                'slug' => 'road-infrastructure-improvement',
                'description' => 'A comprehensive project to improve road infrastructure across Micheweni District, including paving, drainage systems, and road signs.',
                'short_description' => 'Improving road network across Micheweni District for better transportation.',
                'category_id' => $categories->where('slug', 'infrastructure')->first()->id,
                'department_id' => $departments->where('slug', 'infrastructure')->first()->id,
                'location' => 'Various locations in Micheweni District',
                'start_date' => now()->subMonths(6),
                'end_date' => now()->addYears(1),
                'budget' => 500000.00,
                'status' => 'ongoing',
                'is_featured' => true,
                'completion_percentage' => 35
            ],
            [
                'title' => 'School Renovation Program',
                'slug' => 'school-renovation-program',
                'description' => 'A project to renovate and modernize schools across Micheweni District, improving classrooms, facilities, and educational resources.',
                'short_description' => 'Renovating and modernizing schools to improve learning environments.',
                'category_id' => $categories->where('slug', 'education')->first()->id,
                'department_id' => $departments->where('slug', 'education')->first()->id,
                'location' => 'Multiple school locations',
                'start_date' => now()->subMonths(8),
                'end_date' => now()->subMonths(1),
                'budget' => 300000.00,
                'status' => 'completed',
                'is_featured' => true,
                'completion_percentage' => 100
            ],
            [
                'title' => 'Water Supply Expansion',
                'slug' => 'water-supply-expansion',
                'description' => 'A project to expand water supply networks to underserved areas, including new pipelines, water tanks, and treatment facilities.',
                'short_description' => 'Expanding clean water access to underserved communities.',
                'category_id' => $categories->where('slug', 'water-sanitation')->first()->id,
                'department_id' => $departments->where('slug', 'infrastructure')->first()->id,
                'location' => 'Northern and Eastern Micheweni',
                'start_date' => now()->subMonths(3),
                'end_date' => now()->addMonths(9),
                'budget' => 450000.00,
                'status' => 'ongoing',
                'is_featured' => true,
                'completion_percentage' => 40
            ],
            [
                'title' => 'Healthcare Center Modernization',
                'slug' => 'healthcare-center-modernization',
                'description' => 'A project to modernize healthcare facilities across Micheweni District with new equipment, renovated buildings, and improved services.',
                'short_description' => 'Upgrading healthcare facilities with modern equipment and infrastructure.',
                'category_id' => $categories->where('slug', 'healthcare')->first()->id,
                'department_id' => $departments->where('slug', 'health')->first()->id,
                'location' => 'Micheweni Central Hospital and satellite clinics',
                'start_date' => now()->addMonths(1),
                'end_date' => now()->addMonths(18),
                'budget' => 700000.00,
                'status' => 'planning',
                'is_featured' => true,
                'completion_percentage' => 0
            ],
        ];
        
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
    
    /**
     * Create news categories data.
     *
     * @return void
     */
    private function createNewsCategories()
    {
        $categories = [
            [
                'name' => 'Announcements',
                'slug' => 'announcements',
                'description' => 'Official announcements from the Micheweni District Government.',
                'status' => 'active'
            ],
            [
                'name' => 'Events',
                'slug' => 'events',
                'description' => 'Information about upcoming and past events in Micheweni District.',
                'status' => 'active'
            ],
            [
                'name' => 'Development',
                'slug' => 'development',
                'description' => 'News about development projects and initiatives in Micheweni District.',
                'status' => 'active'
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'News related to education and schools in Micheweni District.',
                'status' => 'active'
            ],
            [
                'name' => 'Health',
                'slug' => 'health',
                'description' => 'News about health services and public health in Micheweni District.',
                'status' => 'active'
            ],
        ];
        
        foreach ($categories as $category) {
            NewsCategory::create($category);
        }
    }
    
    /**
     * Create news data.
     *
     * @return void
     */
    private function createNews()
    {
        $categories = NewsCategory::all();
        
        $news = [
            [
                'title' => 'New Water Supply System Launched in Micheweni District',
                'slug' => 'new-water-supply-system-launched',
                'excerpt' => 'The Micheweni District Council has launched a new water supply system that will benefit over 20,000 residents.',
                'content' => '<p>The Micheweni District Council has officially launched a new water supply system that will provide clean and reliable water to over 20,000 residents in previously underserved areas.</p><p>The project, which cost approximately $2.5 million, includes new pipelines, water tanks, and a modern treatment facility. The system is expected to significantly reduce waterborne diseases and improve the quality of life for residents.</p><p>"This is a major milestone for our district," said the District Commissioner during the launch ceremony. "Access to clean water is a fundamental right, and this project brings us closer to ensuring that all our citizens enjoy this basic necessity."</p><p>The water supply system will be managed by the Micheweni Water Authority, which has hired and trained local residents to operate and maintain the facilities.</p>',
                'category_id' => $categories->where('slug', 'development')->first()->id,
                'published_at' => now()->subDays(5),
                'status' => 'published',
                'views' => rand(50, 500),
                'is_featured' => true
            ],
            [
                'title' => 'Annual Cultural Festival to be Held Next Month',
                'slug' => 'annual-cultural-festival-next-month',
                'excerpt' => 'The annual Micheweni Cultural Festival will take place from July 15-18, featuring traditional dances, music, and arts.',
                'content' => '<p>The annual Micheweni Cultural Festival is set to take place from July 15-18, 2023, at the Micheweni Community Grounds. The festival will showcase the rich cultural heritage of Micheweni District through traditional dances, music performances, arts and crafts exhibitions, and culinary displays.</p><p>This year\'s theme is "Celebrating Our Roots, Embracing Our Future," which aims to highlight the importance of preserving cultural traditions while embracing progress and innovation.</p><p>"The Cultural Festival is an important event for our community," said the Director of Culture and Tourism. "It not only celebrates our heritage but also promotes tourism and provides economic opportunities for local artisans and vendors."</p><p>The festival is expected to attract thousands of visitors from across the region and beyond. Admission is free for all residents of Micheweni District, with a nominal fee for visitors from outside the district.</p>',
                'category_id' => $categories->where('slug', 'events')->first()->id,
                'published_at' => now()->subDays(7),
                'status' => 'published',
                'views' => rand(50, 500),
                'is_featured' => true
            ],
            [
                'title' => 'New Road Construction Project Begins',
                'slug' => 'new-road-construction-project-begins',
                'excerpt' => 'A major road construction project has begun in Micheweni District, aimed at improving transportation infrastructure.',
                'content' => '<p>A major road construction project has commenced in Micheweni District, aimed at improving transportation infrastructure and connectivity between communities. The project includes the construction of 35 kilometers of paved roads, bridges, and drainage systems.</p><p>The initiative, funded by the central government and international development partners, is expected to be completed within 18 months and will create hundreds of jobs for local residents during the construction phase.</p><p>"This project will significantly reduce travel times, enhance safety, and stimulate economic activities by improving access to markets and services," said the District Engineer. "We ask for patience from residents during the construction period as there may be temporary disruptions to traffic flow."</p><p>The roads have been designed with climate resilience in mind, incorporating features to withstand heavy rainfall and prevent flooding. The project also includes the installation of street lighting, road signs, and pedestrian walkways to enhance safety for all road users.</p>',
                'category_id' => $categories->where('slug', 'development')->first()->id,
                'published_at' => now()->subDays(10),
                'status' => 'published',
                'views' => rand(50, 500),
                'is_featured' => true
            ],
        ];
        
        foreach ($news as $article) {
            News::create($article);
        }
    }
    
    /**
     * Create announcements data.
     *
     * @return void
     */
    private function createAnnouncements()
    {
        $announcements = [
            [
                'title' => 'Public Health Notice',
                'content' => 'Due to recent weather conditions, residents are advised to boil drinking water as a precautionary measure. This advisory will remain in effect until further notice.',
                'is_urgent' => true,
                'publish_date' => now()->subDays(2),
                'expiry_date' => now()->addDays(10),
                'status' => 'active'
            ],
            [
                'title' => 'Town Hall Meeting',
                'content' => 'All residents are invited to attend the quarterly Town Hall Meeting on June 20, 2023, at 3:00 PM. The meeting will address community concerns and upcoming projects.',
                'is_urgent' => false,
                'publish_date' => now()->subDays(5),
                'expiry_date' => now()->addDays(15),
                'status' => 'active'
            ],
            [
                'title' => 'Road Closure Notice',
                'content' => 'Main Street will be closed for repairs from June 15-20, 2023. Please use alternative routes during this period. We apologize for any inconvenience.',
                'is_urgent' => true,
                'publish_date' => now()->subDays(3),
                'expiry_date' => now()->addDays(20),
                'status' => 'active'
            ],
            [
                'title' => 'Business Permit Deadline Extension',
                'content' => 'The deadline for business permit renewals has been extended to June 30, 2023. Please visit the District Office to complete your renewal.',
                'is_urgent' => false,
                'publish_date' => now()->subDays(10),
                'expiry_date' => now()->addDays(30),
                'status' => 'active'
            ],
            [
                'title' => 'Vaccination Campaign',
                'content' => 'A free vaccination campaign for children under 5 years will be conducted at all health centers from June 25-30, 2023. Please bring your child\'s health card.',
                'is_urgent' => true,
                'publish_date' => now()->subDays(1),
                'expiry_date' => now()->addDays(25),
                'status' => 'active'
            ],
        ];
        
        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
    
    /**
     * Create testimonials data.
     *
     * @return void
     */
    private function createTestimonials()
    {
        $services = Service::all();
        
        $testimonials = [
            [
                'name' => 'Ibrahim Hassan',
                'position' => 'Local Business Owner',
                'content' => 'The new online permit application system has made it so much easier to apply for business permits. I was able to complete the entire process from home!',
                'rating' => 5,
                'service_id' => $services->where('slug', 'business-permits')->first()->id,
                'status' => 'active'
            ],
            [
                'name' => 'Fatma Omar',
                'position' => 'Resident',
                'content' => 'The waste management services have greatly improved in our neighborhood. The regular collection and recycling initiatives are making our community cleaner.',
                'rating' => 4,
                'service_id' => $services->where('slug', 'waste-management')->first()->id,
                'status' => 'active'
            ],
            [
                'name' => 'Ali Mohammed',
                'position' => 'Community Leader',
                'content' => 'I appreciate how transparent the government has become with their projects. The regular updates and community involvement have built trust in our local leadership.',
                'rating' => 5,
                'service_id' => null,
                'status' => 'active'
            ],
        ];
        
        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
    
    /**
     * Create statistics data.
     *
     * @return void
     */
    private function createStatistics()
    {
        $statistics = [
            [
                'key' => 'population',
                'value' => 95000,
                'label' => 'Population',
                'icon' => 'fa-users',
                'category' => 'demographics',
                'is_featured' => true
            ],
            [
                'key' => 'businesses',
                'value' => 250,
                'label' => 'Businesses',
                'icon' => 'fa-building',
                'category' => 'economy',
                'is_featured' => true
            ],
            [
                'key' => 'schools',
                'value' => 45,
                'label' => 'Schools',
                'icon' => 'fa-school',
                'category' => 'education',
                'is_featured' => true
            ],
            [
                'key' => 'health_centers',
                'value' => 12,
                'label' => 'Health Centers',
                'icon' => 'fa-hospital',
                'category' => 'healthcare',
                'is_featured' => true
            ],
            [
                'key' => 'roads_km',
                'value' => 350,
                'label' => 'Roads (km)',
                'icon' => 'fa-road',
                'category' => 'infrastructure',
                'is_featured' => false
            ],
            [
                'key' => 'annual_budget',
                'value' => 5000000,
                'label' => 'Annual Budget (USD)',
                'icon' => 'fa-money-bill',
                'category' => 'finance',
                'is_featured' => false
            ],
        ];
        
        foreach ($statistics as $statistic) {
            Statistics::create($statistic);
        }
    }
} 