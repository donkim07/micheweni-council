@extends('layouts.admin')

@section('title', __('Departments'))

@section('styles')
<style>
    .department-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .department-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .department-list-item.active {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .department-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .department-status.active {
        background-color: #28a745;
    }
    
    .department-status.inactive {
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
    <h1 class="mt-4">{{ __('Departments') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Departments') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Departments') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and organize government departments.') }}</p>
                </div>
                <a href="{{ route('admin.government.departments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Department') }}
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
                            <th>{{ __('Name') }}</th>
                            <th class="hide-sm">{{ __('Head') }}</th>
                            <th class="hide-sm">{{ __('Contact') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="departmentsList">
                        @forelse($departments as $department)
                            <tr class="department-list-item" data-id="{{ $department->id }}">
                                <td class="text-center handle">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($department->featured_image)
                                            <div class="me-3">
                                                <img src="{{ asset('images/' . $department->featured_image) }}" alt="{{ $department->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $department->name }}</strong>
                                            @if($department->slug)
                                                <div class="small text-muted">{{ $department->slug }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($department->head_name)
                                        <div>{{ $department->head_name }}</div>
                                        <div class="small text-muted">{{ $department->head_title }}</div>
                                    @else
                                        <span class="text-muted">{{ __('Not assigned') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($department->contact_email || $department->contact_phone)
                                        @if($department->contact_email)
                                            <div><i class="fas fa-envelope me-1 small"></i> {{ $department->contact_email }}</div>
                                        @endif
                                        @if($department->contact_phone)
                                            <div><i class="fas fa-phone me-1 small"></i> {{ $department->contact_phone }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted">{{ __('No contact info') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="department-status {{ $department->status }}"></span>
                                    {{ ucfirst($department->status) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.departments.show', $department) }}" class="btn btn-sm btn-outline-primary me-1" title="{{ __('View') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.departments.edit', $department) }}" class="btn btn-sm btn-outline-primary me-1" title="{{ __('Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.government.departments.edit-details', $department) }}" class="btn btn-sm btn-outline-info me-1" title="{{ __('Edit Details') }}">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                        <form action="{{ route('admin.government.departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this department?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Delete') }}">
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
                                        <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No departments found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first department') }}</p>
                                        <a href="{{ route('admin.government.departments.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Department') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const departmentsList = document.getElementById('departmentsList');
        
        if (departmentsList && departmentsList.children.length > 1) {
            new Sortable(departmentsList, {
                handle: '.handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function () {
                    updateOrder();
                }
            });
            
            function updateOrder() {
                const order = [];
                
                document.querySelectorAll('#departmentsList tr').forEach(item => {
                    order.push(item.getAttribute('data-id'));
                });
                
                fetch('{{ route('admin.government.departments.updateOrder') }}', {
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