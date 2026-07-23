@extends('government.layouts.app')

@section('title', __('Search Results for') . ' "' . $query . '"')
@section('meta_description', __('Search results for') . ' "' . $query . '" ' . __('on Micheweni District Council website'))

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ __('Search Results for') }} "{{ $query }}"</h1>
            <p class="text-muted">{{ __('Found') }} {{ $totalResults }} {{ __('results') }}</p>
            
            @if($totalResults == 0)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> {{ __('No results found for your search query.') }}
                </div>
                <p>{{ __('Suggestions:') }}</p>
                <ul>
                    <li>{{ __('Check your spelling') }}</li>
                    <li>{{ __('Try more general keywords') }}</li>
                    <li>{{ __('Try different keywords') }}</li>
                </ul>
            @endif
        </div>
    </div>
    
    <!-- Services Results -->
    @if($services->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-3">{{ __('Services') }} ({{ $services->count() }})</h2>
                <div class="list-group mb-4">
                    @foreach($services as $service)
                        <a href="{{ url('/government/services/' . $service->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="service-icon-sm d-flex align-items-center justify-content-center bg-light rounded-circle me-3">
                                    @php
                                        // Default icons based on department
                                        $defaultIcons = [
                                            'health' => 'fa-heartbeat',
                                            'education' => 'fa-graduation-cap',
                                            'finance' => 'fa-money-bill-wave',
                                            'infrastructure' => 'fa-road',
                                            'environment' => 'fa-leaf',
                                            'water' => 'fa-tint',
                                            'agriculture' => 'fa-seedling',
                                            'social' => 'fa-users',
                                            'tourism' => 'fa-umbrella-beach',
                                        ];
                                        
                                        $icon = 'fa-cog'; // Default fallback
                                        
                                        if ($service->icon) {
                                            $icon = $service->icon;
                                        } elseif ($service->department) {
                                            $deptSlug = strtolower(str_replace(' ', '-', $service->department->slug));
                                            // Try to match department name with default icons
                                            foreach($defaultIcons as $key => $value) {
                                                if(strpos($deptSlug, $key) !== false) {
                                                    $icon = $value;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $service->title }}</h5>
                                    <p class="mb-1 small text-muted">{{ $service->department ? $service->department->name : __('General Services') }}</p>
                                    <p class="mb-0">{{ Str::limit(strip_tags($service->description), 150) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- Departments Results -->
    @if($departments->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-3">{{ __('Departments') }} ({{ $departments->count() }})</h2>
                <div class="list-group mb-4">
                    @foreach($departments as $department)
                        <a href="{{ url('/government/departments/' . $department->slug) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="department-icon-sm d-flex align-items-center justify-content-center bg-light rounded-circle me-3">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $department->name }}</h5>
                                    <p class="mb-0">{{ Str::limit(strip_tags($department->description), 150) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- News Results -->
    @if($news->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-3">{{ __('News') }} ({{ $news->count() }})</h2>
                <div class="list-group mb-4">
                    @foreach($news as $article)
                        <a href="{{ url('/government/news-new/' . $article->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="news-thumbnail me-3">
                                    <img src="{{ asset('images/' . $article->featured_image) }}" alt="{{ $article->title }}" class="img-fluid rounded" style="width: 100px; height: 70px; object-fit: cover;" onerror="this.src='/images/government/news/default-news.jpg'">
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $article->title }}</h5>
                                    <p class="mb-1 small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('F d, Y') }}
                                        @if($article->category)
                                            <span class="ms-2"><i class="fas fa-tag me-1"></i> {{ $article->category->name }}</span>
                                        @endif
                                    </p>
                                    <p class="mb-0">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- Projects Results -->
    @if($projects->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-3">{{ __('Projects') }} ({{ $projects->count() }})</h2>
                <div class="list-group mb-4">
                    @foreach($projects as $project)
                        <a href="{{ url('/government/projects/' . $project->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="project-thumbnail me-3">
                                    <img src="{{ asset('images/' . $project->featured_image) }}" alt="{{ $project->title }}" class="img-fluid rounded" style="width: 100px; height: 70px; object-fit: cover;" onerror="this.src='/images/government/projects/default-project.jpg'">
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $project->title }}</h5>
                                    <p class="mb-1 small text-muted">
                                        <span class="badge {{ $project->status == 'Completed' ? 'bg-success' : ($project->status == 'In Progress' ? 'bg-primary' : 'bg-warning') }}">
                                            {{ $project->status }}
                                        </span>
                                        @if($project->department)
                                            <span class="ms-2"><i class="fas fa-building me-1"></i> {{ $project->department->name }}</span>
                                        @endif
                                    </p>
                                    <p class="mb-0">{{ Str::limit(strip_tags($project->description), 150) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- Publications Results -->
    @if($publications->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-3">{{ __('Publications') }} ({{ $publications->count() }})</h2>
                <div class="list-group mb-4">
                    @foreach($publications as $publication)
                        <a href="{{ url('/government/publications/' . $publication->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="publication-icon-sm d-flex align-items-center justify-content-center bg-light rounded-circle me-3">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $publication->title }}</h5>
                                    <p class="mb-1 small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $publication->published_date ? $publication->published_date->format('F d, Y') : __('N/A') }}
                                        @if($publication->category && is_object($publication->category))
                                            <span class="ms-2"><i class="fas fa-folder me-1"></i> {{ $publication->category->name }}</span>
                                        @elseif($publication->category && is_string($publication->category))
                                            <span class="ms-2"><i class="fas fa-folder me-1"></i> {{ $publication->category }}</span>
                                        @endif
                                    </p>
                                    <p class="mb-0">{{ Str::limit(strip_tags($publication->description), 150) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- Announcements Results -->
    @if($announcements->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h2 class="h4 mb-3">{{ __('Announcements') }} ({{ $announcements->count() }})</h2>
                <div class="list-group mb-4">
                    @foreach($announcements as $announcement)
                        <a href="{{ url('/government/announcements/' . $announcement->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="announcement-icon-sm d-flex align-items-center justify-content-center bg-light rounded-circle me-3">
                                    <i class="fas fa-bullhorn {{ $announcement->is_urgent ? 'text-danger' : 'text-primary' }}"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">
                                        {{ $announcement->title }}
                                        @if($announcement->is_urgent)
                                            <span class="badge bg-danger ms-2">{{ __('Urgent') }}</span>
                                        @endif
                                    </h5>
                                    <p class="mb-1 small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $announcement->created_at->format('F d, Y') }}
                                    </p>
                                    <p class="mb-0">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .service-icon-sm, .department-icon-sm, .announcement-icon-sm, .publication-icon-sm {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }
    
    .list-group-item-action:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }
</style>
@endsection 