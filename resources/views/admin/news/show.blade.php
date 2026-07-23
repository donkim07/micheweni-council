@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('View Article') }}</h5>
                    <div>
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <ul class="nav nav-tabs mb-3" id="langTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab" aria-controls="english" aria-selected="true">English</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="swahili-tab" data-bs-toggle="tab" data-bs-target="#swahili" type="button" role="tab" aria-controls="swahili" aria-selected="false">Swahili</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="langTabContent">
                        <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                            <div class="mb-4">
                                <h2>{{ $news->title }}</h2>
                                
                                @if($news->excerpt)
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <p class="mb-0"><em>{{ $news->excerpt }}</em></p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="content-body mt-4">
                                    {!! $news->content !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="swahili" role="tabpanel" aria-labelledby="swahili-tab">
                            <div class="mb-4">
                                <h2>{{ $news->title_sw ?: '(No Swahili title provided)' }}</h2>
                                
                                @if($news->excerpt_sw)
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <p class="mb-0"><em>{{ $news->excerpt_sw }}</em></p>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        {{ __('No Swahili excerpt provided') }}
                                    </div>
                                @endif
                                
                                <div class="content-body mt-4">
                                    @if($news->content_sw)
                                        {!! $news->content_sw !!}
                                    @else
                                        <div class="alert alert-warning">
                                            {{ __('No Swahili content provided') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ __('Article Details') }}</h5>
                            <table class="table table-bordered mt-3">
                                <tbody>
                                    <tr>
                                        <th style="width: 150px;">{{ __('Category') }}</th>
                                        <td>{{ $news->category ? $news->category->name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Author') }}</th>
                                        <td>{{ $news->author->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Status') }}</th>
                                        <td>
                                            @if($news->is_published)
                                                <span class="badge bg-success">{{ __('Published') }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ __('Draft') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Published Date') }}</th>
                                        <td>{{ $news->published_at ? $news->published_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Created') }}</th>
                                        <td>{{ $news->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Last Updated') }}</th>
                                        <td>{{ $news->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ __('Featured Image') }}</h5>
                            @if($news->featured_image)
                                <div class="mt-3 text-center">
                                    <img src="{{ asset('images/' . $news->featured_image) }}" 
                                        alt="{{ $news->title }}" 
                                        class="img-fluid rounded" 
                                        style="max-height: 300px;">
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    {{ __('No featured image uploaded') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 