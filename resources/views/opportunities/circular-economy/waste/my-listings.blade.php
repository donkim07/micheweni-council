<x-app-layout>
    <div class="py-5 bg-gradient-to-r from-green-800 to-green-600 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">{{ __('My Listings') }}</h1>
                    <p class="lead mb-4">{{ __('Manage your waste trading listings and track your sales activity.') }}</p>
                    
                    <div class="d-flex flex-wrap gap-3">
                        <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#createListingModal">
                            <i class="fas fa-plus-circle me-2"></i> {{ __('Create New Listing') }}
                        </button>
                        <a href="{{ route('opportunities.circular-economy.waste.marketplace') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-store me-2"></i> {{ __('Back to Marketplace') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <img src="{{ asset('images/my-listings.svg') }}" alt="My Listings" class="img-fluid rounded-3" onerror="this.src='https://placehold.co/600x400/198754/white?text=My+Listings'">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- My Listings Section -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('My Active Listings') }}</h5>
                <span class="badge bg-success">{{ $listings->where('is_available', true)->count() }} {{ __('Active') }}</span>
            </div>
            <div class="card-body p-0">
                @if($listings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Listing') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listings as $listing)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="listing-thumbnail me-3">
                                                <img src="{{ asset($listing->image ?? 'images/placeholder.jpg') }}" alt="{{ $listing->title }}" class="rounded" width="50" height="50" style="object-fit: cover;" onerror="this.src='https://placehold.co/50x50/198754/white?text=Listing'">
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $listing->title }}</div>
                                                <div class="small text-muted">{{ Str::limit($listing->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $listing->category }}</td>
                                    <td>{{ number_format($listing->price) }} TZS <span class="small text-muted">{{ $listing->price_unit }}</span></td>
                                    <td>
                                        @if($listing->is_available)
                                            <span class="badge bg-success">{{ __('Available') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('Unavailable') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $listing->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('opportunities.circular-economy.waste.show-listing', $listing->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('opportunities.circular-economy.waste.toggle-listing', $listing->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $listing->is_available ? 'warning' : 'success' }}">
                                                    <i class="fas fa-{{ $listing->is_available ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteListingModal" data-listing-id="{{ $listing->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-4 py-3">
                        {{ $listings->links() }}
                    </div>
                @else
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                        </div>
                        <h4>{{ __('No listings yet') }}</h4>
                        <p class="text-muted">{{ __('You haven\'t created any listings yet. Get started by creating your first listing.') }}</p>
                        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#createListingModal">
                            <i class="fas fa-plus-circle me-2"></i> {{ __('Create Listing') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Listing Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-success-light me-3">
                                <i class="fas fa-eye text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">{{ __('Total Views') }}</h6>
                                <h3 class="mb-0">{{ rand(10, 100) }}</h3>
                            </div>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-info-light me-3">
                                <i class="fas fa-comment-alt text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">{{ __('Inquiries') }}</h6>
                                <h3 class="mb-0">{{ rand(1, 20) }}</h3>
                            </div>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon bg-warning-light me-3">
                                <i class="fas fa-bookmark text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">{{ __('Saved by Others') }}</h6>
                                <h3 class="mb-0">{{ rand(0, 15) }}</h3>
                            </div>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Create Listing Modal -->
    <div class="modal fade" id="createListingModal" tabindex="-1" aria-labelledby="createListingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createListingModalLabel">{{ __('Create New Listing') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('opportunities.circular-economy.waste.store-listing') }}" method="POST" enctype="multipart/form-data" id="createListingForm">
                        @csrf
                        <div class="mb-3">
                            <label for="listingTitle" class="form-label">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="listingTitle" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingCategory" class="form-label">{{ __('Category') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="listingCategory" name="category" required>
                                <option value="">{{ __('Select a category') }}</option>
                                <option value="recyclable_materials">{{ __('Recyclable Materials') }}</option>
                                <option value="equipment_machinery">{{ __('Equipment & Machinery') }}</option>
                                <option value="collection_services">{{ __('Collection Services') }}</option>
                                <option value="consulting_services">{{ __('Consulting Services') }}</option>
                                <option value="training_education">{{ __('Training & Education') }}</option>
                                <option value="composting_services">{{ __('Composting Services') }}</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="listingPrice" class="form-label">{{ __('Price (TZS)') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="listingPrice" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="listingPriceUnit" class="form-label">{{ __('Price Unit') }}</label>
                                    <select class="form-select" id="listingPriceUnit" name="price_unit">
                                        <option value="per ton">{{ __('per ton') }}</option>
                                        <option value="per kg">{{ __('per kg') }}</option>
                                        <option value="for lot">{{ __('for lot') }}</option>
                                        <option value="per day">{{ __('per day') }}</option>
                                        <option value="per hour">{{ __('per hour') }}</option>
                                        <option value="monthly">{{ __('monthly') }}</option>
                                        <option value="per project">{{ __('per project') }}</option>
                                        <option value="negotiable">{{ __('negotiable') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingDescription" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="listingDescription" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingLocation" class="form-label">{{ __('Location') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="listingLocation" name="location" required>
                                <option value="Micheweni, Pemba">{{ __('Micheweni, Pemba') }}</option>
                                <option value="Chake Chake, Pemba">{{ __('Chake Chake, Pemba') }}</option>
                                <option value="Mkoani, Pemba">{{ __('Mkoani, Pemba') }}</option>
                                <option value="Zanzibar">{{ __('Zanzibar') }}</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="listingImage" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control" id="listingImage" name="image">
                            <div class="form-text">{{ __('Upload an image of your item or service (optional)') }}</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" form="createListingForm" class="btn btn-success">{{ __('Create Listing') }}</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .bg-success-light {
            background-color: rgba(25, 135, 84, 0.1);
        }
        
        .bg-info-light {
            background-color: rgba(13, 202, 240, 0.1);
        }
        
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }
        
        .empty-state {
            padding: 40px 20px;
        }
        
        .empty-icon {
            opacity: 0.5;
        }
    </style>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Submit form when create button is clicked
            document.querySelector('#createListingForm button[type="submit"]').addEventListener('click', function() {
                document.getElementById('createListingForm').submit();
            });
        });
    </script>
    @endpush
</x-app-layout> 