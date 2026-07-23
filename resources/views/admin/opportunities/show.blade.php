@extends('layouts.admin')

@section('title', __('Opportunity Details'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Opportunity Details') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.opportunities.index') }}">{{ __('Opportunities') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Details') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-info-circle me-1"></i>
                {{ __('Opportunity Information') }}
            </div>
            <div>
                <a href="{{ route('admin.opportunities.show', $opportunity->id) }}" class="btn btn-info btn-sm me-2" target="_blank">
                    <i class="fas fa-eye"></i> {{ __('View on Site') }}
                </a>
                <a href="{{ route('admin.opportunities.edit', $opportunity->id) }}" class="btn btn-primary btn-sm me-2">
                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                </a>
                <a href="{{ route('admin.opportunities.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-3">{{ $opportunity->title }}</h2>
                    
                    <div class="mb-4">
                        <div class="d-flex flex-wrap mb-2">
                            <span class="badge bg-primary me-2 mb-1">{{ $opportunity->category_name }}</span>
                            @if($opportunity->is_featured)
                                <span class="badge bg-warning me-2 mb-1">{{ __('Featured') }}</span>
                            @endif
                            @if($opportunity->is_active)
                                <span class="badge bg-success me-2 mb-1">{{ __('Active') }}</span>
                            @else
                                <span class="badge bg-danger me-2 mb-1">{{ __('Inactive') }}</span>
                            @endif
                        </div>
                        
                        <div class="text-muted small mb-3">
                            <i class="fas fa-calendar me-1"></i> {{ __('Created') }}: {{ $opportunity->created_at->format('M d, Y') }}
                            @if($opportunity->created_at != $opportunity->updated_at)
                                <span class="mx-2">|</span>
                                <i class="fas fa-edit me-1"></i> {{ __('Updated') }}: {{ $opportunity->updated_at->format('M d, Y') }}
                            @endif
                            
                            @if($opportunity->deadline)
                                <span class="mx-2">|</span>
                                <i class="fas fa-clock me-1"></i> {{ __('Deadline') }}: {{ $opportunity->deadline->format('M d, Y') }}
                            @endif
                            
                            @if($opportunity->location)
                                <span class="mx-2">|</span>
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $opportunity->location }}
                            @endif
                        </div>
                    </div>
                    
                    <!-- System Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ __('System Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        
                                        <tr>
                                            <th>{{ __('Category') }}:</th>
                                            <td>{{ $opportunity->category }} ({{ $opportunity->category_name }})</td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                    <tr>
                                            <th>{{ __('Status') }}:</th>
                                            <td>{{ $opportunity->is_active ? __('Active') : __('Inactive') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Description') }}</div>
                        <div class="card-body">
                            {!! $opportunity->content !!}
                        </div>
                    </div>
                    
                    <div class="row">
                        @if(!empty($opportunity->requirements))
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">{{ __('Requirements') }}</div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach($opportunity->requirements as $requirement)
                                                @if(!empty($requirement))
                                                    <li class="list-group-item">
                                                        <i class="fas fa-check-circle text-success me-2"></i> {{ $requirement }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if(!empty($opportunity->benefits))
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">{{ __('Benefits') }}</div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach($opportunity->benefits as $benefit)
                                                @if(!empty($benefit))
                                                    <li class="list-group-item">
                                                        <i class="fas fa-star text-warning me-2"></i> {{ $benefit }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($opportunity->application_process)
                        <div class="card mb-4">
                            <div class="card-header">{{ __('Application Process') }}</div>
                            <div class="card-body">
                                <p>{{ $opportunity->application_process }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-4">
                    @if($opportunity->image)
                        <div class="card mb-4">
                            <div class="card-header">{{ __('Featured Image') }}</div>
                            <div class="card-body text-center">
                                <img src="{{ $opportunity->image_url }}" alt="{{ $opportunity->title }}" class="img-fluid rounded">
                                
                            </div>
                        </div>
                    @endif
                    
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Contact Information') }}</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @if($opportunity->contact)
                                    <li class="list-group-item">
                                        <i class="fas fa-user me-2"></i> {{ $opportunity->contact }}
                                    </li>
                                @endif
                                
                                @if($opportunity->email)
                                    <li class="list-group-item">
                                        <i class="fas fa-envelope me-2"></i> <a href="mailto:{{ $opportunity->email }}">{{ $opportunity->email }}</a>
                                    </li>
                                @endif
                                
                                @if($opportunity->phone)
                                    <li class="list-group-item">
                                        <i class="fas fa-phone me-2"></i> {{ $opportunity->phone }}
                                    </li>
                                @endif
                                
                                @if($opportunity->website)
                                    <li class="list-group-item">
                                        <i class="fas fa-globe me-2"></i> <a href="{{ $opportunity->website }}" target="_blank">{{ $opportunity->website }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    @if($opportunity->application_url)
                        <div class="card mb-4">
                            <div class="card-header">{{ __('Application Link') }}</div>
                            <div class="card-body">
                                <a href="{{ $opportunity->application_url }}" target="_blank" class="btn btn-primary w-100">
                                    <i class="fas fa-external-link-alt me-2"></i> {{ __('Apply Now') }}
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Actions') }}</div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.opportunities.edit', $opportunity->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i> {{ __('Edit Opportunity') }}
                                </a>
                                
                                <form action="{{ route('admin.opportunities.toggle', $opportunity->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-{{ $opportunity->is_active ? 'warning' : 'success' }} w-100">
                                        <i class="fas fa-{{ $opportunity->is_active ? 'eye-slash' : 'eye' }} me-2"></i> 
                                        {{ $opportunity->is_active ? __('Deactivate') : __('Activate') }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.opportunities.destroy', $opportunity->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this opportunity? This action cannot be undone.') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-trash-alt me-2"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

