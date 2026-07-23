@extends('layouts.admin')

@section('title', __('Testimonials'))

@section('styles')
<style>
    .testimonial-list-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    
    .testimonial-list-item:hover {
        border-left-color: var(--primary);
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .testimonial-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    
    .testimonial-status.active {
        background-color: #28a745;
    }
    
    .testimonial-status.inactive {
        background-color: #dc3545;
    }
    
    .featured-badge {
        background-color: #dc3545;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin-left: 5px;
    }
    
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Testimonials') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Testimonials') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="mb-0">{{ __('Manage Testimonials') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Create, edit, and manage testimonials from citizens and stakeholders.') }}</p>
                </div>
                <a href="{{ route('admin.government.testimonials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Testimonial') }}
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
                            <th>{{ __('Author') }}</th>
                            <th>{{ __('Content') }}</th>
                            <th>{{ __('Rating') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th style="width: 180px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr class="testimonial-list-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->photo)
                                            <div class="me-3">
                                                <img src="{{ asset('images/' . $testimonial->photo) }}" alt="{{ $testimonial->author_name }}" class="avatar">
                                            </div>
                                        @else
                                            <div class="me-3">
                                                <div class="avatar bg-secondary d-flex align-items-center justify-content-center text-white">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $testimonial->author_name }}</strong>
                                            @if($testimonial->is_featured)
                                                <span class="badge featured-badge">{{ __('Featured') }}</span>
                                            @endif
                                            <div class="small text-muted">{{ $testimonial->author_title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ Str::limit($testimonial->content, 100) }}
                                </td>
                                <td>
                                    @if($testimonial->rating)
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-muted"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-1">{{ $testimonial->rating }}/5</span>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ __('No rating') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="testimonial-status {{ $testimonial->status }}"></span>
                                    {{ ucfirst($testimonial->status) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin.government.testimonials.show', $testimonial) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.government.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.government.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this testimonial?') }}');">
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
                                <td colspan="5" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-comment-dots text-muted mb-2" style="font-size: 2.5rem;"></i>
                                        <h5>{{ __('No testimonials found') }}</h5>
                                        <p class="text-muted">{{ __('Start by adding your first testimonial') }}</p>
                                        <a href="{{ route('admin.government.testimonials.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> {{ __('Add Testimonial') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 