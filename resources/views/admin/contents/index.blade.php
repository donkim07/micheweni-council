@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Content Blocks') }}</h5>
                    <a href="{{ route('admin.contents.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> {{ __('Add New') }}
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive admin-contents-table">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('Identifier') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Page') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contents as $content)
                                <tr>
                                    <td>{{ $content->id }}</td>
                                    <td><code>{{ $content->identifier }}</code></td>
                                    <td>
                                        <strong>{{ $content->title ?: __('(No title)') }}</strong>
                                        @if($content->title_sw)
                                            <br><small class="text-muted">SW: {{ $content->title_sw }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $content->page ? $content->page->title : __('Global') }}</td>
                                    <td>{{ ucfirst($content->type) }}</td>
                                    <td>
                                        @if($content->is_active)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-action-group">
                                            <a href="{{ route('admin.contents.edit', $content) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> 
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="event.preventDefault(); 
                                                document.getElementById('delete-form-{{ $content->id }}').submit();">
                                                <i class="fas fa-trash me-1"></i> 
                                            </button>
                                            <form id="delete-form-{{ $content->id }}" action="{{ route('admin.contents.destroy', $content) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No content blocks found') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $contents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 