@extends('layouts.admin')

@section('title', 'Edit Department Details')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .required-label::after {
        content: " *";
        color: red;
    }
    .statistics-container {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .statistic-item {
        background-color: white;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
    }
    .remove-statistic {
        color: #dc3545;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Department Details: {{ $department->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.departments.index') }}">Departments</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.government.departments.show', $department) }}">{{ $department->name }}</a></li>
        <li class="breadcrumb-item active">Edit Details</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Department Details
        </div>
        <div class="card-body">
            <form action="{{ route('admin.government.departments.update-details', $department) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="overview" class="form-label">Department Overview</label>
                    <textarea class="form-control summernote @error('overview') is-invalid @enderror" id="overview" name="overview" rows="6">{{ old('overview', $department->detail->overview ?? '') }}</textarea>
                    <small class="text-muted">Provide a comprehensive overview of the department, its mission, and its role within the government.</small>
                    @error('overview')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="responsibilities" class="form-label">Key Responsibilities</label>
                    <textarea class="form-control summernote @error('responsibilities') is-invalid @enderror" id="responsibilities" name="responsibilities" rows="6">{{ old('responsibilities', $department->detail->responsibilities ?? '') }}</textarea>
                    <small class="text-muted">List the key responsibilities, functions, and duties of the department.</small>
                    @error('responsibilities')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Department Statistics</label>
                    <div class="statistics-container">
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="include_services_count" name="include_services_count" value="1" {{ old('include_services_count', $department->detail && isset($department->detail->include_services_count) ? $department->detail->include_services_count : false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_services_count">Include Services Count</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="include_projects_count" name="include_projects_count" value="1" {{ old('include_projects_count', $department->detail && isset($department->detail->include_projects_count) ? $department->detail->include_projects_count : false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="include_projects_count">Include Projects Count</label>
                            </div>
                            <small class="form-text text-muted">These will automatically display the current count of services and projects for this department.</small>
                        </div>
                        
                        <div id="statistics-items">
                            @if(old('statistics'))
                                @foreach(old('statistics') as $index => $stat)
                                    <div class="statistic-item">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label class="form-label required-label">Label</label>
                                                    <input type="text" class="form-control" name="statistics[{{ $index }}][label]" value="{{ $stat['label'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label required-label">Value</label>
                                                    <input type="text" class="form-control" name="statistics[{{ $index }}][value]" value="{{ $stat['value'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Icon (FontAwesome)</label>
                                                    <input type="text" class="form-control" name="statistics[{{ $index }}][icon]" value="{{ $stat['icon'] ?? '' }}" placeholder="fa-users">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0)" class="remove-statistic"><i class="fas fa-trash-alt me-1"></i> Remove</a>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($department->detail && $department->detail->statistics)
                                @foreach($department->detail->statistics as $index => $stat)
                                    <div class="statistic-item">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label class="form-label required-label">Label</label>
                                                    <input type="text" class="form-control" name="statistics[{{ $index }}][label]" value="{{ $stat['label'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label required-label">Value</label>
                                                    <input type="text" class="form-control" name="statistics[{{ $index }}][value]" value="{{ $stat['value'] }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Icon (FontAwesome)</label>
                                                    <input type="text" class="form-control" name="statistics[{{ $index }}][icon]" value="{{ $stat['icon'] ?? '' }}" placeholder="fa-users">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <a href="javascript:void(0)" class="remove-statistic"><i class="fas fa-trash-alt me-1"></i> Remove</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" id="add-statistic" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-1"></i> Add Statistic
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">Add key statistics that highlight the department's achievements, resources, or impact.</small>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.government.departments.show', $department) }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Details</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote editor
        
        
        // Add new statistic
        $('#add-statistic').click(function() {
            const index = $('#statistics-items .statistic-item').length;
            const newItem = `
                <div class="statistic-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label required-label">Label</label>
                                <input type="text" class="form-control" name="statistics[\${index}][label]" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required-label">Value</label>
                                <input type="text" class="form-control" name="statistics[\${index}][value]" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Icon (FontAwesome)</label>
                                <input type="text" class="form-control" name="statistics[\${index}][icon]" placeholder="fa-users">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="javascript:void(0)" class="remove-statistic"><i class="fas fa-trash-alt me-1"></i> Remove</a>
                    </div>
                </div>
            `;
            $('#statistics-items').append(newItem);
        });
        
        // Remove statistic
        $(document).on('click', '.remove-statistic', function() {
            $(this).closest('.statistic-item').remove();
            // Reindex remaining items
            reindexStatistics();
        });
        
        // Reindex statistics after removal
        function reindexStatistics() {
            $('#statistics-items .statistic-item').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name');
                    const newName = name.replace(/statistics\[\d+\]/, `statistics[\${index}]`);
                    $(this).attr('name', newName);
                });
            });
        }
    });
</script>
@endsection 