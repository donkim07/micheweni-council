<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.government.dashboard') }}" class="brand-link">
        <img src="{{ asset('adminlte/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                
                <li class="nav-header">{{ __('USER MANAGEMENT') }}</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>{{ __('Users') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>{{ __('Roles') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-key"></i>
                        <p>{{ __('Permissions') }}</p>
                    </a>
                </li>
                
                <!-- Portal Management Section -->
                <li class="nav-header">{{ __('PORTAL MANAGEMENT') }}</li>
                
                <!-- Government Portal dropdown -->
                <li class="nav-item has-treeview {{ request()->is('admin/government*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/government*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-landmark"></i>
                        <p>
                            {{ __('Government Portal') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: {{ request()->is('admin/government*') ? 'block' : 'none' }};">
                        <li class="nav-item">
                            <a href="{{ route('admin.government.dashboard') }}" class="nav-link {{ request()->routeIs('admin.government.dashboard') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.departments.index') }}" class="nav-link {{ request()->routeIs('admin.government.departments.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Departments') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.services.index') }}" class="nav-link {{ request()->routeIs('admin.government.services.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Services') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.project-categories.index') }}" class="nav-link {{ request()->routeIs('admin.government.project-categories.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Project Categories') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.projects.index') }}" class="nav-link {{ request()->routeIs('admin.government.projects.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Projects') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.news-categories.index') }}" class="nav-link {{ request()->routeIs('admin.government.news-categories.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('News Categories') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.news-tags.index') }}" class="nav-link {{ request()->routeIs('admin.government.news-tags.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('News Tags') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.news.index') }}" class="nav-link {{ request()->routeIs('admin.government.news.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('News') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.government.announcements.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Announcements') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.statistics.index') }}" class="nav-link {{ request()->routeIs('admin.government.statistics.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Statistics') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.government.testimonials.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Testimonials') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.publications.index') }}" class="nav-link {{ request()->routeIs('admin.government.publications.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Publications') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.government.media.index') }}" class="nav-link {{ request()->routeIs('admin.government.media.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Media Gallery') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Waste Management dropdown -->
                <li class="nav-item has-treeview {{ request()->is('admin/waste*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/waste*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trash"></i>
                        <p>
                            {{ __('Waste Management') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: {{ request()->is('admin/waste*') ? 'block' : 'none' }};">
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.dashboard') }}" class="nav-link {{ request()->routeIs('admin.waste.dashboard') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.categories.index') }}" class="nav-link {{ request()->routeIs('admin.waste.categories.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Waste Categories') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.items.index') }}" class="nav-link {{ request()->routeIs('admin.waste.items.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Waste Items') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.facilities.index') }}" class="nav-link {{ request()->routeIs('admin.waste.facilities.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Facilities') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.collections.index') }}" class="nav-link {{ request()->routeIs('admin.waste.collections.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Collections') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.reports.index') }}" class="nav-link {{ request()->routeIs('admin.waste.reports.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Reports') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.waste.education.index') }}" class="nav-link {{ request()->routeIs('admin.waste.education.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Education') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-header">{{ __('SYSTEM') }}</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>{{ __('Settings') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logs') }}" class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>{{ __('Logs') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>{{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside> 