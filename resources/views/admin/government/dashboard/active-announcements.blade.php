<!-- Announcement News -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">{{ __('Announcements') }}</h5>
                <a href="{{ route('admin.government.news.index') }}?category=announcement" class="btn btn-sm btn-outline-info">
                    {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">{{ __('Title') }}</th>
                                <th class="px-4 py-3">{{ __('Category') }}</th>
                                <th class="px-4 py-3">{{ __('Status') }}</th>
                                <th class="px-4 py-3">{{ __('Published Date') }}</th>
                                <th class="px-4 py-3">{{ __('Department') }}</th>
                                <th class="px-4 py-3 text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcementNews as $news)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-bullhorn text-{{ $news->is_critical ? 'danger' : 'info' }} me-2"></i>
                                            <span class="fw-medium">{{ Str::limit($news->title, 40) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-info">
                                            {{ $news->category->name ?? 'Announcement' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-{{ $news->status == 'published' ? 'success' : ($news->status == 'draft' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($news->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt text-muted me-2"></i>
                                            <span>{{ $news->published_at ? $news->published_at->format('d M Y') : '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($news->department)
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-building text-primary me-2"></i>
                                                <span>{{ $news->department->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.government.news.show', $news) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.government.news.edit', $news) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-bullhorn text-muted mb-3" style="font-size: 2.5rem;"></i>
                                            <h5 class="mb-1">{{ __('No announcements found') }}</h5>
                                            <p class="text-muted">{{ __('Create news with the Announcement category to display them here') }}</p>
                                            <a href="{{ route('admin.government.news.create') }}" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-plus me-1"></i> {{ __('Create News Article') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 