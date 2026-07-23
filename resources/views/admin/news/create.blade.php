@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Add New Article') }}</h5>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
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
                                <div class="mb-3">
                                    <x-input-label for="title" :value="__('Title')" />
                                    <x-text-input id="title" name="title" type="text" class="form-control" :value="old('title')" required autofocus />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="excerpt" :value="__('Excerpt')" />
                                    <textarea id="excerpt" name="excerpt" class="form-control" rows="3">{{ old('excerpt') }}</textarea>
                                    <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="content" :value="__('Content')" />
                                    <textarea id="content" name="content" class="form-control editor" rows="10">{{ old('content') }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="swahili" role="tabpanel" aria-labelledby="swahili-tab">
                                <div class="mb-3">
                                    <x-input-label for="title_sw" :value="__('Title (Swahili)')" />
                                    <x-text-input id="title_sw" name="title_sw" type="text" class="form-control" :value="old('title_sw')" />
                                    <x-input-error :messages="$errors->get('title_sw')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="excerpt_sw" :value="__('Excerpt (Swahili)')" />
                                    <textarea id="excerpt_sw" name="excerpt_sw" class="form-control" rows="3">{{ old('excerpt_sw') }}</textarea>
                                    <x-input-error :messages="$errors->get('excerpt_sw')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3">
                                    <x-input-label for="content_sw" :value="__('Content (Swahili)')" />
                                    <textarea id="content_sw" name="content_sw" class="form-control editor" rows="10">{{ old('content_sw') }}</textarea>
                                    <x-input-error :messages="$errors->get('content_sw')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="category_id" :value="__('Category')" />
                                    <select id="category_id" name="category_id" class="form-select">
                                        <option value="">{{ __('-- Select Category --') }}</option>
                                        @foreach($categories as $id => $name)
                                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="featured_image" :value="__('Featured Image')" />
                                    <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*" />
                                    <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">{{ __('Publish immediately') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="published_at" :value="__('Scheduled Publish Date')" />
                                    <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at') }}" />
                                    <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Save Article') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editorElements = document.querySelectorAll('.editor');
        
        editorElements.forEach(element => {
            ClassicEditor
                .create(element)
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>
@endpush 