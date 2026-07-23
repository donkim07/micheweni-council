@extends('opportunities.layouts.app')

@section('title', __('Search Results'))

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-2">{{ __('Search Results') }}</h1>
            <p class="text-muted">
                {{ __('Showing results for') }}: <strong>"{{ $query }}"</strong>
                @if(!empty($category))
                    {{ __('in category') }}: <strong>{{ $category }}</strong>
                @endif
            </p>
        </div>
        <div class="col-md-4">
            <form action="{{ route('opportunities.search') }}" method="GET" class="search-form">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="{{ __('Search opportunities...') }}" value="{{ $query }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="mt-2">
                    <select class="form-select form-select-sm" name="category" onchange="this.form.submit()">
                        <option value="">{{ __('All Categories') }}</option>
                        <option value="circular-economy" {{ $category == 'circular-economy' ? 'selected' : '' }}>{{ __('Circular Economy') }}</option>
                        <option value="business" {{ $category == 'business' ? 'selected' : '' }}>{{ __('Business') }}</option>
                        <option value="agriculture" {{ $category == 'agriculture' ? 'selected' : '' }}>{{ __('Agriculture') }}</option>
                        <option value="tourism" {{ $category == 'tourism' ? 'selected' : '' }}>{{ __('Tourism & Culture') }}</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    
    @if($opportunities->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3>{{ __('No results found') }}</h3>
                <p class="text-muted mb-4">{{ __('We couldn\'t find any opportunities matching your search criteria.') }}</p>
                <a href="{{ route('opportunities.index') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> {{ __('Back to Opportunities') }}
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Filter Results') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('opportunities.search') }}" method="GET">
                            <input type="hidden" name="q" value="{{ $query }}">
                            
                            <div class="mb-3">
                                <label class="form-label">{{ __('Category') }}</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat-all" value="" {{ empty($category) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat-all">
                                        {{ __('All Categories') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat-circular" value="circular-economy" {{ $category == 'circular-economy' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat-circular">
                                        {{ __('Circular Economy') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat-business" value="business" {{ $category == 'business' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat-business">
                                        {{ __('Business') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat-agriculture" value="agriculture" {{ $category == 'agriculture' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat-agriculture">
                                        {{ __('Agriculture') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat-tourism" value="tourism" {{ $category == 'tourism' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat-tourism">
                                        {{ __('Tourism & Culture') }}
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i> {{ __('Apply Filters') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">{{ __('Found') }} <strong>{{ $opportunities->total() }}</strong> {{ __('results') }}</p>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary btn-sm active" id="grid-view">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="list-view">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                
                <div class="row g-4" id="grid-container">
                    @foreach($opportunities as $opportunity)
                        @php
                            $meta = is_string($opportunity->meta_data) ? json_decode($opportunity->meta_data) : $opportunity->meta_data;
                            $category = $meta->category ?? '';
                            $deadline = $meta->deadline ?? '';
                            $image = $meta->image ?? 'images/templates/placeholder.svg';
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $opportunity->image_url }}" class="card-img-top" alt="{{ $opportunity->title }}" style="height: 180px; object-fit: cover;">
                                <div class="card-body">
                                    @if(!empty($category))
                                        <span class="badge bg-primary mb-2">{{ $category }}</span>
                                    @endif
                                    <h5 class="card-title">{{ $opportunity->title }}</h5>
                                    <p class="card-text">{{ Str::limit($opportunity->content, 100) }}</p>
                                    
                                    @if(!empty($deadline))
                                        <p class="text-muted small">
                                            <i class="fas fa-calendar-alt me-1"></i> {{ __('Deadline') }}: {{ $deadline }}
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
                </div>
                
                <div class="list-group d-none" id="list-container">
                    @foreach($opportunities as $opportunity)
                        @php
                            $meta = is_string($opportunity->meta_data) ? json_decode($opportunity->meta_data) : $opportunity->meta_data;
                            $category = $meta->category ?? '';
                            $deadline = $meta->deadline ?? '';
                            $image = $meta->image ?? 'images/templates/placeholder.svg';
                        @endphp
                        <div class="list-group-item p-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset($image) }}" alt="{{ $opportunity->title }}" class="img-fluid rounded">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mb-1">
                                        <a href="{{ route('opportunities.show', $opportunity->id) }}" class="text-decoration-none">{{ $opportunity->title }}</a>
                                    </h5>
                                    @if(!empty($category))
                                        <span class="badge bg-primary mb-2">{{ $category }}</span>
                                    @endif
                                    <p class="text-muted small mb-1">{{ Str::limit($opportunity->content, 100) }}</p>
                                    @if(!empty($deadline))
                                        <p class="text-danger small mb-0">
                                            <i class="fas fa-calendar-alt me-1"></i> {{ __('Deadline') }}: {{ $deadline }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="btn-group-vertical w-100">
                                        <a href="{{ route('opportunities.show', $opportunity->id) }}" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-eye me-1"></i> {{ __('View') }}
                                        </a>
                                        @auth
                                            <button class="btn btn-sm btn-outline-primary save-opportunity" 
                                                    data-id="{{ $opportunity->id }}" 
                                                    data-type="opportunity">
                                                <i class="far fa-bookmark me-1"></i> {{ __('Save') }}
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $opportunities->appends(['q' => $query, 'category' => $category])->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // View toggle functionality
        $('#grid-view').click(function() {
            $(this).addClass('active');
            $('#list-view').removeClass('active');
            $('#grid-container').removeClass('d-none');
            $('#list-container').addClass('d-none');
        });
        
        $('#list-view').click(function() {
            $(this).addClass('active');
            $('#grid-view').removeClass('active');
            $('#list-container').removeClass('d-none');
            $('#grid-container').addClass('d-none');
        });
        
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