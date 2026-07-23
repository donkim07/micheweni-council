@extends('layouts.admin')

@section('title', __('Edit Contact Information'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Edit Contact Information') }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.government.site-config.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Configuration') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form action="{{ route('admin.government.site-config.update-contact') }}" method="POST" class="form">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="address" class="form-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $contactInfo['address'] ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">{{ __('Phone Numbers') }}</label>
                            <div class="phone-numbers">
                                @foreach($contactInfo['phones'] ?? [] as $index => $phone)
                                    <div class="input-group mb-2">
                                        <input type="text" name="phones[]" value="{{ old('phones.'.$index, $phone) }}" class="form-control @error('phones.'.$index) is-invalid @enderror" placeholder="{{ __('Phone Number') }}">
                                        <button type="button" class="btn btn-danger remove-phone"><i class="fas fa-times"></i></button>
                                        @error('phones.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                                
                                <!-- Empty field for new phone number -->
                                <div class="input-group mb-2">
                                    <input type="text" name="phones[]" class="form-control" placeholder="{{ __('Phone Number') }}">
                                    <button type="button" class="btn btn-danger remove-phone"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-outline-primary add-phone">
                                <i class="fas fa-plus"></i> {{ __('Add Phone Number') }}
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">{{ __('Email Addresses') }}</label>
                            <div class="email-addresses">
                                @foreach($contactInfo['emails'] ?? [] as $index => $email)
                                    <div class="input-group mb-2">
                                        <input type="email" name="emails[]" value="{{ old('emails.'.$index, $email) }}" class="form-control @error('emails.'.$index) is-invalid @enderror" placeholder="{{ __('Email Address') }}">
                                        <button type="button" class="btn btn-danger remove-email"><i class="fas fa-times"></i></button>
                                        @error('emails.'.$index)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                                
                                <!-- Empty field for new email address -->
                                <div class="input-group mb-2">
                                    <input type="email" name="emails[]" class="form-control" placeholder="{{ __('Email Address') }}">
                                    <button type="button" class="btn btn-danger remove-email"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-sm btn-outline-primary add-email">
                                <i class="fas fa-plus"></i> {{ __('Add Email Address') }}
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <label for="working_hours" class="form-label">{{ __('Working Hours') }} <span class="text-danger">*</span></label>
                            <input type="text" name="working_hours" id="working_hours" class="form-control @error('working_hours') is-invalid @enderror" value="{{ old('working_hours', $contactInfo['working_hours'] ?? '') }}" required>
                            @error('working_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ __('Example: Monday - Friday: 8:00 AM - 4:00 PM') }}</small>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add new phone number field
        document.querySelector('.add-phone').addEventListener('click', function() {
            const template = `
                <div class="input-group mb-2">
                    <input type="text" name="phones[]" class="form-control" placeholder="{{ __('Phone Number') }}">
                    <button type="button" class="btn btn-danger remove-phone"><i class="fas fa-times"></i></button>
                </div>
            `;
            
            const phoneContainer = document.querySelector('.phone-numbers');
            phoneContainer.insertAdjacentHTML('beforeend', template);
            
            // Attach event handlers to new buttons
            attachRemoveHandlers();
        });
        
        // Add new email address field
        document.querySelector('.add-email').addEventListener('click', function() {
            const template = `
                <div class="input-group mb-2">
                    <input type="email" name="emails[]" class="form-control" placeholder="{{ __('Email Address') }}">
                    <button type="button" class="btn btn-danger remove-email"><i class="fas fa-times"></i></button>
                </div>
            `;
            
            const emailContainer = document.querySelector('.email-addresses');
            emailContainer.insertAdjacentHTML('beforeend', template);
            
            // Attach event handlers to new buttons
            attachRemoveHandlers();
        });
        
        // Function to handle remove buttons
        function attachRemoveHandlers() {
            document.querySelectorAll('.remove-phone').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (document.querySelectorAll('.phone-numbers .input-group').length > 1) {
                        this.closest('.input-group').remove();
                    } else {
                        this.previousElementSibling.value = '';
                    }
                });
            });
            
            document.querySelectorAll('.remove-email').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (document.querySelectorAll('.email-addresses .input-group').length > 1) {
                        this.closest('.input-group').remove();
                    } else {
                        this.previousElementSibling.value = '';
                    }
                });
            });
        }
        
        // Attach handlers to existing buttons
        attachRemoveHandlers();
    });
</script>
@endsection 