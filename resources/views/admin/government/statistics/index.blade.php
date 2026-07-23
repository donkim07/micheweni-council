@extends('layouts.admin')

@section('title', __('Statistics'))

@section('styles')
<style>
    .statistic-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .statistic-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .statistic-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.2rem;
    }
    
    .featured-badge {
        background-color: #dc3545;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Statistics') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Statistics') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Statistics') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage government statistics.') }}</p>
                </div>
                <a href="{{ route('admin.government.statistics.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Statistic') }}
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
                            <th>{{ __('Statistic') }}</th>
                            <th>{{ __('Value') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statistics as $statistic)
                            <tr class="statistic-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <strong>{{ $statistic->title }}</strong>
                                            @if($statistic->is_featured)
                                                <span class="badge featured-badge">{{ __('Featured') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong class="h4">{{ $statistic->value }}</strong>
                                    @if($statistic->suffix)
                                        <span class="text-muted">{{ $statistic->suffix }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ Str::limit($statistic->description, 100) ?? __('No description') }}
                                </td>
                                <td class="text-center">
                                    @if($statistic->icon)
                                        <div class="statistic-icon bg-{{ $statistic->color ?? 'primary' }}-soft text-{{ $statistic->color ?? 'primary' }}">
                                            <i class="{{ $statistic->icon }}"></i>
                                        </div>
                                    @else
                                        <div class="statistic-icon bg-light text-muted">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($statistic->status === 'active')
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.statistics.show', $statistic) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.statistics.edit', $statistic) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.statistics.destroy', $statistic) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this statistic?') }}');">
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
                                        <i class="fas fa-chart-line text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No statistics found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first statistic') }}</p>
                                        <a href="{{ route('admin.government.statistics.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Statistic') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $statistics->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 