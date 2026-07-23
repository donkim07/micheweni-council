<x-app-layout>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Resources') }}</h1>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="lead mb-4">{{ __('Access educational resources and materials about waste management in Micheweni.') }}</p>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="search-resources" placeholder="{{ __('Search resources...') }}">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end">
                                    <div class="btn-group" role="group" aria-label="Resource type filter">
                                        <button type="button" class="btn btn-outline-primary active" data-filter="all">{{ __('All') }}</button>
                                        <button type="button" class="btn btn-outline-primary" data-filter="document">{{ __('Documents') }}</button>
                                        <button type="button" class="btn btn-outline-primary" data-filter="video">{{ __('Videos') }}</button>
                                        <button type="button" class="btn btn-outline-primary" data-filter="infographic">{{ __('Infographics') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row resource-grid">
                            <!-- Documents -->
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="document">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Waste Management Guidelines') }}</h5>
                                                <span class="badge bg-danger">{{ __('PDF') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Comprehensive guidelines for waste management practices in Micheweni municipality.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Size:') }} 2.5 MB</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="document">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-file-word fa-2x text-primary"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Waste Collection Schedule') }}</h5>
                                                <span class="badge bg-primary">{{ __('DOC') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Detailed schedule of waste collection services for all areas of Micheweni.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Size:') }} 1.2 MB</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="document">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Recycling Guide') }}</h5>
                                                <span class="badge bg-danger">{{ __('PDF') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Guide to recycling different types of materials in Micheweni.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Size:') }} 3.7 MB</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Videos -->
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="video">
                                <div class="card h-100">
                                    <img src="{{ asset('images/video-thumbnail-1.jpg') }}" class="card-img-top" alt="{{ __('Waste Sorting Tutorial') }}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-video fa-2x text-danger"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Waste Sorting Tutorial') }}</h5>
                                                <span class="badge bg-danger">{{ __('Video') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Step-by-step tutorial on how to properly sort different types of waste.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Duration:') }} 5:23</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-play me-1"></i> {{ __('Watch') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="video">
                                <div class="card h-100">
                                    <img src="{{ asset('images/video-thumbnail-2.jpg') }}" class="card-img-top" alt="{{ __('Composting at Home') }}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-video fa-2x text-danger"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Composting at Home') }}</h5>
                                                <span class="badge bg-danger">{{ __('Video') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Learn how to start composting organic waste at home with simple equipment.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Duration:') }} 8:47</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-play me-1"></i> {{ __('Watch') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Infographics -->
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="infographic">
                                <div class="card h-100">
                                    <img src="{{ asset('images/infographic-1.jpg') }}" class="card-img-top" alt="{{ __('Waste Reduction Tips') }}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-image fa-2x text-success"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Waste Reduction Tips') }}</h5>
                                                <span class="badge bg-success">{{ __('Infographic') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Visual guide with tips to reduce waste generation in daily life.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Size:') }} 1.8 MB</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="infographic">
                                <div class="card h-100">
                                    <img src="{{ asset('images/infographic-2.jpg') }}" class="card-img-top" alt="{{ __('Waste Management Cycle') }}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-image fa-2x text-success"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Waste Management Cycle') }}</h5>
                                                <span class="badge bg-success">{{ __('Infographic') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Visual representation of the complete waste management cycle in Micheweni.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Size:') }} 2.3 MB</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-6 mb-4 resource-item" data-type="infographic">
                                <div class="card h-100">
                                    <img src="{{ asset('images/infographic-3.jpg') }}" class="card-img-top" alt="{{ __('Waste Statistics') }}">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-image fa-2x text-success"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-0">{{ __('Waste Statistics') }}</h5>
                                                <span class="badge bg-success">{{ __('Infographic') }}</span>
                                            </div>
                                        </div>
                                        <p class="card-text">
                                            {{ __('Visual presentation of waste generation and management statistics in Micheweni.') }}
                                        </p>
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ __('Size:') }} 1.5 MB</small>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary">
                                {{ __('Load More Resources') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter resources by type
            const filterButtons = document.querySelectorAll('[data-filter]');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    const resourceItems = document.querySelectorAll('.resource-item');
                    
                    resourceItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-type') === filterValue) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
            
            // Search resources
            const searchInput = document.getElementById('search-resources');
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const resourceItems = document.querySelectorAll('.resource-item');
                
                resourceItems.forEach(item => {
                    const title = item.querySelector('h5').textContent.toLowerCase();
                    const description = item.querySelector('p').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 