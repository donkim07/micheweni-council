@extends('government.layouts.app')

@section('title', $category->name ?? 'Publications Category')

@section('styles')
<style>
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
    
    .publication-info {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
    
    .publication-info i {
        margin-right: 5px;
        color: var(--primary);
    }
    
    .publication-info span {
        margin-right: 15px;
    }
    
    .publication-title {
        color: var(--primary);
        font-weight: 600;
    }
    
    .publication-category {
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 10px;
    }
    
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(20, 78, 115, 0.8)), url('/images/government/publications-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .publications-filter {
        background-color: var(--light);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .file-size {
        font-size: 0.8rem;
        color: #666;
    }
    
    .file-type-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .badge-pdf {
        background-color: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }
    
    .badge-doc {
        background-color: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }
    
    .badge-xls {
        background-color: rgba(39, 174, 96, 0.1);
        color: #27ae60;
    }
    
    .badge-ppt {
        background-color: rgba(230, 126, 34, 0.1);
        color: #e67e22;
    }
    
    .badge-default {
        background-color: rgba(127, 140, 141, 0.1);
        color: #7f8c8d;
    }
    
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
    
    .category-link .badge {
        float: right;
        background-color: var(--primary);
        color: white;
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Government Publications</h1>
                <p class="lead mb-4">Access official documents, reports, policies, and other publications issued by the Micheweni District Council.</p>
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
                    <h5 class="mb-0">Publication Categories</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ url('/government/publications') }}" class="category-link {{ !request('category') ? 'active' : '' }}">
                            <i class="fas fa-folder"></i> All Publications
                            <span class="badge rounded-pill">{{ $totalPublications ?? count($publications ?? []) }}</span>
                        </a>
                        
                        @foreach($categories as $category)
                        <a href="{{ url('/government/publications?category=' . $category->id) }}" 
                           class="category-link {{ request('category') == $category->id ? 'active' : '' }}">
                            <i class="fas {{ $category->icon ?? 'fa-file-alt' }}"></i> 
                            {{ $category->name }}
                            <span class="badge rounded-pill">{{ $category->publications_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Quick Filters</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/government/publications') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search publications..." value="{{ request('search') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select class="form-select" id="year" name="year">
                                <option value="">All Years</option>
                                @for($year = date('Y'); $year >= 2010; $year--)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file_type" class="form-label">File Type</label>
                            <select class="form-select" id="file_type" name="file_type">
                                <option value="">All Types</option>
                                <option value="pdf" {{ request('file_type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="doc" {{ request('file_type') == 'doc' ? 'selected' : '' }}>Word (DOC/DOCX)</option>
                                <option value="xls" {{ request('file_type') == 'xls' ? 'selected' : '' }}>Excel (XLS/XLSX)</option>
                                <option value="ppt" {{ request('file_type') == 'ppt' ? 'selected' : '' }}>PowerPoint (PPT/PPTX)</option>
                                <option value="other" {{ request('file_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i> Apply Filters
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Publications List -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">
                    @if(request('category') && isset($currentCategory))
                        {{ $currentCategory->name }}
                    @else
                        All Publications
                    @endif
                </h2>
                
                <div class="d-flex align-items-center">
                    <label for="sort" class="me-2 mb-0">Sort by:</label>
                    <select class="form-select form-select-sm" id="sort" name="sort" style="width: auto;">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>A-Z</option>
                        <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
            </div>
            
            @if(request('search') || request('year') || request('file_type'))
                <div class="alert alert-info mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-filter me-2"></i> 
                            Showing filtered results 
                            @if(request('search'))
                                for "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if(request('year'))
                                from <strong>{{ request('year') }}</strong>
                            @endif
                            @if(request('file_type'))
                                in <strong>{{ strtoupper(request('file_type')) }}</strong> format
                            @endif
                        </div>
                        <a href="{{ url('/government/publications' . (request('category') ? '?category=' . request('category') : '')) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-times me-1"></i> Clear Filters
                        </a>
                    </div>
                </div>
            @endif
            
            @if($publications->count() > 0)
                <div class="row g-4">
                    @foreach($publications as $publication)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card publication-card h-100 position-relative">
                            @php
                                $fileExtension = pathinfo($publication->file_path, PATHINFO_EXTENSION);
                                $fileType = in_array($fileExtension, ['pdf']) ? 'pdf' :
                                            (in_array($fileExtension, ['doc', 'docx']) ? 'doc' :
                                            (in_array($fileExtension, ['xls', 'xlsx', 'csv']) ? 'xls' :
                                            (in_array($fileExtension, ['ppt', 'pptx']) ? 'ppt' : 'default')));
                            @endphp
                            
                            <span class="file-type-badge badge-{{ $fileType }}">
                                {{ strtoupper($fileExtension) }}
                            </span>
                            
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <i class="fas fa-file-{{ $fileType }} publication-icon icon-{{ $fileType }}"></i>
                                </div>
                                
                                @if($publication->category)
                                    <div class="publication-category text-center mb-2">
                                        <i class="fas fa-tag me-1"></i> {{ $publication->category->name }}
                                    </div>
                                @endif
                                
                                <h5 class="card-title publication-title text-center mb-3">{{ $publication->title }}</h5>
                                
                                <div class="publication-info">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ \Carbon\Carbon::parse($publication->published_date)->format('M d, Y') }}</span>
                                </div>
                                
                                @if($publication->file_size)
                                <div class="publication-info">
                                    <i class="fas fa-hdd"></i>
                                    <span class="file-size">
                                        @if($publication->file_size < 1024)
                                            {{ $publication->file_size }} KB
                                        @else
                                            {{ round($publication->file_size / 1024, 2) }} MB
                                        @endif
                                    </span>
                                </div>
                                @endif
                                
                                <p class="card-text mt-2">{{ Str::limit($publication->description, 100) }}</p>
                                
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="{{ route('government.publications.show', $publication->id) }}" class="btn btn-outline-primary me-2">
                                        <i class="fas fa-info-circle me-1"></i> Details
                                    </a>
                                    <a href="{{ asset('images/' . $publication->file_path) }}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-5">
                    {{ $publications->links() }}
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i> No publications found matching your criteria. Please try a different search or browse all available publications.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto submit form when sorting changes
        document.getElementById('sort').addEventListener('change', function() {
            // Get current URL and parameters
            var url = new URL(window.location.href);
            var params = new URLSearchParams(url.search);
            
            // Update or add the sort parameter
            params.set('sort', this.value);
            
            // Redirect to the new URL
            window.location.href = url.pathname + '?' + params.toString();
        });
        
        // Auto submit form when year filter changes
        document.getElementById('year').addEventListener('change', function() {
            this.form.submit();
        });
        
        // Auto submit form when file type filter changes
        document.getElementById('file_type').addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endsection 