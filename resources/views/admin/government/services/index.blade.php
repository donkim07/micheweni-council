@extends('layouts.admin')

@section('title', __('Services'))

@section('styles')
<style>
    .service-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .service-list-item:hover {
        border-left-color: var(--success);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .service-list-item.active {
        border-left-color: var(--success);
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .service-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .service-status.active {
        background-color: #28a745;
    }
    
    .service-status.inactive {
        background-color: #dc3545;
    }
    
    .sortable-ghost {
        background-color: #f8f9fa;
        border: 1px dashed #6c757d;
    }
    
    .handle {
        cursor: move;
        cursor: -webkit-grabbing;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Services') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Services') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Services') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and organize government services.') }}</p>
                </div>
                <a href="{{ route('admin.government.services.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Service') }}
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 60px;"></th>
                            <th>{{ __('Title') }}</th>
                            <th class="hide-sm">{{ __('Department') }}</th>
                            <th class="hide-sm">{{ __('Features') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="servicesList">
                        @forelse($services as $service)
                            <tr class="service-list-item" data-id="{{ $service->id }}">
                                <td class="text-center handle">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($service->featured_image)
                                            <div class="me-3">
                                                <img src="{{ asset('images/' . $service->featured_image) }}" alt="{{ $service->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $service->title }}</strong>
                                            @if($service->slug)
                                                <div class="small text-muted">{{ $service->slug }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($service->department)
                                        {{ $service->department->name }}
                                    @else
                                        <span class="text-muted">{{ __('No department') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->is_featured)
                                        <span class="badge bg-success">{{ __('Featured') }}</span>
                                    @endif
                                    @if($service->is_popular)
                                        <span class="badge bg-info">{{ __('Popular') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="service-status {{ $service->status }}"></span>
                                    {{ ucfirst($service->status) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.services.show', $service) }}" class="btn btn-sm btn-outline-info me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.services.edit', $service) }}" class="btn btn-sm btn-outline-success me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this service?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-cogs text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No services found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first service') }}</p>
                                        <a href="{{ route('admin.government.services.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Service') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const servicesList = document.getElementById('servicesList');
        
        if (servicesList && servicesList.children.length > 1) {
            new Sortable(servicesList, {
                handle: '.handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function () {
                    updateOrder();
                }
            });
            
            function updateOrder() {
                const order = [];
                
                document.querySelectorAll('#servicesList tr').forEach(item => {
                    order.push(item.getAttribute('data-id'));
                });
                
                fetch('{{ route('admin.government.services.updateOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success handling if needed
                    }
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                });
            }
        }
    });
</script>
@endsection