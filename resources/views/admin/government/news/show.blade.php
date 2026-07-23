@extends('layouts.admin')

@section('title', __('View News Article'))

@section('styles')
<style>
    .news-image {
        max-width: 100%;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    
    .news-tag {
        display: inline-block;
        background-color: #e9ecef;
        border-radius: 20px;
        padding: 2px 10px;
        margin-right: 5px;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('View News Article') }}</h1>
        <div>
            <a href="{{ route('admin.government.news.edit', $news->id) }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> {{ __('Edit') }}
            </a>
            <a href="{{ route('admin.government.news.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> {{ __('Back to List') }}
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $news->title }}</h6>
                </div>
                <div class="card-body">
                    @if($news->featured_image)
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/' . $news->featured_image) }}" alt="{{ $news->title }}" class="news-image">
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <h4>{{ __('Content') }}</h4>
                        <div class="border rounded p-3 bg-light">
                            {!! $news->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Details') }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>{{ __('Status') }}:</strong>
                        @if($news->status === 'published')
                            <span class="badge bg-success">{{ ucfirst($news->status) }}</span>
                        @elseif($news->status === 'draft')
                            <span class="badge bg-warning">{{ ucfirst($news->status) }}</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($news->status) }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Published Date') }}:</strong>
                        <p>{{ $news->published_at ? $news->published_at->format('F d, Y H:i') : __('Not published yet') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Category') }}:</strong>
                        <p>{{ $news->category ? $news->category->name : __('No category') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Department') }}:</strong>
                        <p>{{ $news->department ? $news->department->name : __('No department') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Author') }}:</strong>
                        <p>{{ $news->author ?? __('No author specified') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Views') }}:</strong>
                        <p>{{ $news->views }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Created') }}:</strong>
                        <p>{{ $news->created_at->format('F d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Last Updated') }}:</strong>
                        <p>{{ $news->updated_at->format('F d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Features') }}:</strong>
                        <ul class="list-unstyled">
                            <li>
                                @if($news->is_featured)
                                    <i class="fas fa-check-circle text-success"></i> {{ __('Featured Article') }}
                                @else
                                    <i class="fas fa-times-circle text-secondary"></i> {{ __('Not Featured') }}
                                @endif
                            </li>
                            <li>
                                @if($news->is_ticker ?? false)
                                    <i class="fas fa-check-circle text-success"></i> {{ __('Shows in News Ticker') }}
                                @else
                                    <i class="fas fa-times-circle text-secondary"></i> {{ __('Not in News Ticker') }}
                                @endif
                            </li>
                            <li>
                                @if($news->is_critical ?? false)
                                    <i class="fas fa-check-circle text-success"></i> {{ __('Critical News (Yellow)') }}
                                @else
                                    <i class="fas fa-times-circle text-secondary"></i> {{ __('Regular News') }}
                                @endif
                            </li>
                        </ul>
                    </div>
                    
                    @if($news->tags && $news->tags->count() > 0)
                        <div class="mb-3">
                            <strong>{{ __('Tags') }}:</strong>
                            <div class="mt-2">
                                @foreach($news->tags as $tag)
                                    <span class="news-tag">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection