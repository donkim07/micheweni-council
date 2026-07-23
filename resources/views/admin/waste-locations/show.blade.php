@extends('layouts.admin')

@section('title', $wasteLocation->name)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
<style>
    #map {
        height: 400px;
        width: 100%;
        border-radius: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6 d-flex align-items-center">
                            @php
                                $iconClass = match($wasteLocation->type) {
                                    'collection_point' => 'fa-dumpster text-primary',
                                    'recycling_center' => 'fa-recycle text-success',
                                    'landfill' => 'fa-trash text-danger',
                                    'transfer_station' => 'fa-exchange-alt text-warning',
                                    'composting_facility' => 'fa-leaf text-success',
                                    'hazardous_waste' => 'fa-skull-crossbones text-danger',
                                    'e_waste' => 'fa-laptop text-info',
                                    'buy_back_center' => 'fa-exchange-alt text-primary',
                                    default => 'fa-map-marker-alt text-info'
                                };
                            @endphp
                            
                            <div class="icon-box bg-light rounded-circle p-3 me-3">
                                <i class="fas {{ $iconClass }} fa-lg"></i>
                            </div>
                            <div>
                                <h2 class="section-heading mb-0">{{ $wasteLocation->name }}</h2>
                                <p class="text-muted mb-0">{{ $locationTypes[$wasteLocation->type] ?? $wasteLocation->type }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-end mt-3 mt-lg-0">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.waste-locations.edit', $wasteLocation->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>{{ __('Edit Location') }}
                                </a>
                                <a href="{{ route('admin.waste-locations.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Locations') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Map -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Location on Map') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div id="map"></div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Description') }}</h5>
                </div>
                <div class="card-body p-4">
                    @if($wasteLocation->description)
                        <p>{{ $wasteLocation->description }}</p>
                    @else
                        <p class="text-muted">{{ __('No description provided.') }}</p>
                    @endif
                    
                    @if($wasteLocation->address)
                        <div class="mt-3">
                            <h6 class="fw-bold">{{ __('Address') }}</h6>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                {{ $wasteLocation->address }}
                            </p>
                        </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">{{ __('Coordinates') }}</h6>
                            <p class="mb-0">
                                <i class="fas fa-map-pin text-primary me-2"></i>
                                {{ $wasteLocation->latitude }}, {{ $wasteLocation->longitude }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">{{ __('Status') }}</h6>
                            <p class="mb-0">
                                @if($wasteLocation->is_active)
                                    <span class="badge bg-success-soft text-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger">{{ __('Inactive') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Accepted Materials -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Accepted Materials') }}</h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $acceptedMaterialsArray = $wasteLocation->accepted_materials ?? [];
                        if (!is_array($acceptedMaterialsArray) && !empty($acceptedMaterialsArray)) {
                            $acceptedMaterialsArray = json_decode($acceptedMaterialsArray, true) ?? [];
                        }
                    @endphp
                    
                    @if(count($acceptedMaterialsArray) > 0)
                        <div class="row">
                            @foreach($acceptedMaterialsArray as $material)
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span>{{ $acceptedMaterials[$material] ?? $material }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">{{ __('No information about accepted materials.') }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Image -->
            @if($wasteLocation->image)
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Location Image') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <img src="{{ @image($wasteLocation->image) }}" alt="{{ $wasteLocation->name }}" class="img-fluid w-100">
                    </div>
                </div>
            @endif
            
            <!-- Contact Information -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Contact Information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3 d-flex align-items-center">
                            <div class="icon-box bg-primary-soft rounded-circle p-2 me-3">
                                <i class="fas fa-phone text-primary"></i>
                            </div>
                            @if($wasteLocation->contact_phone)
                                <div>
                                    <div class="text-muted small">{{ __('Phone Number') }}</div>
                                    <a href="tel:{{ $wasteLocation->contact_phone }}" class="fw-medium text-decoration-none">
                                        {{ $wasteLocation->contact_phone }}
                                    </a>
                                </div>
                            @else
                                <div class="text-muted">{{ __('No phone number provided') }}</div>
                            @endif
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex align-items-center">
                            <div class="icon-box bg-info-soft rounded-circle p-2 me-3">
                                <i class="fas fa-envelope text-info"></i>
                            </div>
                            @if($wasteLocation->contact_email)
                                <div>
                                    <div class="text-muted small">{{ __('Email Address') }}</div>
                                    <a href="mailto:{{ $wasteLocation->contact_email }}" class="fw-medium text-decoration-none">
                                        {{ $wasteLocation->contact_email }}
                                    </a>
                                </div>
                            @else
                                <div class="text-muted">{{ __('No email address provided') }}</div>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Operating Hours -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Operating Hours') }}</h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $operatingHours = $wasteLocation->operating_hours ?? [];
                        if (!is_array($operatingHours) && !empty($operatingHours)) {
                            $operatingHours = json_decode($operatingHours, true) ?? [];
                        }
                        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    @endphp
                    
                    @if(count($operatingHours) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($days as $day)
                                <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                                    <span class="fw-medium">{{ __(ucfirst($day)) }}</span>
                                    @if(isset($operatingHours[$day]) && isset($operatingHours[$day]['is_open']) && $operatingHours[$day]['is_open'])
                                        <span>
                                            {{ $operatingHours[$day]['open'] ?? '08:00' }} - {{ $operatingHours[$day]['close'] ?? '17:00' }}
                                        </span>
                                    @else
                                        <span class="text-muted">{{ __('Closed') }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">{{ __('No operating hours information provided.') }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Management -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="mb-0 fw-bold">{{ __('Management') }}</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="fw-medium">{{ __('Created') }}</span>
                            <span class="text-muted">{{ $wasteLocation->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between">
                            <span class="fw-medium">{{ __('Last Updated') }}</span>
                            <span class="text-muted">{{ $wasteLocation->updated_at->format('M d, Y') }}</span>
                        </li>
                    </ul>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteLocationModal">
                            <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                        </button>
                        
                        <a href="{{ route('admin.waste-locations.edit', $wasteLocation->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>{{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteLocationModal" tabindex="-1" aria-labelledby="deleteLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLocationModalLabel">{{ __('Delete Location') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <h5 class="mb-2">{{ __('Are you sure you want to delete this location?') }}</h5>
                        <p class="text-muted mb-0">{{ $wasteLocation->name }}</p>
                    </div>
                    <p class="text-danger text-center">{{ __('This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('admin.waste-locations.destroy', $wasteLocation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete Location') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        const lat = {{ $wasteLocation->latitude }};
        const lng = {{ $wasteLocation->longitude }};
        
        const map = L.map('map').setView([lat, lng], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("<strong>{{ $wasteLocation->name }}</strong>").openPopup();
    });
</script>
@endsection 