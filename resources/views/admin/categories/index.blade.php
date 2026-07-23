@extends('layouts.admin')

@section('title', __('Categories'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="section-heading">{{ __('Categories Management') }}</h2>
                            <p class="text-muted">{{ __('Create, edit and manage content categories') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Add New Category') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-header bg-white p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">{{ __('All Categories') }}</h5>
                        <div class="d-flex">
                            <div class="input-group me-3">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="category-search" class="form-control border-0 bg-light" placeholder="{{ __('Search categories...') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('Name') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Slug') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Parent') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('News Count') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-light rounded-circle p-2 me-3">
                                                <i class="fas fa-tag text-primary"></i>
                                            </div>
                                            <span class="fw-medium">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-muted">{{ $category->slug }}</td>
                                    <td class="px-4 py-3">
                                        @if($category->parent)
                                            <span class="badge bg-light text-dark">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge rounded-pill bg-primary-soft text-primary">
                                            {{ $category->news_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            @if($category->news_count == 0)
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="if(confirm('{{ __('Are you sure you want to delete this category?') }}')) document.getElementById('delete-form-{{ $category->id }}').submit();">
                                                    <i class="fas fa-trash"></i> 
                                                </button>
                                                <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-danger" disabled title="{{ __('Cannot delete category with associated news articles') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center p-5">
                                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('No categories found.') }}</p>
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i>{{ __('Add Category') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Table search functionality
        const searchInput = document.getElementById('category-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchQuery = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(function(row) {
                    const name = row.querySelector('td:first-child').textContent.toLowerCase();
                    const slug = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    
                    if (name.includes(searchQuery) || slug.includes(searchQuery)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection 