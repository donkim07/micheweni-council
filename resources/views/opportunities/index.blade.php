@extends('opportunities.layouts.app')

@section('title', __('Opportunities'))

@section('content')
<div class="container py-5">
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <h1 class=" mb-4">{{ __('Opportunities') }}</h1>
            <p class="lead">{{ __('Explore various opportunities for business, collaboration, sustainability initiatives, and more.') }}</p>
        </div>
    </div>

    <!-- Featured Opportunities Section -->
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <h2 class="mb-4">{{ __('Featured Opportunities') }}</h2>
        </div>
        
        @php
            // Fetch featured opportunities from CMS
            try {
                $featuredOpportunities = \App\Models\Opportunities\CircularEconomy\Content::where('type', 'featured_opportunity')
                    ->where('is_active', true)
                    ->orderBy('order')
                    ->take(3)
                    ->get();
            } catch (\Exception $e) {
                $featuredOpportunities = collect([]);
            }
        @endphp
        
        @if($featuredOpportunities->isNotEmpty())
            @foreach($featuredOpportunities as $opportunity)
                @php
                    $meta = is_string($opportunity->meta_data) ? json_decode($opportunity->meta_data) : $opportunity->meta_data;
                    $image = $meta->image ?? 'images/templates/placeholder.svg';
                    $deadline = $meta->deadline ?? '';
                    $category = $meta->category ?? '';
                    
                    // Map category slugs to display names
                    $categoryNames = [
                        'circular-economy' => 'Circular Economy',
                        'business' => 'Business',
                        'agriculture' => 'Agriculture',
                        'tourism' => 'Tourism & Culture'
                    ];
                    
                    $displayCategory = $categoryNames[$category] ?? $category;
                @endphp
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $opportunity->image_url }}" class="card-img-top" alt="{{ $opportunity->title }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            @if(!empty($category))
                                <span class="badge bg-primary mb-2">{{ $displayCategory }}</span>
                            @endif
                            <h5 class="card-title">{{ $opportunity->title }}</h5>
                            <p class="card-text">{!! Str::limit(strip_tags($opportunity->content), 100) !!}</p>
                            
                            @if(!empty($deadline))
                                <p class="text-muted small">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ __('Deadline') }}: {{ \Carbon\Carbon::parse($deadline)->format('M d, Y') }}
                                </p>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('opportunities.show', $opportunity->id) }}" class="btn btn-sm btn-outline-primary">{{ __('View Details') }}</a>
                                
                                @auth
                                    <button class="btn btn-sm btn-outline-primary save-opportunity" 
                                            data-id="{{ $opportunity->id }}" 
                                            data-type="opportunity"
                                            title="{{ __('Save for later') }}">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-10 offset-md-1">
                <div class="alert alert-info">
                    {{ __('No featured opportunities available at the moment.') }}
                </div>
            </div>
        @endif
    </div>
    
    <!-- All Opportunities Section -->
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <h2 class="mb-4">{{ __('All Opportunities') }}</h2>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header">{{ __('Filter Opportunities') }}</div>
                <div class="card-body">
                    <form action="{{ route('opportunities.search') }}" method="GET">
                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="q" class="form-label">{{ __('Search') }}</label>
                            <input type="text" name="q" id="q" class="form-control" placeholder="{{ __('Keywords...') }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">{{ __('Apply Filters') }}</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="row">
                @if($opportunities->isNotEmpty())
                    @foreach($opportunities as $opportunity)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $opportunity->image_url }}" class="card-img-top" alt="{{ $opportunity->title }}" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    @if(!empty($opportunity->category))
                                        <span class="badge bg-primary mb-2">{{ $opportunity->category_name }}</span>
                                    @endif
                                    <h5 class="card-title">{{ $opportunity->title }}</h5>
                                    <p class="card-text">{!! Str::limit(strip_tags($opportunity->content), 100) !!}</p>
                                    
                                    @if($opportunity->deadline)
                                        <p class="text-muted small">
                                            <i class="fas fa-calendar-alt me-1"></i> {{ __('Deadline') }}: {{ $opportunity->deadline->format('M d, Y') }}
                                        </p>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ route('opportunities.show', $opportunity->id) }}" class="btn btn-sm btn-outline-primary">{{ __('View Details') }}</a>
                                        
                                        @auth
                                            <button class="btn btn-sm btn-outline-primary save-opportunity" 
                                                    data-id="{{ $opportunity->id }}" 
                                                    data-saved="{{ in_array($opportunity->id, $savedOpportunities) ? 'true' : 'false' }}">
                                                <i class="fas {{ in_array($opportunity->id, $savedOpportunities) ? 'fa-bookmark' : 'fa-bookmark-o' }}"></i>
                                                <span>{{ in_array($opportunity->id, $savedOpportunities) ? __('Saved') : __('Save') }}</span>
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mt-4">
                            {{ $opportunities->links() }}
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="alert alert-info">
                            {{ __('No opportunities available at the moment.') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @php
        // Fetch opportunity categories from CMS
        try {
            $opportunityCategories = \App\Models\Opportunities\CircularEconomy\Content::where('type', 'opportunity_category')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
        } catch (\Exception $e) {
            $opportunityCategories = collect([]);
        }
        
        // If no categories found in CMS, use default ones
        if ($opportunityCategories->isEmpty()) {
            $defaultCategories = [
                [
                    'title' => 'Circular Economy',
                    'content' => 'Explore sustainable waste management solutions, recycling opportunities, and participate in the circular economy.',
                    'meta_data' => json_encode([
                        'image' => 'images/data-dashboard.svg',
                        'route' => 'opportunities.circular-economy.waste.home',
                        'status' => 'active'
                    ])
                ],
                [
                    'title' => 'Business Opportunities',
                    'content' => 'Find business opportunities, tenders, and collaborations with local government and private sector.',
                    'meta_data' => json_encode([
                        'image' => 'images/templates/placeholder.svg',
                        'route' => '',
                        'status' => 'coming_soon'
                    ])
                ],
                [
                    'title' => 'Agricultural Initiatives',
                    'content' => 'Discover agricultural programs, support for farmers, and sustainable farming initiatives.',
                    'meta_data' => json_encode([
                        'image' => 'images/templates/placeholder.svg',
                        'route' => '',
                        'status' => 'coming_soon'
                    ])
                ],
                [
                    'title' => 'Tourism & Culture',
                    'content' => 'Explore tourism opportunities, cultural exchanges, and promotion of local attractions.',
                    'meta_data' => json_encode([
                        'image' => 'images/templates/placeholder.svg',
                        'route' => '',
                        'status' => 'coming_soon'
                    ])
                ]
            ];
            
            foreach ($defaultCategories as $category) {
                $cat = new \App\Models\Opportunities\CircularEconomy\Content;
                $cat->title = $category['title'];
                $cat->content = $category['content'];
                $cat->meta_data = $category['meta_data'];
                $opportunityCategories->push($cat);
            }
        }
    @endphp
    
    <div class="row mb-4">
        <div class="col-md-6 mb-4" id="circular-economy">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3">{{ __('Circular Economy') }}</h3>
                    <p class="card-text">{{ __('Explore sustainable waste management solutions, recycling opportunities, and participate in the circular economy.') }}</p>
                    <img src="{{ asset('images/data-dashboard.svg') }}" alt="Circular Economy" class="img-fluid mb-3" style="max-height: 150px;">
                    <div class="mt-auto">
                        <a href="{{ route('opportunities.category', 'circular-economy') }}" class="btn btn-primary">{{ __('Explore') }} {{ __('Circular Economy') }}</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4" id="business">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3">{{ __('Business') }}</h3>
                    <p class="card-text">{{ __('Find business opportunities, tenders, and collaborations with local government and private sector.') }}</p>
                    <img src="{{ asset('images/templates/placeholder.svg') }}" alt="Business" class="img-fluid mb-3" style="max-height: 150px;">
                    <div class="mt-auto">
                        <a href="{{ route('opportunities.category', 'business') }}" class="btn btn-primary">{{ __('Explore') }} {{ __('Business Opportunities') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6 mb-4" id="agriculture">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3">{{ __('Agriculture') }}</h3>
                    <p class="card-text">{{ __('Discover agricultural programs, support for farmers, and sustainable farming initiatives.') }}</p>
                    <img src="{{ asset('images/templates/placeholder.svg') }}" alt="Agriculture" class="img-fluid mb-3" style="max-height: 150px;">
                    <div class="mt-auto">
                        <a href="{{ route('opportunities.category', 'agriculture') }}" class="btn btn-primary">{{ __('Explore') }} {{ __('Agricultural Initiatives') }}</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4" id="tourism">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3">{{ __('Tourism & Culture') }}</h3>
                    <p class="card-text">{{ __('Explore tourism opportunities, cultural exchanges, and promotion of local attractions.') }}</p>
                    <img src="{{ asset('images/templates/placeholder.svg') }}" alt="Tourism & Culture" class="img-fluid mb-3" style="max-height: 150px;">
                    <div class="mt-auto">
                        <a href="{{ route('opportunities.category', 'tourism') }}" class="btn btn-primary">{{ __('Explore') }} {{ __('Tourism & Culture') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Newsletter Subscription -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-primary text-white p-4">
                <div class="card-body text-center">
                    <h3 class="mb-3">{{ __('Stay Updated with New Opportunities') }}</h3>
                    <p class="mb-4">{{ __('Subscribe to our newsletter to receive the latest opportunities directly in your inbox.') }}</p>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="{{ route('opportunities.circular-economy.newsletter.subscribe') }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" placeholder="{{ __('Your Email Address') }}" required>
                                    <button class="btn btn-light" type="submit">{{ __('Subscribe') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Save opportunity functionality
        $('.save-opportunity').click(function() {
            const button = $(this);
            const id = button.data('id');
            const type = button.data('type');
            
            $.ajax({
                url: '{{ route("opportunities.save") }}',
                type: 'POST',
                data: {
                    id: id,
                    type: type,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Toggle bookmark icon
                        button.find('i').toggleClass('far fas');
                        
                        // Show toast notification
                        const toast = $('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">')
                            .append('<div class="toast-header bg-primary text-white"><strong class="me-auto">Notification</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button></div>')
                            .append('<div class="toast-body">' + response.message + '</div>');
                        
                        $('#toast-container').append(toast);
                        const bsToast = new bootstrap.Toast(toast[0]);
                        bsToast.show();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '{{ route("login") }}';
                    }
                }
            });
        });
    });
</script>
@endpush

<!-- Toast container for notifications -->
<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>
@endsection 