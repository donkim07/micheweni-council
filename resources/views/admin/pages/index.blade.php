@extends('layouts.admin')

@section('title', __('Pages'))

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
                            <h2 class="section-heading">{{ __('Pages Management') }}</h2>
                            <p class="text-muted">{{ __('Create, edit and manage website pages') }}</p>
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Add New Page') }}
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
                        <h5 class="mb-0 fw-bold">{{ __('All Pages') }}</h5>
                        <div class="d-flex">
                            <div class="input-group me-3">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="page-search" class="form-control border-0 bg-light" placeholder="{{ __('Search pages...') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4 py-3">{{ __('Title') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Slug') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Template') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Status') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Last Updated') }}</th>
                                    <th class="border-0 px-4 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pages as $page)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-light rounded-circle p-2 me-3">
                                                <i class="fas fa-file-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <span class="fw-medium">{{ $page->title }}</span>
                                                @if($page->parent)
                                                    <div class="text-muted small">{{ __('Parent') }}: {{ $page->parent->title }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-muted">{{ $page->slug }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark">{{ $page->template }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($page->is_active)
                                            <span class="badge bg-success-soft text-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-warning-soft text-warning">{{ __('Draft') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-muted me-2"></i>
                                            <span>{{ $page->updated_at->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.pages.show', $page->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye me-1"></i> 
                                            </a>
                                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="if(confirm('{{ __('Are you sure you want to delete this page?') }}')) document.getElementById('delete-form-{{ $page->id }}').submit();">
                                                <i class="fas fa-trash"></i> 
                                            </button>
                                            <form id="delete-form-{{ $page->id }}" action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center p-5">
                                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('No pages found.') }}</p>
                                        <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i>{{ __('Add Page') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $pages->links() }}
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
        const searchInput = document.getElementById('page-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchQuery = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(function(row) {
                    const title = row.querySelector('td:first-child').textContent.toLowerCase();
                    const slug = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    
                    if (title.includes(searchQuery) || slug.includes(searchQuery)) {
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