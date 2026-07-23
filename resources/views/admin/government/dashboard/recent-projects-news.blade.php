<!-- Recent Projects and News -->
<div class="row dashboard-row">
    <!-- Recent Projects -->
    <div class="col-md-6">
        <div class="card h-100 mb-4 mb-md-0">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="card-title mb-2 mb-md-0">{{ __('Recent Projects') }}</h5>
                <a href="{{ route('admin.government.projects.index') }}" class="btn btn-sm btn-outline-warning mt-2 mt-md-0">
                    {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentProjects as $project)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="item-content mb-2 mb-md-0 d-flex align-items-center">
                                    <i class="fas fa-project-diagram text-warning me-2"></i>
                                    <div>
                                        <span class="fw-medium">{{ Str::limit($project->title, 40) }}</span>
                                        <span class="badge bg-{{ $project->status == 'active' ? 'success' : ($project->status == 'completed' ? 'primary' : 'secondary') }} ms-2">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="btn-action-group">
                                    <a href="{{ route('admin.government.projects.show', $project) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.government.projects.edit', $project) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4">
                            <i class="fas fa-project-diagram text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="mb-0">{{ __('No projects found') }}</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent News -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="card-title mb-2 mb-md-0">{{ __('Recent News') }}</h5>
                <a href="{{ route('admin.government.news.index') }}" class="btn btn-sm btn-outline-danger mt-2 mt-md-0">
                    {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentNews as $news)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="item-content mb-2 mb-md-0 d-flex align-items-center">
                                    <i class="fas fa-newspaper text-danger me-2"></i>
                                    <div>
                                        <span class="fw-medium">{{ Str::limit($news->title, 40) }}</span>
                                        <span class="badge bg-{{ $news->status == 'published' ? 'success' : ($news->status == 'draft' ? 'warning' : 'secondary') }} ms-2">
                                            {{ ucfirst($news->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="btn-action-group">
                                    <a href="{{ route('admin.government.news.show', $news) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.government.news.edit', $news) }}" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4">
                            <i class="fas fa-newspaper text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="mb-0">{{ __('No news found') }}</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div> 