@extends('opportunities.layouts.app')

@section('title', __('Saved Opportunities'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ __('Saved Opportunities') }}</h1>
    
    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ __('My Account') }}</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('opportunities.saved') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user me-2"></i> {{ __('Profile') }}
                    </a>
                    <a href="{{ route('opportunities.saved') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-bookmark me-2"></i> {{ __('Saved Opportunities') }}
                    </a>
                    <a href="{{ route('opportunities.applications') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-clipboard-list me-2"></i> {{ __('My Applications') }}
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            @if($savedOpportunities->isEmpty())
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-bookmark fa-3x text-muted mb-3"></i>
                        <h3>{{ __('No saved opportunities yet') }}</h3>
                        <p class="text-muted mb-4">{{ __('You haven\'t saved any opportunities. Browse opportunities and save them for later.') }}</p>
                        <a href="{{ route('opportunities.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i> {{ __('Browse Opportunities') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-header bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('Your Saved Opportunities') }}</h5>
                            <span class="badge bg-primary">{{ $savedOpportunities->count() }}</span>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($savedOpportunities as $opportunity)
                            <div class="list-group-item p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ $opportunity->image_url }}" alt="{{ $opportunity->title }}" class="img-fluid rounded">
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="mb-1">
                                            <a href="{{ route('opportunities.show', $opportunity->id) }}" class="text-decoration-none">{{ $opportunity->title }}</a>
                                        </h5>
                                        @if(!empty($opportunity->category))
                                            <span class="badge bg-primary mb-2">{{ $opportunity->category_name }}</span>
                                        @endif
                                        <p class="text-muted small mb-1">{{ Str::limit(strip_tags($opportunity->content), 100) }}</p>
                                        @if($opportunity->deadline)
                                            <p class="text-danger small mb-0">
                                                <i class="fas fa-calendar-alt me-1"></i> {{ __('Deadline') }}: {{ $opportunity->deadline->format('M d, Y') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <div class="btn-group-vertical w-100">
                                            <a href="{{ route('opportunities.show', $opportunity->id) }}" class="btn btn-sm btn-outline-primary mb-2">
                                                <i class="fas fa-eye me-1"></i> {{ __('View') }}
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger remove-saved" 
                                                    data-id="{{ $opportunity->id }}">
                                                <i class="fas fa-trash-alt me-1"></i> {{ __('Remove') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Remove saved opportunity functionality
        $('.remove-saved').click(function() {
            const button = $(this);
            const id = button.data('id');
            
            $.ajax({
                url: '{{ route("opportunities.save") }}',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the item from the list
                        button.closest('.list-group-item').fadeOut(300, function() {
                            $(this).remove();
                            
                            // Check if there are any items left
                            if ($('.list-group-item').length === 0) {
                                location.reload(); // Reload to show empty state
                            }
                        });
                        
                        // Show toast notification
                        toastr.success(response.message);
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