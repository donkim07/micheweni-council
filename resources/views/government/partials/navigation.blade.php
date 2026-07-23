<style>
/* Remove dropdown arrows */
.navbar-nav .dropdown-toggle::after {
    display: none !important;
}

/* Logo container */
.logo-container {
    display: flex;
    align-items: center;
}

.coat-of-arms {
    height: 50px;
    margin-right: 15px;
}

/* Dropdown submenu styles */
.dropdown-submenu {
    position: absolute;
    left: 100%;
    top: 0;
    display: none;
}

.dropend:hover > .dropdown-submenu {
    display: block;
}

/* Reduce font size for Swahili language */
html[lang="sw"] .navbar-main .nav-link {
    font-size: 0.85rem;
    padding: 1rem 0.9rem;
}

html[lang="sw"] .navbar-main .nav-link i {
    font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 1199px) and (min-width: 992px) {
    .navbar-main .nav-link {
        font-size: 0.9rem;
        padding: 1rem 0.7rem;
    }
    
    html[lang="sw"] .navbar-main .nav-link {
        font-size: 0.8rem;
        padding: 1rem 0.6rem;
    }
}

@media (max-width: 991px) {
    .dropdown-submenu {
        position: static;
        margin-left: 1rem;
    }
}

/* Fix for navbar dropdowns */
.navbar .dropdown-menu {
    z-index: 1050 !important; /* Higher z-index to ensure dropdowns appear above other content */
}

/* Ensure dropdowns are visible on detail pages */
/* .navbar .nav-item.dropdown:hover .dropdown-menu, */
.navbar .nav-item.dropdown:focus-within .dropdown-menu {
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) !important;
    pointer-events: auto !important;
}

/* Fix for breadcrumb pages */
.breadcrumb-container {
    position: relative;
    z-index: 1; /* Lower than dropdown z-index */
}
</style>

