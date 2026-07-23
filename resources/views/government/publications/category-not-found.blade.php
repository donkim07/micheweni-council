@extends('government.layouts.app')

@section('title', __('Publications - ' . $category))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/publications-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .publication-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .publication-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .publication-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--primary);
    }
    
    .icon-pdf { color: #e74c3c; }
    .icon-doc { color: #3498db; }
    .icon-xls { color: #27ae60; }
    .icon-ppt { color: #e67e22; }
    .icon-zip { color: #8e44ad; }
    .icon-default { color: #7f8c8d; }
    
    .category-link {
        display: block;
        padding: 10px 15px;
        margin-bottom: 5px;
        border-radius: 5px;
        text-decoration: none;
        color: var(--dark);
        transition: all 0.2s ease;
    }
    
    .category-link:hover, .category-link.active {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        padding-left: 20px;
    }
    
    .category-link i {
        margin-right: 10px;
        color: var(--primary);
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/publications') }}" class="text-white">Publications</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $category }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $category }} Publications</h1>
                <p class="lead mb-4">{{ __('Access official documents, reports, policies, and other publications issued by the Micheweni District Council.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Publication Categories') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ url('/government/publications') }}" class="category-link">
                            <i class="fas fa-folder"></i> {{ __('All Publications') }}
                        </a>
                        
                        @if(isset($availableCategories) && count($availableCategories) > 0)
                            @foreach($availableCategories as $availableCategory)
                                <a href="{{ url('/government/publications/' . $availableCategory) }}" 
                                class="category-link {{ $category == ucfirst($availableCategory) ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i> {{ ucfirst($availableCategory) }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Not Found Content -->
        <div class="col-lg-9">
            <div class="alert alert-info mb-4">
                <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i>{{ __('No Publications Found') }}</h4>
                <p>{{ __('We currently don\'t have any publications in the') }} <strong>{{ $category }}</strong> {{ __('category.') }}</p>
                <p class="mb-0">{{ __('Please check out our other publication categories or browse all available publications.') }}</p>
            </div>
            
            @if(isset($otherPublications) && $otherPublications->count() > 0)
                <h3 class="mb-4">{{ __('You might be interested in these publications:') }}</h3>
                
                <div class="row g-4">
                    @foreach($otherPublications as $publication)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card publication-card h-100 position-relative">
                                @php
                                    $fileExtension = pathinfo($publication->file_path, PATHINFO_EXTENSION);
                                    $fileType = in_array($fileExtension, ['pdf']) ? 'pdf' :
                                                (in_array($fileExtension, ['doc', 'docx']) ? 'doc' :
                                                (in_array($fileExtension, ['xls', 'xlsx', 'csv']) ? 'xls' :
                                                (in_array($fileExtension, ['ppt', 'pptx']) ? 'ppt' : 'default')));
                                @endphp
                                
                                <span class="badge bg-secondary position-absolute top-0 end-0 m-2">
                                    {{ strtoupper($fileExtension) }}
                                </span>
                                
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-file-{{ $fileType }} publication-icon icon-{{ $fileType }}"></i>
                                    </div>
                                    
                                    @if($publication->category)
                                        <div class="badge bg-light text-dark mb-2">
                                            {{ ucfirst($publication->category) }}
                                        </div>
                                    @endif
                                    
                                    <h5 class="card-title mb-3">{{ $publication->title }}</h5>
                                    
                                    <p class="card-text small">{{ Str::limit($publication->description, 80) }}</p>
                                    
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{ route('government.publications.show', $publication->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-info-circle me-1"></i> {{ __('Details') }}
                                        </a>
                                        <a href="{{ asset('images/' . $publication->file_path) }}" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-download me-1"></i> {{ __('Download') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <div class="mt-5 text-center">
                <a href="{{ url('/government/publications') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> {{ __('Browse All Publications') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 