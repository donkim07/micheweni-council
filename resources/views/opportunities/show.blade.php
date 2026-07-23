@extends('opportunities.layouts.app')

@section('title', $opportunity->title)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('opportunities.index') }}">{{ __('Opportunities') }}</a></li>
            @if($opportunity->category)
                <li class="breadcrumb-item"><a href="{{ route('opportunities.search', ['category' => $opportunity->category]) }}">{{ $opportunity->category_name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $opportunity->title }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <h1 class="h2 mb-3">{{ $opportunity->title }}</h1>
                    
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        @if($opportunity->category)
                            <span class="badge bg-primary me-2 mb-2">{{ $opportunity->category_name }}</span>
                        @endif
                        
                        @if($opportunity->is_featured)
                            <span class="badge bg-warning me-2 mb-2">{{ __('Featured') }}</span>
                        @endif
                        
                        @if($opportunity->deadline)
                            <span class="badge bg-info me-2 mb-2">
                                <i class="fas fa-calendar-alt me-1"></i> 
                                {{ __('Deadline') }}: {{ $opportunity->deadline->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="opportunity-image mb-4">
                        <img src="{{ $opportunity->image_url }}" alt="{{ $opportunity->title }}" class="img-fluid rounded">
                    </div>
                    
                    <div class="opportunity-content mb-4">
                        {!! $opportunity->content !!}
                    </div>
                    
                    @if(!empty($opportunity->requirements) && count($opportunity->requirements) > 0)
                        <div class="requirements-section mb-4">
                            <h3 class="h5 mb-3">{{ __('Requirements') }}</h3>
                            <ul class="list-group list-group-flush">
                                @foreach($opportunity->requirements as $requirement)
                                    @if(!empty($requirement))
                                        <li class="list-group-item bg-light">
                                            <i class="fas fa-check-circle text-success me-2"></i> {{ $requirement }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(!empty($opportunity->benefits) && count($opportunity->benefits) > 0)
                        <div class="benefits-section mb-4">
                            <h3 class="h5 mb-3">{{ __('Benefits') }}</h3>
                            <ul class="list-group list-group-flush">
                                @foreach($opportunity->benefits as $benefit)
                                    @if(!empty($benefit))
                                        <li class="list-group-item bg-light">
                                            <i class="fas fa-star text-warning me-2"></i> {{ $benefit }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if($opportunity->application_process)
                        <div class="application-process mb-4">
                            <h3 class="h5 mb-3">{{ __('Application Process') }}</h3>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {!! $opportunity->application_process !!}
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="opportunity-actions mt-4">
                        @if($opportunity->application_url)
                            <a href="{{ $opportunity->application_url }}" class="btn btn-primary btn-lg" target="_blank">
                                <i class="fas fa-paper-plane me-2"></i> {{ __('Apply Now') }}
                            </a>
                        @endif
                        
                        @auth
                            <button class="btn btn-outline-primary btn-lg ms-2 save-opportunity" 
                                    data-id="{{ $opportunity->id }}" 
                                    data-saved="{{ \App\Models\Opportunities\SavedOpportunity::isSaved(auth()->id(), $opportunity->id) ? 'true' : 'false' }}">
                                <i class="fas {{ \App\Models\Opportunities\SavedOpportunity::isSaved(auth()->id(), $opportunity->id) ? 'fa-bookmark' : 'fa-bookmark-o' }} me-2"></i> 
                                {{ \App\Models\Opportunities\SavedOpportunity::isSaved(auth()->id(), $opportunity->id) ? __('Saved') : __('Save') }}
                            </button>
                        @endauth
                        
                        <button class="btn btn-outline-secondary btn-lg ms-2" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> {{ __('Print') }}
                        </button>
                        
                        <div class="share-buttons mt-3">
                            <span class="me-2">{{ __('Share:') }}</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" class="btn btn-sm btn-outline-primary me-1" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($opportunity->title) }}" class="btn btn-sm btn-outline-info me-1" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($opportunity->title) }}" class="btn btn-sm btn-outline-primary me-1" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($opportunity->title) }}&body={{ urlencode(request()->url()) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">{{ __('Opportunity Details') }}</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @if($opportunity->deadline)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-calendar-alt text-primary fa-fw me-2"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('Deadline:') }}</strong><br>
                                        {{ $opportunity->deadline->format('M d, Y') }}
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        @if($opportunity->location)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-map-marker-alt text-primary fa-fw me-2"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('Location:') }}</strong><br>
                                        {{ $opportunity->location }}
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        @if($opportunity->contact)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user text-primary fa-fw me-2"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('Contact Person:') }}</strong><br>
                                        {{ $opportunity->contact }}
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        @if($opportunity->email)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-envelope text-primary fa-fw me-2"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('Email:') }}</strong><br>
                                        <a href="mailto:{{ $opportunity->email }}">{{ $opportunity->email }}</a>
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        @if($opportunity->phone)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-phone text-primary fa-fw me-2"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('Phone:') }}</strong><br>
                                        <a href="tel:{{ $opportunity->phone }}">{{ $opportunity->phone }}</a>
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        @if($opportunity->website)
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-globe text-primary fa-fw me-2"></i>
                                    </div>
                                    <div>
                                        <strong>{{ __('Website:') }}</strong><br>
                                        <a href="{{ $opportunity->website }}" target="_blank">{{ $opportunity->website }}</a>
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        <li class="mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-primary fa-fw me-2"></i>
                                </div>
                                <div>
                                    <strong>{{ __('Posted:') }}</strong><br>
                                    {{ $opportunity->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            @if($relatedOpportunities->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h3 class="h5 mb-0">{{ __('Related Opportunities') }}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($relatedOpportunities as $related)
                                <li class="list-group-item px-0">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-2">
                                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1">
                                                <a href="{{ route('opportunities.show', $related->id) }}" class="text-decoration-none">{{ $related->title }}</a>
                                            </h6>
                                            <div class="small text-muted">
                                                @if($related->category)
                                                    <span class="me-2">{{ $related->category_name }}</span>
                                                @endif
                                                @if($related->deadline)
                                                    <span>{{ __('Deadline') }}: {{ $related->deadline->format('M d, Y') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">{{ __('Looking for Something Else?') }}</h3>
                </div>
                <div class="card-body">
                    <p>{{ __('Browse all opportunities or filter by category to find what you\'re looking for.') }}</p>
                    <a href="{{ route('opportunities.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i> {{ __('Browse All Opportunities') }}
                    </a>
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
            const saved = button.data('saved');
            
            $.ajax({
                url: '{{ route("opportunities.save") }}',
                type: 'POST',
                data: {
                    id: id,
                    saved: saved,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Toggle bookmark icon and text
                        if (response.action === 'saved') {
                            button.find('i').removeClass('fa-bookmark-o').addClass('fa-bookmark');
                            button.find('i').next().text(' {{ __("Saved") }}');
                        } else {
                            button.find('i').removeClass('fa-bookmark').addClass('fa-bookmark-o');
                            button.find('i').next().text(' {{ __("Save") }}');
                        }
                        
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