<nav class="navbar navbar-expand-lg navbar-main" role="navigation" aria-label="Main Navigation">
    <div class="container">
        <!-- Mobile Logo -->
        <!-- <a class="navbar-brand d-lg-none" href="{{ url('/government') }}">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Micheweni-Portal Pemba') }}" height="40" class="d-inline-block align-text-top">
        </a> -->
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#governmentNavbar" aria-controls="governmentNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="governmentNavbar">
            <ul class="navbar-nav mx-auto">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('government') ? 'active' : '' }}" href="{{ url('/government') }}" aria-current="{{ request()->is('government') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-home me-1" aria-hidden="true"></i> <span>Home</span></span>
                    </a>
                </li>
                
                <!-- About Us Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('government/about*') ? 'active' : '' }}" href="{{ url('/government/about') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('government/about*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-info-circle me-1" aria-hidden="true"></i> <span>About Us</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="About Us submenu">
                        <li><a class="dropdown-item" href="{{ url('/government/about') }}">Overview</a></li>
                        <li><a class="dropdown-item" href="{{ url('/government/about/history') }}">History</a></li>
                        <li><a class="dropdown-item" href="{{ url('/government/about/leadership') }}">Leadership</a></li>
                        <li><a class="dropdown-item" href="{{ url('/government/about/mission-vision') }}">Mission & Vision</a></li>
                        <li><a class="dropdown-item" href="{{ url('/government/about/organizational-structure') }}">Organization Structure</a></li>
                    </ul>
                </li>
                
                <!-- Departments -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('government/departments*') ? 'active' : '' }}" href="{{ url('/government/departments') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('government/departments*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-building me-1" aria-hidden="true"></i> <span>Departments</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="Departments submenu">
                        <li><a class="dropdown-item" href="{{ url('/government/departments') }}">All Departments</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @php
                            $departmentsList = \App\Models\Government\Department::active()->orderBy('order')->take(8)->get();
                        @endphp
                        @foreach($departmentsList as $dept)
                            <li><a class="dropdown-item" href="{{ url('/government/departments/' . $dept->slug) }}">{{ $dept->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                
                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('services*') ? 'active' : '' }}" href="{{ url('government/services') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('services*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-hands-helping me-1" aria-hidden="true"></i> <span>Services</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="Services submenu">
                        <li><a class="dropdown-item" href="{{ url('government/services') }}">All Services</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @php
                            $servicesDepartments = \App\Models\Government\Department::has('services')->take(5)->get();
                        @endphp
                        @foreach($servicesDepartments as $dept)
                            <li><a class="dropdown-item" href="{{ url('government/services?department=' . $dept->id) }}">{{ $dept->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                
                <!-- Projects Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('projects*') ? 'active' : '' }}" href="{{ url('government/projects') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('projects*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-project-diagram me-1" aria-hidden="true"></i> <span>Projects</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="Projects submenu">
                        <li><a class="dropdown-item" href="{{ url('government/projects') }}">All Projects</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @php
                            $projectCategories = \App\Models\Government\ProjectCategory::has('projects')->take(5)->get();
                        @endphp
                        @foreach($projectCategories as $cat)
                            <li><a class="dropdown-item" href="{{ url('government/projects?category=' . $cat->id) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                
                
                <!-- Opportunities -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('opportunities*') ? 'active' : '' }}" href="{{ route('opportunities.index') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('opportunities*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-briefcase me-1" aria-hidden="true"></i> <span>Opportunities</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="Opportunities submenu">
                        <li><a class="dropdown-item" href="{{ route('opportunities.index') }}">Explore All Opportunities</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ url('opportunities/circular-economy') }}">Circular Economy</a></li>
                        <li class="dropend">
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('opportunities.circular-economy.waste.map') }}" aria-haspopup="true" aria-expanded="false">
                                Waste Management
                                <i class="fas fa-chevron-right ms-2 small" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-submenu animate__animated animate__fadeIn" aria-label="Waste Management submenu">
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.map') }}">Waste Map</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.collection') }}">Collection Services</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.recycling') }}">Recycling Programs</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.marketplace') }}">Waste Marketplace</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.waste.directory') }}">Service Directory</a></li>
                                <li><a class="dropdown-item" href="{{ route('opportunities.circular-economy.assessment.index') }}">Assessments</a></li>
                            </ul>
                        </li>
                         </ul>
                </li>
                
                <!-- News & Media -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('government/news*') || request()->is('government/media*') ? 'active' : '' }}" href="{{ url('/government/news-new') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('government/news*') || request()->is('government/media*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-newspaper me-1" aria-hidden="true"></i> <span>News & Media</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="News and Media submenu">
                        <li><a class="dropdown-item" href="{{ route('government.news.index') }}">Latest News</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.news.index') }}?category=announcements">Announcements</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.news.index') }}?category=press-releases">Press Releases</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.media.gallery') }}">Photo Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.media.videos') }}">Video Gallery</a></li>
                    </ul>
                </li>
                
                <!-- Publications -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('government/publications*') ? 'active' : '' }}" href="{{ url('/government/publications') }}" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" aria-current="{{ request()->is('government/publications*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-file-alt me-1" aria-hidden="true"></i> <span>Publications</span></span>
                    </a>
                    <ul class="dropdown-menu animate__animated animate__fadeIn" aria-label="Publications submenu">
                        <li><a class="dropdown-item" href="{{ route('government.publications.index') }}">All Publications</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('government.publications.index') }}?category=reports">Reports</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.publications.index') }}?category=policies">Policies</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.publications.index') }}?category=guidelines">Guidelines</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.publications.index') }}?category=forms">Forms</a></li>
                        <li><a class="dropdown-item" href="{{ route('government.publications.index') }}?category=newsletters">Newsletters</a></li>
                    </ul>
                </li>
                
                <!-- Contact Us -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('government/contact*') ? 'active' : '' }}" href="{{ url('/government/contact') }}" aria-current="{{ request()->is('government/contact*') ? 'page' : 'false' }}">
                        <span class="d-flex align-items-center"><i class="fas fa-envelope me-1" aria-hidden="true"></i> <span>Contact</span></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
// Fix for navbar dropdowns
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle dropdown behavior
    function setupDropdowns() {
        const dropdownItems = document.querySelectorAll('.navbar .nav-item.dropdown');
        
        dropdownItems.forEach(item => {
            // Show dropdown on hover
            item.addEventListener('mouseenter', function() {
                this.querySelector('.dropdown-menu').classList.add('show');
            });
            
            // Hide dropdown when mouse leaves
            item.addEventListener('mouseleave', function() {
                this.querySelector('.dropdown-menu').classList.remove('show');
            });
            
            // Handle click for touch devices
            const dropdownToggle = item.querySelector('.dropdown-toggle');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    // Check if we're on a touch device
                    if ('ontouchstart' in window) {
                        e.preventDefault();
                        const menu = this.nextElementSibling;
                        
                        // Close all other dropdowns
                        document.querySelectorAll('.navbar .dropdown-menu.show').forEach(openMenu => {
                            if (openMenu !== menu) {
                                openMenu.classList.remove('show');
                            }
                        });
                        
                        // Toggle this dropdown
                        menu.classList.toggle('show');
                    }
                });
            }
        });
    }
    
    // Initial setup
    setupDropdowns();
    
    // Setup again after any AJAX content loads
    document.addEventListener('DOMContentLoaded', setupDropdowns);
});
</script>