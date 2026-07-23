@extends('opportunities.layouts.app')

@section('title', $categoryName . ' ' . __('Opportunities'))

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1">
            <h1 class="display-4 mb-4">{{ $categoryName }} {{ __('Opportunities') }}</h1>
            <p class="lead">{{ __('Explore opportunities in the') }} {{ strtolower($categoryName) }} {{ __('sector') }}.</p>
        </div>
    </div>
    
    <div class="row">
        @if($opportunities->count() > 0)
            @foreach($opportunities as $opportunity)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $opportunity->image_url }}" class="card-img-top" alt="{{ $opportunity->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $opportunity->title }}</h5>
                            <p class="card-text text-muted">
                                <small>
                                    <i class="fas fa-calendar-alt"></i> 
                                    @if($opportunity->deadline)
                                        {{ __('Deadline') }}: {{ $opportunity->deadline->format('M d, Y') }}
                                    @else
                                        {{ __('Open opportunity') }}
                                    @endif
                                </small>
                            </p>
                            <p class="card-text">{{ Str::limit(strip_tags($opportunity->content), 150) }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('opportunities.show', $opportunity->id) }}" class="btn btn-primary btn-sm">
                                    {{ __('Learn More') }}
                                </a>
                                @auth
                                    <button type="button" 
                                        class="btn btn-outline-secondary btn-sm save-opportunity" 
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
        @else
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <h4>{{ __('No opportunities available at the moment') }}</h4>
                    <p>{{ __('Check back later for opportunities in the') }} {{ strtolower($categoryName) }} {{ __('sector') }}.</p>
                </div>
            </div>
        @endif
    </div>
    
    <div class="row">
        <div class="col-12 d-flex justify-content-center mt-4">
            {{ $opportunities->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.save-opportunity').on('click', function() {
            var button = $(this);
            var opportunityId = button.data('id');
            
            $.ajax({
                url: '{{ route('opportunities.save') }}',
                method: 'POST',
                data: {
                    id: opportunityId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.action === 'saved') {
                        button.data('saved', 'true');
                        button.find('i').removeClass('fa-bookmark-o').addClass('fa-bookmark');
                        button.find('span').text('{{ __("Saved") }}');
                    } else {
                        button.data('saved', 'false');
                        button.find('i').removeClass('fa-bookmark').addClass('fa-bookmark-o');
                        button.find('span').text('{{ __("Save") }}');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '{{ route('login') }}';
                    }
                }
            });
        });
    });
</script>
@endsection 