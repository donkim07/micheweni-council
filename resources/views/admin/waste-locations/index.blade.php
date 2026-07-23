@extends('layouts.admin')

@section('title', __('Waste Locations'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="section-heading">{{ __('Waste Locations') }}</h2>
                            <p class="text-muted">{{ __('Manage waste collection points, recycling centers, and other facilities') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.waste-locations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Add Location') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Filter Options') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.waste-locations.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">{{ __('Location Type') }}</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">{{ __('All Types') }}</option>
                                @foreach($locationTypes as $value => $label)
                                    <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="is_active" class="form-label">{{ __('Status') }}</label>
                            <select name="is_active" id="is_active" class="form-select">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>
                                    {{ __('Active') }}
                                </option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>
                                    {{ __('Inactive') }}
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="search" class="form-label">{{ __('Search') }}</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                placeholder="{{ __('Search by name or address') }}" value="{{ request('search') }}">
                        </div>
                        
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ __('All Locations') }}</h5>
                        <span class="badge bg-primary-soft text-primary rounded-pill">
                            {{ $wasteLocations->total() }} {{ __('Locations') }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('Location') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Type') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Address') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Status') }}</th>
                                    <th class="border-0 px-4 py-3 text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wasteLocations as $location)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            @if($location->image)
                                                <div class="rounded-circle overflow-hidden me-3" style="width: 40px; height: 40px;">
                                                    <img src="{{ 'image/' . ($location->image) }}" alt="{{ $location->name }}" class="img-fluid">
                                                </div>
                                            @else
                                                <div class="icon-box bg-light rounded-circle p-2 me-3">
                                                    @switch($location->type)
                                                        @case('collection_point')
                                                            <i class="fas fa-dumpster text-primary"></i>
                                                            @break
                                                        @case('recycling_center')
                                                            <i class="fas fa-recycle text-success"></i>
                                                            @break
                                                        @case('landfill')
                                                            <i class="fas fa-trash text-danger"></i>
                                                            @break
                                                        @case('transfer_station')
                                                            <i class="fas fa-exchange-alt text-warning"></i>
                                                            @break
                                                        @default
                                                            <i class="fas fa-map-marker-alt text-info"></i>
                                                    @endswitch
                                                </div>
                                            @endif
                                            <span class="fw-medium">{{ $location->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badgeColor = match($location->type) {
                                                'collection_point' => 'primary',
                                                'recycling_center' => 'success',
                                                'landfill' => 'danger',
                                                'transfer_station' => 'warning',
                                                'composting_facility' => 'success',
                                                'hazardous_waste' => 'danger',
                                                'e_waste' => 'info',
                                                'buy_back_center' => 'primary',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeColor }}-soft text-{{ $badgeColor }}">
                                            {{ $locationTypes[$location->type] ?? $location->type }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="small">
                                            @if($location->address)
                                                <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                                {{ $location->address }}
                                            @else
                                                <span class="text-muted">{{ __('No address specified') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($location->is_active)
                                            <span class="badge bg-success-soft text-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger-soft text-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.waste-locations.edit', $location->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.waste-locations.show', $location->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="{{ __('View') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $location->id }}" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $location->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $location->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $location->id }}">{{ __('Delete Location') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center mb-4">
                                                            <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                                            <h5 class="mb-2">{{ __('Are you sure you want to delete this location?') }}</h5>
                                                            <p class="text-muted mb-0">{{ $location->name }}</p>
                                                        </div>
                                                        <p class="text-danger text-center">{{ __('This action cannot be undone.') }}</p>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                        <form action="{{ route('admin.waste-locations.destroy', $location->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">{{ __('Delete Location') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('No waste locations found') }}</p>
                                        <a href="{{ route('admin.waste-locations.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i>{{ __('Add Location') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $wasteLocations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection 