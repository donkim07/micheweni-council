@extends('government.layouts.app')

@section('title', $publication->title)

@section('styles')
<style>
    .publication-header {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), 
                    url('/images/government/publication-detail-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .publication-category {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 0.85rem;
        padding: 5px 15px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .publication-preview {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        background-color: white;
        position: relative;
    }
    
    .publication-preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .publication-preview:hover .publication-preview-overlay {
        opacity: 1;
    }
    
    .publication-preview-image {
        width: 100%;
        height: 400px;
        object-fit: contain;
    }
    
    .publication-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .publication-meta-item {
        display: flex;
        align-items: center;
        margin-right: 20px;
        margin-bottom: 10px;
        color: #666;
    }
    
    .publication-meta-item i {
        margin-right: 8px;
        color: var(--primary);
    }
    
    .file-info-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .file-info-header {
        background-color: var(--primary);
        color: white;
        padding: 15px 20px;
    }
    
    .file-info-item {
        display: flex;
        border-bottom: 1px solid #eee;
        padding: 12px 15px;
    }
    
    .file-info-item:last-child {
        border-bottom: none;
    }
    
    .file-info-label {
        width: 140px;
        font-weight: 600;
        color: var(--primary);
    }
    
    .file-info-value {
        flex: 1;
    }
    
    .publication-actions {
        margin-top: 20px;
    }
    
    .publication-actions .btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .publication-content {
        line-height: 1.8;
    }
    
    .related-publications {
        margin-top: 40px;
    }
    
    .related-publication-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .related-publication-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .related-publication-icon {
        font-size: 2rem;
        margin-bottom: 15px;
        color: var(--primary);
    }
    
    .icon-pdf { color: #e74c3c; }
    .icon-doc { color: #3498db; }
    .icon-xls { color: #27ae60; }
    .icon-ppt { color: #e67e22; }
    .icon-default { color: #7f8c8d; }
    
    .related-publication-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--primary);
    }
    
    .sidebar-card {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border: none;
    }
    
    .sidebar-card-header {
        background-color: var(--primary);
        color: white;
        padding: 15px 20px;
        font-weight: 600;
    }
    
    .sidebar-list-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.2s ease;
    }
    
    .sidebar-list-item:last-child {
        border-bottom: none;
    }
    
    .sidebar-list-item:hover {
        background-color: rgba(20, 78, 115, 0.05);
    }
    
    .sidebar-list-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 5px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.2rem;
    }
    
    .sidebar-list-item-content h6 {
        font-size: 0.9rem;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    
    .sidebar-list-item-meta {
        font-size: 0.8rem;
        color: #666;
    }
</style>
@endsection

@section('content')
<!-- Publication Header -->
<div class="publication-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/publications') }}" class="text-white">Publications</a></li>
                        @if($publication->category)
                            <li class="breadcrumb-item"><a href="{{ url('/government/publications?category=' . $publication->category) }}" class="text-white">{{ ucfirst($publication->category) }}</a></li>
                        @endif
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($publication->title, 40) }}</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">{{ $publication->title }}</h1>
                
                @if($publication->category)
                    <span class="publication-category">
                        <i class="fas fa-folder me-1"></i> {{ ucfirst($publication->category) }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Main Publication Content -->
        <div class="col-lg-8">
            <!-- File Preview -->
            @php
                $fileExtension = pathinfo($publication->file_path, PATHINFO_EXTENSION);
                $fileType = in_array($fileExtension, ['pdf']) ? 'pdf' :
                            (in_array($fileExtension, ['doc', 'docx']) ? 'doc' :
                            (in_array($fileExtension, ['xls', 'xlsx', 'csv']) ? 'xls' :
                            (in_array($fileExtension, ['ppt', 'pptx']) ? 'ppt' : 'default')));
                $isPDF = $fileType === 'pdf';
            @endphp
            
            <div class="publication-preview">
                @if($isPDF)
                    <embed src="{{ asset('images/' . $publication->file_path) }}#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="400px" />
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 300px; background-color: #f8f9fa;">
                        <div class="text-center">
                            <i class="fas fa-file-{{ $fileType }} fa-5x mb-3 text-{{ $fileType == 'pdf' ? 'danger' : ($fileType == 'doc' ? 'primary' : ($fileType == 'xls' ? 'success' : ($fileType == 'ppt' ? 'warning' : 'secondary'))) }}"></i>
                            <h4>{{ strtoupper($fileExtension) }} File</h4>
                            <p class="text-muted">Preview not available for this file type.</p>
                        </div>
                    </div>
                @endif
                
                <div class="publication-preview-overlay">
                    <a href="{{ asset('images/' . $publication->file_path) }}" class="btn btn-light mb-3" target="_blank">
                        <i class="fas fa-eye me-2"></i> View Full Document
                    </a>
                    <a href="{{ asset('images/' . $publication->file_path) }}" class="btn btn-primary" download>
                        <i class="fas fa-download me-2"></i> Download
                    </a>
                </div>
            </div>
            
            <!-- Publication Metadata -->
            <div class="publication-meta">
                <div class="publication-meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Published: {{ \Carbon\Carbon::parse($publication->published_date)->format('M d, Y') }}</span>
                </div>
                
                @if($publication->author)
                <div class="publication-meta-item">
                    <i class="fas fa-user"></i>
                    <span>Author: {{ $publication->author }}</span>
                </div>
                @endif
                
                <div class="publication-meta-item">
                    <i class="fas fa-file-{{ $fileType }}"></i>
                    <span>Format: {{ strtoupper($fileExtension) }}</span>
                </div>
                
                @if($publication->file_size)
                <div class="publication-meta-item">
                    <i class="fas fa-hdd"></i>
                    <span>Size: 
                        @if($publication->file_size < 1024)
                            {{ $publication->file_size }} KB
                        @else
                            {{ round($publication->file_size / 1024, 2) }} MB
                        @endif
                    </span>
                </div>
                @endif
                
                <div class="publication-meta-item">
                    <i class="fas fa-download"></i>
                    <span>Downloads: {{ $publication->downloads ?? 0 }}</span>
                </div>
            </div>
            
            <!-- Publication Description -->
            <div class="publication-content mb-4">
                <h3 class="mb-3">Description</h3>
                <p>{!! nl2br(e($publication->description)) !!}</p>
            </div>
            
            <!-- Publication Actions -->
            <div class="publication-actions">
                <a href="{{ asset('images/' . $publication->file_path) }}" class="btn btn-primary" download>
                    <i class="fas fa-download me-2"></i> Download
                </a>
                
                <a href="{{ asset('images/' . $publication->file_path) }}" class="btn btn-outline-primary" target="_blank">
                    <i class="fas fa-eye me-2"></i> Open in New Tab
                </a>
                
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#shareModal">
                    <i class="fas fa-share-alt me-2"></i> Share
                </button>
                
                <a href="{{ url('/government/publications/report-issue/' . $publication->id) }}" class="btn btn-outline-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> Report Issue
                </a>
            </div>
            
            <!-- Related Publications -->
            @if(isset($relatedPublications) && $relatedPublications->count() > 0)
            <div class="related-publications">
                <h3 class="mb-4">Related Publications</h3>
                <div class="row g-4">
                    @foreach($relatedPublications as $related)
                    <div class="col-md-6">
                        <div class="card related-publication-card">
                            <div class="card-body text-center">
                                @php
                                    $relatedFileExtension = pathinfo($related->file_path, PATHINFO_EXTENSION);
                                    $relatedFileType = in_array($relatedFileExtension, ['pdf']) ? 'pdf' :
                                                      (in_array($relatedFileExtension, ['doc', 'docx']) ? 'doc' :
                                                      (in_array($relatedFileExtension, ['xls', 'xlsx', 'csv']) ? 'xls' :
                                                      (in_array($relatedFileExtension, ['ppt', 'pptx']) ? 'ppt' : 'default')));
                                @endphp
                                
                                <i class="fas fa-file-{{ $relatedFileType }} related-publication-icon icon-{{ $relatedFileType }}"></i>
                                
                                <h5 class="related-publication-title">{{ $related->title }}</h5>
                                
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="publication-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>{{ \Carbon\Carbon::parse($related->published_date)->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('government.publications.show', $related->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-info-circle me-1"></i> Details
                                </a>
                                <a href="{{ asset('images/' . $related->file_path) }}" class="btn btn-sm btn-primary" download>
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- File Information -->
            <div class="card file-info-card mb-4">
                <div class="file-info-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> File Information</h5>
                </div>
                <div class="card-body p-0">
                    <div class="file-info-item">
                        <div class="file-info-label">Title</div>
                        <div class="file-info-value">{{ $publication->title }}</div>
                    </div>
                    
                    @if($publication->category)
                    <div class="file-info-item">
                        <div class="file-info-label">Category</div>
                        <div class="file-info-value">{{ ucfirst($publication->category) }}</div>
                    </div>
                    @endif
                    
                    <div class="file-info-item">
                        <div class="file-info-label">File Type</div>
                        <div class="file-info-value">{{ strtoupper($fileExtension) }}</div>
                    </div>
                    
                    <div class="file-info-item">
                        <div class="file-info-label">Publication Date</div>
                        <div class="file-info-value">{{ \Carbon\Carbon::parse($publication->published_date)->format('M d, Y') }}</div>
                    </div>
                    
                    @if($publication->file_size)
                    <div class="file-info-item">
                        <div class="file-info-label">File Size</div>
                        <div class="file-info-value">
                            @if($publication->file_size < 1024)
                                {{ $publication->file_size }} KB
                            @else
                                {{ round($publication->file_size / 1024, 2) }} MB
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="file-info-item">
                        <div class="file-info-label">Downloads</div>
                        <div class="file-info-value">{{ $publication->downloads ?? 0 }}</div>
                    </div>
                    
                    @if($publication->author)
                    <div class="file-info-item">
                        <div class="file-info-label">Author</div>
                        <div class="file-info-value">{{ $publication->author }}</div>
                    </div>
                    @endif
                    
                    @if($publication->publisher)
                    <div class="file-info-item">
                        <div class="file-info-label">Publisher</div>
                        <div class="file-info-value">{{ $publication->publisher }}</div>
                    </div>
                    @endif
                    
                    @if($publication->language)
                    <div class="file-info-item">
                        <div class="file-info-label">Language</div>
                        <div class="file-info-value">{{ $publication->language }}</div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Latest Publications -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fas fa-file-alt me-2"></i> Latest Publications
                </div>
                <div class="card-body p-0">
                    @if(isset($latestPublications) && $latestPublications->count() > 0)
                        @foreach($latestPublications as $latest)
                        <a href="{{ route('government.publications.show', $latest->id) }}" class="text-decoration-none text-dark">
                            <div class="sidebar-list-item">
                                @php
                                    $latestFileExtension = pathinfo($latest->file_path, PATHINFO_EXTENSION);
                                    $latestFileType = in_array($latestFileExtension, ['pdf']) ? 'pdf' :
                                                     (in_array($latestFileExtension, ['doc', 'docx']) ? 'doc' :
                                                     (in_array($latestFileExtension, ['xls', 'xlsx', 'csv']) ? 'xls' :
                                                     (in_array($latestFileExtension, ['ppt', 'pptx']) ? 'ppt' : 'default')));
                                    $iconColorClass = $latestFileType == 'pdf' ? 'danger' : 
                                                     ($latestFileType == 'doc' ? 'primary' : 
                                                     ($latestFileType == 'xls' ? 'success' : 
                                                     ($latestFileType == 'ppt' ? 'warning' : 'secondary')));
                                @endphp
                                
                                <div class="sidebar-list-item-icon bg-light">
                                    <i class="fas fa-file-{{ $latestFileType }} text-{{ $iconColorClass }}"></i>
                                </div>
                                
                                <div class="sidebar-list-item-content">
                                    <h6>{{ Str::limit($latest->title, 60) }}</h6>
                                    <div class="sidebar-list-item-meta">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($latest->published_date)->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @else
                        <div class="p-3 text-center text-muted">
                            No publications available.
                        </div>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <a href="{{ url('/government/publications') }}" class="btn btn-sm btn-outline-primary">View All Publications</a>
                </div>
            </div>
            
            <!-- Categories -->
            <div class="card sidebar-card">
                <div class="sidebar-card-header">
                    <i class="fas fa-folder me-2"></i> Categories
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                        <a href="{{ url('/government/publications?category=' . $category->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">{{ $category->publications_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share this Publication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="shareLink" class="form-label">Publication Link</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareLink" value="{{ request()->url() }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copyLink">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-primary mx-2">
                        <i class="fab fa-facebook-f me-2"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($publication->title) }}" target="_blank" class="btn btn-outline-info mx-2">
                        <i class="fab fa-twitter me-2"></i> Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($publication->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-outline-success mx-2">
                        <i class="fab fa-whatsapp me-2"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy link functionality
        document.getElementById('copyLink').addEventListener('click', function() {
            var copyText = document.getElementById('shareLink');
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(copyText.value);
            
            var originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i>';
            
            setTimeout(function() {
                document.getElementById('copyLink').innerHTML = originalText;
            }, 2000);
        });
    });
</script>
@endsection 