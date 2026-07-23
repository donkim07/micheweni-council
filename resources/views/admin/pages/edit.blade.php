@extends('layouts.admin')

@section('title', __('Edit Page'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Edit Page') }}: {{ $page->title }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Edit') }}</li>
    </ol>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    {{ __('Page Details') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('title') is-invalid @enderror" id="title" 
                                        type="text" name="title" value="{{ old('title', $page->title) }}" placeholder="{{ __('Page Title') }}" required />
                                    <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('slug') is-invalid @enderror" id="slug" 
                                        type="text" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="{{ __('page-slug') }}" />
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
                                            <option value="{{ $key }}" @selected(old('template', $page->template) == $key)>{{ $label }}</option>
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
                                            <option value="{{ $id }}" @selected(old('parent_id', $page->parent_id) == $id)>{{ $title }}</option>
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
                                name="description" style="height: 100px" placeholder="{{ __('Page Description') }}">{{ old('description', $page->description) }}</textarea>
                            <label for="description">{{ __('Description') }}</label>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" 
                                        id="is_active" name="is_active" value="1" @checked(old('is_active', $page->is_active))>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('show_in_menu') is-invalid @enderror" type="checkbox" 
                                        id="show_in_menu" name="show_in_menu" value="1" @checked(old('show_in_menu', $page->show_in_menu))>
                                    <label class="form-check-label" for="show_in_menu">{{ __('Show in Menu') }}</label>
                                    @error('show_in_menu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input class="form-control @error('menu_order') is-invalid @enderror" id="menu_order" 
                                        type="number" name="menu_order" value="{{ old('menu_order', $page->menu_order) }}" placeholder="0" />
                                    <label for="menu_order">{{ __('Menu Order') }}</label>
                                    @error('menu_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                <i class="fas fa-users me-1"></i>
                                {{ __('Visibility & Access Control') }}
                            </div>
                            <div class="card-body">
                                <p class="text-muted">{{ __('Select which user roles can view this page') }}</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="visibility_guest" 
                                                name="visibility_roles[]" value="guest" @checked(in_array('guest', old('visibility_roles', $page->visibility_roles ?? ['guest'])))>
                                            <label class="form-check-label" for="visibility_guest">{{ __('Guest (Public)') }}</label>
                                        </div>
                                    </div>
                                    @foreach($roles as $id => $name)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="visibility_{{ $name }}" 
                                                    name="visibility_roles[]" value="{{ $name }}" @checked(in_array($name, old('visibility_roles', $page->visibility_roles ?? ['guest'])))>
                                                <label class="form-check-label" for="visibility_{{ $name }}">{{ ucfirst($name) }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('visibility_roles')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Navigation Settings -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-bars me-1"></i>
                                {{ __('Navigation Settings') }}
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="show_in_navigation" name="show_in_navigation" value="1" @checked(old('show_in_navigation', $page->show_in_navigation))>
                                    <label class="form-check-label" for="show_in_navigation">{{ __('Show in Navigation') }}</label>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="navigation_order" type="number" name="navigation_order" value="{{ old('navigation_order', $page->navigation_order) }}" placeholder="{{ __('Navigation Order') }}">
                                    <label for="navigation_order">{{ __('Navigation Order') }}</label>
                                    <div class="form-text">{{ __('Lower numbers appear first in the navigation menu') }}</div>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_dropdown_parent" name="meta_data[is_dropdown_parent]" value="1" @checked(old('meta_data.is_dropdown_parent', $page->meta_data['is_dropdown_parent'] ?? false))>
                                    <label class="form-check-label" for="is_dropdown_parent">{{ __('Is Dropdown Menu Parent') }}</label>
                                    <div class="form-text">{{ __('If checked, this page will be a dropdown menu in the navigation') }}</div>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="nav_title" type="text" name="meta_data[nav_title]" value="{{ old('meta_data.nav_title', $page->meta_data['nav_title'] ?? '') }}" placeholder="{{ __('Navigation Title') }}">
                                    <label for="nav_title">{{ __('Navigation Title') }}</label>
                                    <div class="form-text">{{ __('Optional: Use a different title in the navigation menu (leave empty to use page title)') }}</div>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="nav_position" name="meta_data[nav_position]">
                                        <option value="main" @selected(old('meta_data.nav_position', $page->meta_data['nav_position'] ?? 'main') == 'main')>{{ __('Main Navigation') }}</option>
                                        <option value="footer" @selected(old('meta_data.nav_position', $page->meta_data['nav_position'] ?? 'main') == 'footer')>{{ __('Footer Navigation') }}</option>
                                        <option value="both" @selected(old('meta_data.nav_position', $page->meta_data['nav_position'] ?? 'main') == 'both')>{{ __('Both Main and Footer') }}</option>
                                    </select>
                                    <label for="nav_position">{{ __('Navigation Position') }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 mb-0">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Update Page') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-tools me-1"></i>
                    {{ __('Page Actions') }}
                </div>
                <div class="card-body">
                    <div class="list-group mb-4">
                        <a href="{{ route('admin.layout.builder', $page->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-palette me-2"></i> {{ __('Page Builder') }}
                                <small class="d-block text-muted">{{ __('Design page layout with drag-and-drop') }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </a>
                        
                        <a href="{{ route('admin.contents.index', ['page_id' => $page->id]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-puzzle-piece me-2"></i> {{ __('Manage Content') }}
                                <small class="d-block text-muted">{{ __('Add or edit page contents') }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $page->contents->count() }}</span>
                        </a>
                        
                        <a href="{{ route('admin.pages.show', $page->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-eye me-2"></i> {{ __('View Page Details') }}
                                <small class="d-block text-muted">{{ __('See all information about this page') }}</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>
                    
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Public URL') }}</h5>
                            <p class="card-text">
                                <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="text-truncate d-inline-block w-100">
                                    {{ route('page.show', $page->slug) }} <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </p>
                            <p class="text-muted small mb-0">{{ __('Open in a new tab to preview the page') }}</p>
                        </div>
                    </div>
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
        let slugField = document.getElementById('slug');
        if (!slugField.value || slugField.dataset.autoGenerated) {
            let slug = this.value.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special chars
                .replace(/\s+/g, '-')     // Replace spaces with -
                .replace(/-+/g, '-');     // Replace multiple - with single -
            
            slugField.value = slug;
            slugField.dataset.autoGenerated = 'true';
        }
    });
    
    // Track manual changes to slug
    document.getElementById('slug').addEventListener('input', function() {
        if (this.value && this.value !== '') {
            this.dataset.autoGenerated = '';
        }
    });
</script>
@endsection 