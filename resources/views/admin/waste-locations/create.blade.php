@extends('layouts.admin')

@section('title', __('Add Waste Location'))

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
                            <h2 class="section-heading">{{ __('Add New Waste Location') }}</h2>
                            <p class="text-muted">{{ __('Create a new waste management facility or collection point') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.waste-locations.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Locations') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.waste-locations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
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
                                        <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">{{ __('Status') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label">{{ __('Address') }}</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
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
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">{{ __('Longitude') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div id="map" class="mb-3"></div>
                        <p class="text-muted small">{{ __('Click on the map to set the location or enter coordinates manually.') }}</p>
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
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                                </div>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email') }}">
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
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input day-checkbox" type="checkbox" 
                                                id="{{ $day }}_open" 
                                                name="operating_hours[{{ $day }}][is_open]" 
                                                value="1" 
                                                data-day="{{ $day }}"
                                                {{ old('operating_hours.'.$day.'.is_open') ? 'checked' : '' }}>
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
                                                    value="{{ old('operating_hours.'.$day.'.open', '08:00') }}"
                                                    placeholder="Opening time">
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <span class="align-middle">{{ __('to') }}</span>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="time" class="form-control form-control-sm" 
                                                    name="operating_hours[{{ $day }}][close]" 
                                                    value="{{ old('operating_hours.'.$day.'.close', '17:00') }}"
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
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Upload an image of the location (optional). Max size 2MB.') }}</div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Create Location') }}
                            </button>
                            <a href="{{ route('admin.waste-locations.index') }}" class="btn btn-light">
                                {{ __('Cancel') }}
                            </a>
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
                                @foreach($acceptedMaterials as $value => $label)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                id="material_{{ $value }}" 
                                                name="accepted_materials[]" 
                                                value="{{ $value }}" 
                                                {{ in_array($value, old('accepted_materials', [])) ? 'checked' : '' }}>
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
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        const defaultLat = 5.0549;  // Default to the center of Pemba
        const defaultLng = 39.8000;
        
        let latitude = document.getElementById('latitude');
        let longitude = document.getElementById('longitude');
        
        let initialLat = latitude.value ? parseFloat(latitude.value) : defaultLat;
        let initialLng = longitude.value ? parseFloat(longitude.value) : defaultLng;
        
        const map = L.map('map').setView([initialLat, initialLng], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        let marker;
        if (latitude.value && longitude.value) {
            marker = L.marker([initialLat, initialLng]).addTo(map);
        }
        
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