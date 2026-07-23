@extends('layouts.admin')

@section('title', __('Edit Waste Location'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
<style>
    #map {
        height: 400px;
        width: 100%;
        border-radius: 0.5rem;
    }
    .operating-hours .day {
        font-weight: 600;
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
                        <div class="col-lg-6">
                            <h2 class="section-heading">{{ __('Edit Waste Location') }}</h2>
                            <p class="text-muted">{{ $wasteLocation->name }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.waste-locations.show', $wasteLocation->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>{{ __('View Location') }}
                                </a>
                                <a href="{{ route('admin.waste-locations.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Locations') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.waste-locations.update', $wasteLocation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Basic Information') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Location Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $wasteLocation->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label">{{ __('Location Type') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">{{ __('Select Type') }}</option>
                                    @foreach($locationTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('type', $wasteLocation->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">{{ __('Status') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $wasteLocation->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $wasteLocation->address) }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $wasteLocation->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Location on Map -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Location on Map') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">{{ __('Latitude') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $wasteLocation->latitude) }}" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">{{ __('Longitude') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $wasteLocation->longitude) }}" required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="map" class="mb-3"></div>
                        <p class="text-muted small">{{ __('Click on the map to update the location or enter coordinates manually.') }}</p>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Contact Information') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label">{{ __('Phone Number') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $wasteLocation->contact_phone) }}">
                                </div>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $wasteLocation->contact_email) }}">
                                </div>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Operating Hours -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Operating Hours') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="operating-hours">
                            @php
                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                            @endphp
                            
                            @foreach($days as $day)
                                @php
                                    $isOpen = isset($wasteLocation->operating_hours[$day]['is_open']) ? 
                                        $wasteLocation->operating_hours[$day]['is_open'] : false;
                                    $openTime = isset($wasteLocation->operating_hours[$day]['open']) ? 
                                        $wasteLocation->operating_hours[$day]['open'] : '08:00';
                                    $closeTime = isset($wasteLocation->operating_hours[$day]['close']) ? 
                                        $wasteLocation->operating_hours[$day]['close'] : '17:00';
                                @endphp
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input day-checkbox" type="checkbox" 
                                                id="{{ $day }}_open" 
                                                name="operating_hours[{{ $day }}][is_open]" 
                                                value="1" 
                                                data-day="{{ $day }}"
                                                {{ $isOpen ? 'checked' : '' }}>
                                            <label class="form-check-label day" for="{{ $day }}_open">
                                                {{ __(ucfirst($day)) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row hours-inputs" id="{{ $day }}_hours">
                                            <div class="col-sm-5">
                                                <input type="time" class="form-control form-control-sm" 
                                                    name="operating_hours[{{ $day }}][open]" 
                                                    value="{{ $openTime }}"
                                                    placeholder="Opening time">
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <span class="align-middle">{{ __('to') }}</span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="time" class="form-control form-control-sm" 
                                                    name="operating_hours[{{ $day }}][close]" 
                                                    value="{{ $closeTime }}"
                                                    placeholder="Closing time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Actions & Upload -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Actions') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="image" class="form-label">{{ __('Location Image') }}</label>
                            
                            @if($wasteLocation->image)
                                <div class="mb-3">
                                    <img src="{{ @image($wasteLocation->image) }}" alt="{{ $wasteLocation->name }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                                    <div class="form-text">{{ __('Current image. Upload a new one to replace.') }}</div>
                                </div>
                            @endif
                            
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Upload an image of the location (optional). Max size 2MB.') }}</div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteLocationModal">
                                <i class="fas fa-trash me-2"></i>{{ __('Delete') }}
                            </button>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Save Changes') }}
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Accepted Materials -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Accepted Materials') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-text mb-3">
                            {{ __('Select the materials accepted at this location.') }}
                        </div>
                        
                        <div class="accepted-materials">
                            <div class="row">
                                @php
                                    $acceptedMaterialsArray = $wasteLocation->accepted_materials ?? [];
                                    if (!is_array($acceptedMaterialsArray)) {
                                        $acceptedMaterialsArray = [];
                                    }
                                @endphp
                                
                                @foreach($acceptedMaterials as $value => $label)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                id="material_{{ $value }}" 
                                                name="accepted_materials[]" 
                                                value="{{ $value }}" 
                                                {{ in_array($value, $acceptedMaterialsArray) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="material_{{ $value }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Location Details -->
                <div class="card border-0 mb-4">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="mb-0 fw-bold">{{ __('Location Details') }}</h5>
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
                    </div>
                </div>
            </div>
        </div>
    </form>
    
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
        const initialLat = {{ $wasteLocation->latitude }};
        const initialLng = {{ $wasteLocation->longitude }};
        
        let latitude = document.getElementById('latitude');
        let longitude = document.getElementById('longitude');
        
        const map = L.map('map').setView([initialLat, initialLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add initial marker
        let marker = L.marker([initialLat, initialLng]).addTo(map);
        
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            
            marker = L.marker(e.latlng).addTo(map);
            
            // Update form fields
            latitude.value = e.latlng.lat.toFixed(7);
            longitude.value = e.latlng.lng.toFixed(7);
        });
        
        // Operating hours functionality
        const dayCheckboxes = document.querySelectorAll('.day-checkbox');
        
        dayCheckboxes.forEach(function(checkbox) {
            const day = checkbox.dataset.day;
            const hoursInputs = document.getElementById(day + '_hours');
            
            // Initialize state
            toggleHoursInputs(checkbox, hoursInputs);
            
            // Add event listener
            checkbox.addEventListener('change', function() {
                toggleHoursInputs(this, hoursInputs);
            });
        });
        
        function toggleHoursInputs(checkbox, hoursInputs) {
            const inputs = hoursInputs.querySelectorAll('input');
            
            inputs.forEach(function(input) {
                input.disabled = !checkbox.checked;
            });
            
            if (checkbox.checked) {
                hoursInputs.classList.remove('opacity-50');
            } else {
                hoursInputs.classList.add('opacity-50');
            }
        }
    });
</script>
@endsection 