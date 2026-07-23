@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Edit Content Block') }}</h5>
                    <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary btn-sm">
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

                    <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="identifier" :value="__('Identifier')" />
                                    <x-text-input id="identifier" name="identifier" type="text" class="form-control" :value="old('identifier', $content->identifier)" required />
                                    <small class="form-text text-muted">{{ __('Unique identifier for this content block (e.g. home_welcome, about_mission)') }}</small>
                                    <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <x-input-label for="type" :value="__('Content Type')" />
                                    <select id="type" name="type" class="form-select">
                                        <option value="text" {{ old('type', $content->type) == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                        <option value="html" {{ old('type', $content->type) == 'html' ? 'selected' : '' }}>{{ __('HTML') }}</option>
                                        <option value="image" {{ old('type', $content->type) == 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                                        <option value="form" {{ old('type', $content->type) == 'form' ? 'selected' : '' }}>{{ __('Form') }}</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <x-input-label for="is_active" :value="__('Status')" />
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $content->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-input-label for="page_id" :value="__('Associated Page')" />
                                    <select id="page_id" name="page_id" class="form-select">
                                        <option value="">{{ __('-- Global Content --') }}</option>
                                        @foreach($pages as $id => $title)
                                            <option value="{{ $id }}" {{ old('page_id', $content->page_id) == $id ? 'selected' : '' }}>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">{{ __('If this content belongs to a specific page, select it here') }}</small>
                                    <x-input-error :messages="$errors->get('page_id')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <x-input-label for="section" :value="__('Section')" />
                                    <x-text-input id="section" name="section" type="text" class="form-control" :value="old('section', $content->section)" />
                                    <small class="form-text text-muted">{{ __('Optional section identifier (e.g. header, sidebar)') }}</small>
                                    <x-input-error :messages="$errors->get('section')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <x-input-label for="order" :value="__('Display Order')" />
                                    <x-text-input id="order" name="order" type="number" class="form-control" :value="old('order', $content->order)" min="0" />
                                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        
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
                                    <x-text-input id="title" name="title" type="text" class="form-control" :value="old('title', $content->title)" />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3 content-field" id="text-content-en">
                                    <x-input-label for="content" :value="__('Content')" />
                                    <textarea id="content" name="content" class="form-control" rows="8">{{ old('content', $content->content) }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3 content-field d-none" id="html-content-en">
                                    <x-input-label for="content_html" :value="__('HTML Content')" />
                                    <textarea id="content_html" name="content" class="form-control editor" rows="8">{{ old('content', $content->content) }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3 content-field d-none" id="image-content-en">
                                    <x-input-label for="content_image" :value="__('Image')" />
                                    <input type="file" id="content_image" name="content_image" class="form-control" accept="image/*" />
                                    <x-input-error :messages="$errors->get('content_image')" class="mt-2" />
                                    
                                    @if($content->type == 'image' && $content->content)
                                        <div class="mt-2">
                                            <img src="{{ asset('images/' . $content->content) }}" class="img-thumbnail" style="max-height: 150px;">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                                <label class="form-check-label" for="remove_image">
                                                    {{ __('Remove current image') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mb-3 content-field d-none" id="form-content-en">
                                    <x-input-label for="form_builder_id" :value="__('Select Form')" />
                                    <select id="form_builder_id" name="form_builder_id" class="form-select">
                                        <option value="">{{ __('-- Select a Form --') }}</option>
                                        @foreach($forms as $id => $title)
                                            <option value="{{ $id }}" {{ old('form_builder_id', $content->form_builder_id) == $id ? 'selected' : '' }}>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('form_builder_id')" class="mt-2" />
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="swahili" role="tabpanel" aria-labelledby="swahili-tab">
                                <div class="mb-3">
                                    <x-input-label for="title_sw" :value="__('Title (Swahili)')" />
                                    <x-text-input id="title_sw" name="title_sw" type="text" class="form-control" :value="old('title_sw', $content->title_sw)" />
                                    <x-input-error :messages="$errors->get('title_sw')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3 content-field" id="text-content-sw">
                                    <x-input-label for="content_sw" :value="__('Content (Swahili)')" />
                                    <textarea id="content_sw" name="content_sw" class="form-control" rows="8">{{ old('content_sw', $content->content_sw) }}</textarea>
                                    <x-input-error :messages="$errors->get('content_sw')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3 content-field d-none" id="html-content-sw">
                                    <x-input-label for="content_html_sw" :value="__('HTML Content (Swahili)')" />
                                    <textarea id="content_html_sw" name="content_sw" class="form-control editor" rows="8">{{ old('content_sw', $content->content_sw) }}</textarea>
                                    <x-input-error :messages="$errors->get('content_sw')" class="mt-2" />
                                </div>
                                
                                <div class="mb-3 content-field d-none" id="image-content-sw">
                                    <x-input-label for="content_image_sw" :value="__('Image (Swahili)')" />
                                    <input type="file" id="content_image_sw" name="content_image_sw" class="form-control" accept="image/*" />
                                    <x-input-error :messages="$errors->get('content_image_sw')" class="mt-2" />
                                    
                                    @if($content->type == 'image' && $content->content_sw)
                                        <div class="mt-2">
                                            <img src="{{ asset('images/' . $content->content_sw) }}" class="img-thumbnail" style="max-height: 150px;">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="remove_image_sw" id="remove_image_sw" value="1">
                                                <label class="form-check-label" for="remove_image_sw">
                                                    {{ __('Remove current image') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Update Content Block') }}
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
        // Content type toggle
        const typeSelect = document.getElementById('type');
        const textContentEn = document.getElementById('text-content-en');
        const htmlContentEn = document.getElementById('html-content-en');
        const imageContentEn = document.getElementById('image-content-en');
        const formContentEn = document.getElementById('form-content-en');
        const textContentSw = document.getElementById('text-content-sw');
        const htmlContentSw = document.getElementById('html-content-sw');
        const imageContentSw = document.getElementById('image-content-sw');
        
        function toggleContentFields() {
            const contentType = typeSelect.value;
            
            // Hide all content fields
            textContentEn.classList.add('d-none');
            htmlContentEn.classList.add('d-none');
            imageContentEn.classList.add('d-none');
            formContentEn.classList.add('d-none');
            textContentSw.classList.add('d-none');
            htmlContentSw.classList.add('d-none');
            imageContentSw.classList.add('d-none');
            
            // Show the relevant content fields
            if (contentType === 'text') {
                textContentEn.classList.remove('d-none');
                textContentSw.classList.remove('d-none');
            } else if (contentType === 'html') {
                htmlContentEn.classList.remove('d-none');
                htmlContentSw.classList.remove('d-none');
            } else if (contentType === 'image') {
                imageContentEn.classList.remove('d-none');
                imageContentSw.classList.remove('d-none');
            } else if (contentType === 'form') {
                formContentEn.classList.remove('d-none');
            }
        }
        
        typeSelect.addEventListener('change', toggleContentFields);
        toggleContentFields();
        
        // Initialize CKEditor
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