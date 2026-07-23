<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Micheweni Waste Portal') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery Core - Moved to header to ensure it's loaded first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery UI with correct sequence -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle with Popper - Loading here to ensure it's available for all pages -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Animation Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-table-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-mobile.css') }}?v={{ time() }}">
    
    <!-- Emergency sidebar fix for mobile -->
    <style>
        @media (max-width: 991.98px) {
            /* Reset and enforce sidebar visibility when open */
            body.sidebar-open #sidebar-wrapper {
                left: 0 !important;
                transform: none !important; 
                visibility: visible !important;
                opacity: 1 !important;
                display: block !important;
                width: var(--sidebar-width, 280px) !important;
                z-index: 99999 !important;
                position: fixed !important;
                top: 0 !important;
                height: 100vh !important;
            }
            
            /* Ensure the sidebar is initially hidden off-screen */
            #sidebar-wrapper {
                position: fixed !important;
                left: -280px !important;
                transition: all 0.3s ease !important;
                display: block !important;
            }
            
            /* Apply a semi-transparent overlay when sidebar is open */
            .sidebar-overlay {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                background-color: rgba(0, 0, 0, 0.5) !important;
                display: none !important;
                z-index: 9999 !important;
                opacity: 0;
                transition: opacity 0.3s ease !important;
            }
            
            body.sidebar-open .sidebar-overlay {
                display: block !important;
                opacity: 1 !important;
            }
        }
    </style>

    <!-- Google Translate CSS Fixes -->
    <style>
        /* Fix body positioning overrides by Google Translate */
        body {
            top: 0px !important;
            padding-top: 0 !important;
        }
        
        /* Hide Google Translate Banner */
        .goog-te-banner-frame {
            display: none !important;
        }
        
        .skiptranslate > iframe {
            height: 0 !important;
            border-style: none !important;
            box-shadow: none !important;
        }
    </style>
    
    <!-- Responsive logo styles -->
    <style>
        .logo-img {
            max-height: 60px;
            width: auto;
        }
        
        .admin-header-title {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .logo-img {
                max-height: 50px;
            }
            .admin-header-title {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 576px) {
            .logo-img {
                max-height: 40px;
            }
            .admin-header-title {
                font-size: 1rem;
            }
        }
    </style>

    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #148f77;
            --accent: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #1a252f;
            --sidebar-width: 280px;
            --header-height: 70px;
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed) ease;
            z-index: 999;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        #sidebar-wrapper::-webkit-scrollbar {
            width: 5px;
        }

        #sidebar-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        #page-content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all var(--transition-speed) ease;
            width: calc(100% - var(--sidebar-width));
        }

        .wrapper.toggled #sidebar-wrapper {
            margin-left: calc(-1 * var(--sidebar-width));
            transform: translateX(-100%);
        }

        .wrapper.toggled #page-content-wrapper {
            margin-left: 0;
            width: 100%;
        }

        .sidebar-heading {
            padding: 1.5rem;
        }
        
        .sidebar-section-heading {
            font-size: 0.75rem;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        .list-group-item {
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            margin: 0.3rem 1rem;
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            transform: translateX(5px);
        }

        .list-group-item.active {
            background: var(--secondary) !important;
            box-shadow: 0 5px 15px rgba(20, 143, 119, 0.4);
        }

        .bg-transparent {
            background-color: transparent !important;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            height: var(--header-height);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            animation: fadeInDown 0.3s ease;
            z-index: 1050;
        }

        .dropdown-item {
            padding: 0.8rem 1.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--accent);
            transform: translateX(5px);
        }

        .alert {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .alert-dismissible {
            padding-right: 1.25rem;
        }

        .btn-close {
            box-shadow: none;
        }

        .main-content {
            padding: 2rem;
        }

        /* Custom Sections */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .section-heading {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .section-heading:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 60px;
            background: var(--secondary);
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary), var(--accent));
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent), var(--secondary));
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
            transform: translateY(-2px);
        }

        .app-logo {
            max-height: 60px;
            margin-bottom: 8px;
            width: auto;
            display: block;
            margin: 0 auto;
        }
        
        @media (max-width: 768px) {
            .app-logo {
                max-height: 50px;
            }
        }
        
        @media (max-width: 576px) {
            .app-logo {
                max-height: 40px;
            }
        }

        /* Sidebar dropdown styles */
        .sidebar-dropdown {
            position: relative;
        }
        
        .sidebar-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }
        
        .sidebar-dropdown-toggle .fa-chevron-down {
            transition: transform 0.3s ease;
        }
        
        .sidebar-dropdown-toggle.active .fa-chevron-down {
            transform: rotate(180deg);
        }
        
        .sidebar-submenu {
            padding-left: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-submenu .list-group-item {
            padding-left: 2rem;
        }

        /* Fixing modal issues */
        .modal {
            z-index: 10000 !important;
        }
        
        .modal-backdrop {
            z-index: 9999 !important;
        }
        
        .ui-dialog {
            z-index: 10001 !important;
        }
        
        .ui-widget-overlay {
            z-index: 9998 !important;
        }
        
        /* Fix draggable and sortable z-index issues */
        .ui-draggable-dragging, 
        .ui-sortable-helper {
            z-index: 10002 !important;
        }
        
        /* Add proper modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
        }
        
        .modal-backdrop.show {
            display: block;
        }
        
        /* Additional fixes for jQuery UI conflicts */
        .ui-front {
            z-index: 10000 !important;
        }

        /* Language Switcher Styles */
        .language-switcher .dropdown-toggle {
            color: #6c757d;
            background-color: transparent;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.3rem 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .custom-dropdown-toggle {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-dropdown-toggle:hover {
            opacity: 0.85;
        }

        .custom-dropdown-menu {
            position: absolute;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            min-width: 10rem;
            z-index: 1050;
        }

        .dropdown-menu-end.custom-dropdown-menu {
            right: 0;
            left: auto;
        }

        @media (max-width: 992px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            #page-content-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            #wrapper.show-sidebar #sidebar-wrapper {
                margin-left: 0;
            }
            
            #wrapper.show-sidebar #page-content-wrapper {
                margin-left: var(--sidebar-width);
            }
        }
    </style>

    @yield('styles')
</head>
<body data-route="{{ Route::currentRouteName() }}">
    <div class="wrapper d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="animate__animated animate__faster" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 text-white border-bottom">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="app-logo img-fluid">
                <div class="fs-4 fw-bold admin-header-title">Micheweni Admin</div>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="{{ route('admin.government.dashboard') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Route::currentRouteName() == 'admin.government.dashboard' ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-3"></i><span>{{ __('admin.dashboard') }}</span>
                </a>
        
                <!-- Government Section -->
                <div class="sidebar-dropdown">
                    <a href="#" class="list-group-item list-group-item-action bg-transparent text-white sidebar-dropdown-toggle {{ Str::startsWith(Route::currentRouteName(), 'admin.government.') && !Str::startsWith(Route::currentRouteName(), 'admin.government.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-landmark me-3"></i>
                        <span>{{ __('admin.government_portal') }}</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="sidebar-submenu">
                        <a href="{{ route('admin.government.departments.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.departments') ? 'active' : '' }}">
                            <i class="fas fa-building me-3"></i><span>{{ __('admin.departments') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.government.services.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.services') ? 'active' : '' }}">
                            <i class="fas fa-hands-helping me-3"></i><span>{{ __('admin.services') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.government.projects.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.projects') ? 'active' : '' }}">
                            <i class="fas fa-project-diagram me-3"></i><span>{{ __('admin.projects') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.government.news.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.news') ? 'active' : '' }}">
                            <i class="fas fa-newspaper me-3"></i><span>{{ __('admin.news') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.government.publications.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.publications') ? 'active' : '' }}">
                            <i class="fas fa-file-pdf me-3"></i><span>{{ __('admin.publications') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.government.media.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.media') ? 'active' : '' }}">
                            <i class="fas fa-photo-video me-3"></i><span>{{ __('admin.media_gallery') }}</span>
                        </a>
                        
                        <a href="{{ route('admin.government.announcements.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.government.announcements') ? 'active' : '' }}">
                            <i class="fas fa-bullhorn me-3"></i><span>{{ __('admin.announcements') }}</span>
                        </a>
                    </div>
                </div>
                
                <!-- Waste Management Section -->
                            <div class="sidebar-dropdown">
                <a href="#" class="list-group-item list-group-item-action bg-transparent text-white sidebar-dropdown-toggle {{ (Str::startsWith(Route::currentRouteName(), 'admin.') && !Str::startsWith(Route::currentRouteName(), 'admin.government.')) || Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                    <i class="fas fa-recycle me-3"></i>
                    <span>{{ __('Waste Management') }}</span>
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="sidebar-submenu">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-3"></i><span>{{ __('Waste Dashboard') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.pages.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.pages') && !Str::startsWith(Route::currentRouteName(), 'admin.government') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-3"></i><span>{{ __('Pages') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.contents.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.contents') ? 'active' : '' }}">
                        <i class="fas fa-th-large me-3"></i><span>{{ __('Content Blocks') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.news.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.news') && !Str::startsWith(Route::currentRouteName(), 'admin.government') ? 'active' : '' }}">
                        <i class="fas fa-newspaper me-3"></i><span>{{ __('News') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.categories') ? 'active' : '' }}">
                        <i class="fas fa-tags me-3"></i><span>{{ __('Categories') }}</span>
                    </a>
                    
                    <a href="{{ route('admin.waste-locations.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.waste-locations') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt me-3"></i><span>{{ __('Waste Locations') }}</span>
                    </a>
                </div>
            </div>  
                
                <!-- System Management -->
                <div class="sidebar-section-heading text-white px-3 pt-4 pb-2">
                    <span class="text-uppercase fw-bold small">{{ __('System Management') }}</span>
                </div>
                
                <a href="{{ route('admin.form-builders.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.form-builders') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list me-3"></i><span>{{ __('Form Builders') }}</span>
                </a>
                
                <a href="{{ route('admin.form-submissions.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.form-submissions') ? 'active' : '' }}">
                    <i class="fas fa-database me-3"></i><span>{{ __('Form Submissions') }}</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users me-3"></i><span>{{ __('Users') }}</span>
                </a>
                
                <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.roles') ? 'active' : '' }}">
                    <i class="fas fa-user-tag me-3"></i><span>{{ __('Roles') }}</span>
                </a>
                
                <a href="{{ route('admin.permissions.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ Str::startsWith(Route::currentRouteName(), 'admin.permissions') ? 'active' : '' }}">
                    <i class="fas fa-lock me-3"></i><span>{{ __('Permissions') }}</span>
                </a>
                
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action bg-transparent text-white">
                    <i class="fas fa-arrow-left me-3"></i><span>{{ __('Back to Site') }}</span>
                </a>
            </div>
        </div>
        <!-- End of Sidebar -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="btn btn-light" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Hide the default navbar-toggler on mobile -->
                    <button class="navbar-toggler d-lg-none d-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <!-- Profile image visible on all screen sizes, acts as dropdown toggle on mobile -->
                    <div class="ms-auto d-lg-none mobile-profile-toggle">
                        <div class="dropdown">
                            <a class="custom-dropdown-toggle nav-profile-button d-flex align-items-center" href="#" role="button">
                                <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </a>
                            <!-- Mobile dropdown menu -->
                            <div class="custom-dropdown-menu dropdown-menu-end">
                                <!-- Language options with Google Translate -->
                                <div class="px-3 py-2 border-bottom">
                                    <small class="text-muted">{{ __('Language') }}</small>
                                    <div class="d-flex gap-2 my-2">
                                        <button onclick="changeLanguage('en')" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-secondary' }} flex-grow-1">
                                            <span class="me-1">🇬🇧</span> EN
                                        </button>
                                        <button onclick="changeLanguage('sw')" class="btn btn-sm {{ app()->getLocale() == 'sw' ? 'btn-primary' : 'btn-outline-secondary' }} flex-grow-1">
                                            <span class="me-1">🇹🇿</span> SW
                                        </button>
                                    </div>
                                </div>
                                <!-- User profile options -->
                                <a class="dropdown-item py-2" href="{{ route('admin.profile.edit') }}">
                                    <i class="fas fa-user me-2"></i> {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item py-2" href="#">
                                    <i class="fas fa-cog me-2"></i> {{ __('admin.settings') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2" href="{{ route('home') }}">
                                    <i class="fas fa-arrow-left me-2"></i> {{ __('Back to Site') }}
                                </a>
                                <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('admin.logout') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <!-- Language Switcher with Google Translate -->
                            <li class="nav-item dropdown me-3">
                                <div class="dropdown">
                                    <a class="custom-dropdown-toggle d-flex align-items-center" href="#" role="button">
                                        <div class="language-switcher">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-globe me-1"></i>
                                                <span id="current-language-display" class="me-1">{{ strtoupper(app()->getLocale()) }}</span>
                                                <i class="fas fa-chevron-down fa-sm"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="custom-dropdown-menu dropdown-menu-end p-2">
                                        <div class="mb-2">
                                            <button onclick="changeLanguage('en')" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-primary' : 'btn-outline-secondary' }} w-100 mb-1">
                                                <span class="me-2">🇬🇧</span> English
                                            </button>
                                            <button onclick="changeLanguage('sw')" class="btn btn-sm {{ app()->getLocale() == 'sw' ? 'btn-primary' : 'btn-outline-secondary' }} w-100">
                                                <span class="me-2">🇹🇿</span> Swahili
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- User Profile - hidden on mobile since we have the mobile version above -->
                            <li class="nav-item dropdown d-none d-lg-block">
                                <div class="dropdown">
                                    <a class="custom-dropdown-toggle nav-profile-button d-flex align-items-center" href="#" role="button">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <div class="d-none d-md-block">
                                                <div class="fw-semibold text-dark">{{ Auth::user()->name }}</div>
                                                <div class="small text-muted">{{ Auth::user()->roles->first()->name ?? 'User' }}</div>
                                            </div>
                                            <i class="fas fa-chevron-down ms-2 fa-sm text-muted"></i>
                                        </div>
                                    </a>
                                    <div class="custom-dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item py-2" href="{{ route('admin.profile.edit') }}">
                                            <i class="fas fa-user me-2"></i> {{ __('Profile') }}
                                        </a>
                                        <a class="dropdown-item py-2" href="#">
                                            <i class="fas fa-cog me-2"></i> {{ __('admin.settings') }}
                                        </a>
                                        <a class="dropdown-item py-2" href="{{ route('home') }}">
                                            <i class="fas fa-arrow-left me-2"></i> {{ __('Back to Site') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> {{ __('admin.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="container-fluid main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Hidden Google Translate Element -->
    <div id="google_translate_element" style="display:none;"></div>
    
    <!-- Google Translate Script -->
    <script type="text/javascript">
        var googleTranslateElementInit = function() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,sw',
                autoDisplay: false
            }, 'google_translate_element');
        };
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <script>
    function changeLanguage(lang) {
        localStorage.setItem('selectedLanguage', lang);

        if (lang === 'en') {
            // Aggressively delete all googtrans cookies
            ['','.' + window.location.hostname].forEach(domain => {
                document.cookie = 'googtrans=; Max-Age=0; path=/;';
                document.cookie = `googtrans=; Max-Age=0; path=/; domain=${domain};`;
            });

            console.log("Switched to EN - Cookies cleared");
        } else if (lang === 'sw') {
            document.cookie = 'googtrans=/en/sw; path=/;';
            document.cookie = `googtrans=/en/sw; path=/; domain=${window.location.hostname}`;
            console.log("Switched to SW - Cookie set");
        }

        // Reload once after language change
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const lang = localStorage.getItem('selectedLanguage') || 'en';
        const currentLangDisplay = document.getElementById('current-language-display');
        if (currentLangDisplay) currentLangDisplay.innerText = lang.toUpperCase();

        const cookieLang = getCookieValue('googtrans');
        console.log('LocalStorage:', lang, '| Cookie:', cookieLang);

        // Just log mismatch, no reload
        if (lang === 'en' && cookieLang && cookieLang !== '/en/en') {
            console.warn("Mismatch: Google cookie still says Swahili, but we're in EN. Manual reload will fix.");
        }
    });

    function getCookieValue(name) {
        const match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
        return match ? decodeURIComponent(match.pop()) : '';
    }

    // Optional debug tool
    function clearTranslation() {
        localStorage.removeItem('selectedLanguage');
        ['','.' + window.location.hostname].forEach(domain => {
            document.cookie = 'googtrans=; Max-Age=0; path=/;';
            document.cookie = `googtrans=; Max-Age=0; path=/; domain=${domain};`;
        });
        console.log("Cleared all translation cookies & localStorage.");
        location.reload();
    }
    </script>

    <!-- Admin Mobile JS -->
    <script src="{{ asset('js/admin-mobile.js') }}?v={{ time() }}"></script>
    
    <!-- Admin Responsive Tables JS -->
    <script src="{{ asset('js/admin-responsive-tables.js') }}?v={{ time() }}"></script>
    
    <!-- Debug script for sidebar -->
    <script>
        // Debug helper to check sidebar visibility issues
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar-wrapper');
            
            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function() {
                    // Log sidebar state after a short delay to let styles apply
                    setTimeout(function() {
                        const styles = window.getComputedStyle(sidebar);
                        console.log('Sidebar computed styles after toggle:');
                        console.log('- left:', styles.getPropertyValue('left'));
                        console.log('- visibility:', styles.getPropertyValue('visibility'));
                        console.log('- display:', styles.getPropertyValue('display'));
                        console.log('- z-index:', styles.getPropertyValue('z-index'));
                        console.log('- transform:', styles.getPropertyValue('transform'));
                        console.log('- opacity:', styles.getPropertyValue('opacity'));
                        console.log('- position:', styles.getPropertyValue('position'));
                    }, 100);
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html> 