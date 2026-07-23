<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Waste Service Directory') }}</h1>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="lead">{{ __('Directory of waste management service providers in Micheweni and surrounding areas.') }}</p>
                        
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search-directory" placeholder="{{ __('Search for services...') }}">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end mt-3 mt-md-0">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-outline-secondary active" data-filter="all">
                                                {{ __('All') }}
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" data-filter="collection">
                                                {{ __('Collection') }}
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" data-filter="recycling">
                                                {{ __('Recycling') }}
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" data-filter="disposal">
                                                {{ __('Disposal') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Collection Services -->
                            <div class="col-md-6 mb-4" data-category="collection">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Micheweni District Waste Service</h5>
                                        <span class="badge bg-primary mb-2">{{ __('Collection') }}</span>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i> Micheweni Town Center
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-phone text-secondary me-2"></i> +255 123 456 789
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-envelope text-secondary me-2"></i> waste@micheweni.gov.tz
                                        </div>
                                        
                                        <p class="card-text">
                                            {{ __('Official municipal waste collection service covering all areas of Micheweni town.') }}
                                        </p>
                                        
                                        <div class="mt-3">
                                            <a href="#" class="btn btn-sm btn-outline-primary">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4" data-category="collection">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Clean Pemba Waste Services</h5>
                                        <span class="badge bg-primary mb-2">{{ __('Collection') }}</span>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i> Eastern District, Micheweni
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-phone text-secondary me-2"></i> +255 987 654 321
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-envelope text-secondary me-2"></i> info@cleanpemba.co.tz
                                        </div>
                                        
                                        <p class="card-text">
                                            {{ __('Private waste collection service operating in eastern and northern districts.') }}
                                        </p>
                                        
                                        <div class="mt-3">
                                            <a href="#" class="btn btn-sm btn-outline-primary">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recycling Services -->
                            <div class="col-md-6 mb-4" data-category="recycling">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Green Island Recyclers</h5>
                                        <span class="badge bg-success mb-2">{{ __('Recycling') }}</span>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i> South Industrial Area, Micheweni
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-phone text-secondary me-2"></i> +255 765 432 109
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-envelope text-secondary me-2"></i> recycling@greenisland.co.tz
                                        </div>
                                        
                                        <p class="card-text">
                                            {{ __('Specializes in plastic, paper, and metal recycling. Offers collection services for large quantities.') }}
                                        </p>
                                        
                                        <div class="mt-3">
                                            <a href="#" class="btn btn-sm btn-outline-success">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4" data-category="recycling">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Pemba E-Waste Solutions</h5>
                                        <span class="badge bg-success mb-2">{{ __('Recycling') }}</span>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i> Central Market Area, Micheweni
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-phone text-secondary me-2"></i> +255 789 012 345
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-envelope text-secondary me-2"></i> info@pembaewaste.co.tz
                                        </div>
                                        
                                        <p class="card-text">
                                            {{ __('Specialized in electronic waste recycling and safe disposal of electronic components.') }}
                                        </p>
                                        
                                        <div class="mt-3">
                                            <a href="#" class="btn btn-sm btn-outline-success">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Disposal Services -->
                            <div class="col-md-6 mb-4" data-category="disposal">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Micheweni Landfill Management</h5>
                                        <span class="badge bg-danger mb-2">{{ __('Disposal') }}</span>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i> 5km South of Micheweni
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-phone text-secondary me-2"></i> +255 654 321 098
                                        </div>
                                        
                                        <div class="mb-3">
                                            <i class="fas fa-envelope text-secondary me-2"></i> landfill@micheweni.gov.tz
                                        </div>
                                        
                                        <p class="card-text">
                                            {{ __('Official municipal landfill facility for Micheweni district. Accepts commercial and residential waste.') }}
                                        </p>
                                        
                                        <div class="mt-3">
                                            <a href="#" class="btn btn-sm btn-outline-danger">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('search-directory');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const cards = document.querySelectorAll('[data-category]');
                
                cards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
            
            // Filter buttons
            const filterButtons = document.querySelectorAll('[data-filter]');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    const cards = document.querySelectorAll('[data-category]');
                    
                    cards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 