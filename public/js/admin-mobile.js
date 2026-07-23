/**
 * Admin Mobile Functionality
 * Handles mobile sidebar and dropdown behavior
 */
document.addEventListener('DOMContentLoaded', function() {
    // Simple direct DOM manipulation for sidebar
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar-wrapper');
    const pageContent = document.getElementById('page-content-wrapper');
    const wrapper = document.getElementById('wrapper');
    
    // Create a sidebar overlay if it doesn't exist
    let sidebarOverlay = document.querySelector('.sidebar-overlay');
    if (!sidebarOverlay) {
        sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = 'sidebar-overlay';
        document.body.appendChild(sidebarOverlay);
    }
    
    // Disable the old mobile sidebar toggle function - we're using our direct fix now
    // The critical sidebar fix is now handled directly in admin.blade.php
    
    // Desktop sidebar toggle function
    function toggleSidebar() {
        // Desktop behavior only
        if (window.innerWidth >= 992) {
            wrapper.classList.toggle('toggled');
            localStorage.setItem('sidebarToggled', wrapper.classList.contains('toggled'));
        }
    }
    
    // DISABLED: Menu toggle click event now handled in admin.blade.php direct script
    // If there's no direct handler present in admin.blade.php, fall back to this one
    if (menuToggle && !menuToggle._hasDirectHandler) {
        menuToggle.addEventListener('click', function(e) {
            // This will be used only if the direct handler in admin.blade.php isn't working
            console.log('Using fallback sidebar toggle handler');
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar(); // Only use desktop behavior
        });
    }
    
    // Close sidebar when clicking on overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            document.body.classList.remove('sidebar-open');
            sidebar.style.left = '-280px';
            this.style.opacity = '0';
            
            setTimeout(() => {
                this.style.display = 'none';
            }, 300);
        });
    }
    
    // Initialize sidebar state for desktop
    const sidebarToggled = localStorage.getItem('sidebarToggled');
    if (sidebarToggled === 'true' && window.innerWidth >= 992) {
        wrapper.classList.add('toggled');
    } else {
        wrapper.classList.remove('toggled');
    }
    
    // Reset sidebar state on window resize
    window.addEventListener('resize', function() {
        const isMobile = window.innerWidth < 992;
        
        if (!isMobile && document.body.classList.contains('sidebar-open')) {
            // Switch from mobile to desktop view
            document.body.classList.remove('sidebar-open');
            sidebar.style.left = '';
            sidebar.style.transform = '';
            sidebarOverlay.style.display = 'none';
            sidebarOverlay.style.opacity = '0';
        }
    });
    
    // Fix for mobile navbar collapse
    const navbarToggler = document.querySelector('.navbar-toggler');
    const mobileProfileToggle = document.querySelector('.mobile-profile-toggle a');
    const navbarCollapse = document.querySelector('#navbarSupportedContent');
    
    if (mobileProfileToggle && navbarCollapse) {
        mobileProfileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            } else {
                navbarCollapse.classList.add('show');
            }
        });
        
        // Close navbar when clicking outside
        document.addEventListener('click', function(event) {
            const isNavbarOpen = navbarCollapse.classList.contains('show');
            const clickedInsideNavbar = navbarCollapse.contains(event.target);
            const clickedOnToggler = mobileProfileToggle.contains(event.target);
            
            if (isNavbarOpen && !clickedInsideNavbar && !clickedOnToggler) {
                navbarCollapse.classList.remove('show');
            }
        });
    }
    
    // Handle sidebar dropdowns
    const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');
    
    dropdownToggles.forEach(function(toggle) {
        const submenu = toggle.nextElementSibling;
        
        // Check if this dropdown should be active (has active child or is active itself)
        if (toggle.classList.contains('active') || (submenu && submenu.querySelector('.active'))) {
            toggle.classList.add('active');
            if (submenu) {
                submenu.style.display = 'block';
                submenu.style.maxHeight = submenu.scrollHeight + "px";
            }
        } else {
            toggle.classList.remove('active');
            if (submenu) {
                submenu.style.display = 'none';
                submenu.style.maxHeight = null;
            }
        }
        
        // Set up click handler
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const submenu = this.nextElementSibling;
            if (!submenu) return;
            
            // Toggle active class
            this.classList.toggle('active');
            
            // Toggle submenu with smooth animation
            if (submenu.style.display === 'block') {
                submenu.style.maxHeight = null;
                setTimeout(function() {
                    submenu.style.display = 'none';
                }, 200);
            } else {
                submenu.style.display = 'block';
                setTimeout(function() {
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                }, 10);
            }
        });
    });
    
    // Handle top navigation dropdowns
    const customDropdownToggles = document.querySelectorAll('.custom-dropdown-toggle');
    
    customDropdownToggles.forEach(function(toggle) {
        const dropdownMenu = toggle.nextElementSibling;
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Check if this is the mobile profile toggle
            const isMobileProfileToggle = toggle.closest('.mobile-profile-toggle');
            
            // Close all other dropdowns
            customDropdownToggles.forEach(function(otherToggle) {
                if (otherToggle !== toggle) {
                    const otherMenu = otherToggle.nextElementSibling;
                    if (otherMenu && otherMenu.classList.contains('show')) {
                        otherMenu.classList.remove('show');
                    }
                }
            });
            
            // Toggle this dropdown
            if (dropdownMenu) {
                dropdownMenu.classList.toggle('show');
                
                // Special handling for mobile profile dropdown
                if (isMobileProfileToggle) {
                    const navbar = document.querySelector('#navbarSupportedContent');
                    if (navbar && navbar.classList.contains('show')) {
                        navbar.classList.remove('show');
                    }
                }
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown') && !e.target.closest('.custom-dropdown-toggle')) {
            document.querySelectorAll('.custom-dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
}); 