@extends('opportunities.layouts.app')

@section('title', __('Circular Economy'))

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1">
            <h1 class="display-4 mb-4">{{ __('Circular Economy Initiatives') }}</h1>
            <p class="lead">{{ __('Discover sustainable waste management systems and circular economy opportunities that reduce waste and promote resource efficiency.') }}</p>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-md-10 offset-md-1">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('images/data-dashboard.svg') }}" alt="Circular Economy" class="img-fluid mb-3">
                        </div>
                        <div class="col-md-8">
                            <h2 class="mb-3">{{ __('Waste Management Solutions') }}</h2>
                            <p>{{ __('Our waste management platform provides tools and resources to help citizens, businesses, and government entities implement effective waste management practices and participate in the circular economy.') }}</p>
                            <div class="mt-4">
                                <a href="{{ route('opportunities.circular-economy.waste.map') }}" class="btn btn-primary me-2 mb-2">{{ __('View Waste Map') }}</a>
<a href="{{ route('opportunities.circular-economy.waste.directory') }}" class="btn btn-outline-primary me-2 mb-2">{{ __('Service Directory') }}</a>
<a href="{{ route('opportunities.circular-economy.waste.marketplace') }}" class="btn btn-outline-primary mb-2">{{ __('Waste Marketplace') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="mb-4">{{ __('Key Features') }}</h2>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-5 offset-md-1">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-map-marked-alt text-primary me-2"></i>{{ __('Waste Collection Map') }}</h5>
                    <p class="card-text">{{ __('Find nearby waste collection points, recycling centers, and waste management facilities.') }}</p>
                    <a href="{{ route('opportunities.circular-economy.waste.map') }}" class="btn btn-sm btn-outline-primary">{{ __('Explore Map') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-recycle text-primary me-2"></i>{{ __('Recycling Information') }}</h5>
                    <p class="card-text">{{ __('Learn about proper recycling practices and materials processing in your area.') }}</p>
                    <a href="{{ route('opportunities.circular-economy.waste.recycling') }}" class="btn btn-sm btn-outline-primary">{{ __('Learn More') }}</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-md-5 offset-md-1">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-store text-primary me-2"></i>{{ __('Waste Marketplace') }}</h5>
                    <p class="card-text">{{ __('Buy, sell, or trade recyclable materials, waste management equipment, and related services.') }}</p>
                    <a href="{{ route('opportunities.circular-economy.waste.marketplace') }}" class="btn btn-sm btn-outline-primary">{{ __('Visit Marketplace') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card h-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-clipboard-check text-primary me-2"></i>{{ __('Waste Assessment Tool') }}</h5>
                    <p class="card-text">{{ __('Evaluate your current waste management practices and get personalized recommendations.') }}</p>
                    <a href="{{ route('opportunities.circular-economy.assessment.index') }}" class="btn btn-sm btn-outline-primary">{{ __('Take Assessment') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 