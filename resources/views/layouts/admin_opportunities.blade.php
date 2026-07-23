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
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-table-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-mobile.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="wrapper d-flex align-items-stretch" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    {{ config('app.name', 'Micheweni Admin') }}
                </a>
            </div>
            
            <!-- Sidebar Menu -->
            <div class="list-group list-group-flush my-3">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> {{ __('Dashboard') }}
                </a>
                
                <p class="sidebar-section-heading text-white ps-4 pt-4 pb-2 mb-0 text-uppercase">{{ __('Opportunities') }}</p>
                
                <a href="{{ route('admin.opportunities.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.opportunities.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase me-2"></i> {{ __('Opportunities') }}
                </a>
                
                <!-- Other menu items as needed -->
                
                <p class="sidebar-section-heading text-white ps-4 pt-4 pb-2 mb-0 text-uppercase">{{ __('Admin') }}</p>
                
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-user me-2"></i> {{ __('Users') }}
                </a>
                
                <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tag me-2"></i> {{ __('Roles') }}
                </a>
                
                <a href="{{ route('admin.permissions.index') }}" class="list-group-item list-group-item-action bg-transparent text-white {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                    <i class="fas fa-key me-2"></i> {{ __('Permissions') }}
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Mobile Overlay -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-bars primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">@yield('title', 'Dashboard')</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                        <i class="fas fa-user-cog me-2"></i>{{ __('Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Admin JS -->
    <script src="{{ asset('js/admin-mobile.js') }}"></script>
    <script src="{{ asset('js/admin-responsive-tables.js') }}"></script>
    
    <script>
        // Toggle sidebar
        document.getElementById('menu-toggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-open');
        });
        
        // Close sidebar when clicking overlay (mobile)
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.body.classList.remove('sidebar-open');
        });
    </script>
    
    @yield('scripts')
</body>
</html> 