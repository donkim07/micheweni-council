@extends('opportunities.layouts.app')

@section('title', __('My Applications'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ __('My Applications') }}</h1>
    
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
                    <a href="{{ route('opportunities.saved') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-bookmark me-2"></i> {{ __('Saved Opportunities') }}
                    </a>
                    <a href="{{ route('opportunities.applications') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-clipboard-list me-2"></i> {{ __('My Applications') }}
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h3>{{ __('No applications yet') }}</h3>
                    <p class="text-muted mb-4">{{ __('You haven\'t applied to any opportunities yet. Browse opportunities and submit applications.') }}</p>
                    <a href="{{ route('opportunities.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i> {{ __('Browse Opportunities') }}
                    </a>
                </div>
            </div>
            
            <!-- This section will be shown when applications are implemented -->
            <div class="d-none">
                <div class="card shadow-sm">
                    <div class="card-header bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('Your Applications') }}</h5>
                            <span class="badge bg-primary">0</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Opportunity') }}</th>
                                    <th>{{ __('Date Applied') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/templates/placeholder.svg') }}" alt="Opportunity" class="rounded me-2" width="40">
                                            <div>
                                                <div class="fw-medium">Sample Opportunity</div>
                                                <span class="badge bg-primary">Category</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>June 19, 2025</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 