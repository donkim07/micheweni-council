@extends('layouts.admin')

@section('title', __('Create New Page'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Create New Page') }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Create') }}</li>
    </ol>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    {{ __('Page Details') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('title') is-invalid @enderror" id="title" 
                                        type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('Page Title') }}" required />
                                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('slug') is-invalid @enderror" id="slug" 
                                        type="text" name="slug" value="{{ old('slug') }}" placeholder="{{ __('page-slug') }}" />
                                    <label for="slug">{{ __('Slug') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('Leave empty to auto-generate from title') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('template') is-invalid @enderror" id="template" 
                                        name="template" required>
                                        <option value="">{{ __('Select a template') }}</option>
                                        @foreach($templates as $key => $label)
                                            <option value="{{ $key }}" @selected(old('template') == $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <label for="template">{{ __('Template') }} <span class="text-danger">*</span></label>
                                    @error('template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" 
                                        name="parent_id">
                                        <option value="">{{ __('No parent (top level page)') }}</option>
                                        @foreach($parentPages as $id => $title)
                                            <option value="{{ $id }}" @selected(old('parent_id') == $id)>{{ $title }}</option>
                                        @endforeach
                                    </select>
                                    <label for="parent_id">{{ __('Parent Page') }}</label>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" 
                                name="description" style="height: 100px" placeholder="{{ __('Page Description') }}">{{ old('description') }}</textarea>
                            <label for="description">{{ __('Description') }}</label>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" 
                                        id="is_active" name="is_active" value="1" @checked(old('is_active', true))>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('show_in_menu') is-invalid @enderror" type="checkbox" 
                                        id="show_in_menu" name="show_in_menu" value="1" @checked(old('show_in_menu', true))>
                                    <label class="form-check-label" for="show_in_menu">{{ __('Show in Menu') }}</label>
                                    @error('show_in_menu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control @error('menu_order') is-invalid @enderror" id="menu_order" 
                                        type="number" name="menu_order" value="{{ old('menu_order', 0) }}" placeholder="0" />
                                    <label for="menu_order">{{ __('Menu Order') }}</label>
                                    @error('menu_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Create Page') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    {{ __('Creating Pages: Step-by-Step Guide') }}
                </div>
                <div class="card-body">
                    <h5>{{ __('1. Create the Page') }}</h5>
                    <p class="small">{{ __('Fill out this form with your page details. Be sure to select if it should appear in navigation.') }}</p>
                    
                    <h5>{{ __('2. Add Content with Page Builder') }}</h5>
                    <p class="small">{{ __('After saving, you\'ll be redirected to the page edit screen. Click "Page Builder" to design your page.') }}</p>
                    
                    <h5>{{ __('3. Add Sections') }}</h5>
                    <p class="small">{{ __('In the builder, add sections like Hero, Cards, Grid Layouts using pre-made templates.') }}</p>
                    
                    <h5>{{ __('4. Add Components') }}</h5>
                    <p class="small">{{ __('Drag components (text, images, buttons) into your sections and configure them.') }}</p>
                    
                    <h5>{{ __('5. Preview and Publish') }}</h5>
                    <p class="small">{{ __('Use the preview tab to see how your page looks, then save and publish it.') }}</p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-lightbulb me-1"></i>
                    {{ __('Tips for Great Pages') }}
                </div>
                <div class="card-body">
                    <ul class="small ps-3">
                        <li>{{ __('Start with a compelling hero section') }}</li>
                        <li>{{ __('Use consistent styling throughout') }}</li>
                        <li>{{ __('Include images to break up text') }}</li>
                        <li>{{ __('Keep content focused and concise') }}</li>
                        <li>{{ __('Add clear calls to action') }}</li>
                        <li>{{ __('Test your page on mobile devices') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        if (!document.getElementById('slug').value) {
            let slug = this.value.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special chars
                .replace(/\s+/g, '-')     // Replace spaces with -
                .replace(/-+/g, '-');     // Replace multiple - with single -
            
            document.getElementById('slug').value = slug;
        }
    });
</script>
@endsection 