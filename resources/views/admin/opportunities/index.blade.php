@extends('layouts.admin')

@section('title', __('Opportunities Management'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Opportunities Management') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Opportunities') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                {{ __('All Opportunities') }}
            </div>
            <a href="{{ route('admin.opportunities.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add New') }}
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="opportunitiesTable">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Created') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opportunities as $opportunity)
                            @php
                                $metaData = json_decode($opportunity->meta_data, true) ?? [];
                                $category = $metaData['category'] ?? 'Unknown';
                                
                                // Map category slugs to display names
                                $categoryNames = [
                                    'circular-economy' => 'Circular Economy',
                                    'business' => 'Business',
                                    'agriculture' => 'Agriculture',
                                    'tourism' => 'Tourism & Culture'
                                ];
                                
                                $displayCategory = $categoryNames[$category] ?? $category;
                            @endphp
                            <tr>
                                <td>{{ $opportunity->title }}</td>
                                <td>{{ $displayCategory }}</td>
                                <td>
                                    @if($opportunity->type === 'featured_opportunity')
                                        <span class="badge bg-warning">{{ __('Featured') }}</span>
                                    @else
                                        <span class="badge bg-info">{{ __('Regular') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($opportunity->is_active)
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>{{ $opportunity->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.opportunities.show', $opportunity->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.opportunities.edit', $opportunity->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.opportunities.toggle', $opportunity->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $opportunity->is_active ? 'btn-warning' : 'btn-success' }}">
                                                <i class="fas {{ $opportunity->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.opportunities.destroy', $opportunity->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('No opportunities found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $opportunities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete confirmation
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('{{ __("Are you sure you want to delete this opportunity? This action cannot be undone.") }}')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection
