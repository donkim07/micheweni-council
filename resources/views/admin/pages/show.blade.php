@extends('layouts.admin')

@section('title', __('Page Details'))

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ $page->title }}</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Details') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-file-alt me-1"></i>
                {{ __('Page Information') }}
            </div>
            <div>
                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                </a>
                
                <a href="#" class="btn btn-sm btn-danger" 
                   onclick="event.preventDefault(); if(confirm('{{ __('Are you sure you want to delete this page?') }}')) document.getElementById('delete-page-form').submit();">
                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                </a>
                
                <form id="delete-page-form" action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%">{{ __('Title') }}</th>
                                <td>{{ $page->title }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Slug') }}</th>
                                <td>{{ $page->slug }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Template') }}</th>
                                <td>{{ $page->template }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Parent Page') }}</th>
                                <td>{{ $page->parent ? $page->parent->title : __('None') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <td>
                                    @if($page->is_active)
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Menu Visibility') }}</th>
                                <td>
                                    @if($page->show_in_menu)
                                        <span class="badge bg-success">{{ __('Visible in Menu') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('Hidden from Menu') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Menu Order') }}</th>
                                <td>{{ $page->menu_order }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Created At') }}</th>
                                <td>{{ $page->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Last Updated') }}</th>
                                <td>{{ $page->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="fas fa-align-left me-1"></i>
                            {{ __('Description') }}
                        </div>
                        <div class="card-body">
                            @if($page->description)
                                {!! nl2br(e($page->description)) !!}
                            @else
                                <p class="text-muted font-italic">{{ __('No description provided.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if($page->contents && $page->contents->count() > 0)
                <div class="mt-4">
                    <h4>{{ __('Page Contents') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Order') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($page->contents as $content)
                                    <tr>
                                        <td>{{ $content->section }}</td>
                                        <td>{{ $content->content_type }}</td>
                                        <td>{{ $content->order }}</td>
                                        <td>
                                            <a href="{{ route('admin.contents.edit', $content->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('No content sections have been added to this page yet.') }}
                </div>
            @endif
            
            @if($page->children && $page->children->count() > 0)
                <div class="mt-4">
                    <h4>{{ __('Child Pages') }}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Template') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($page->children as $child)
                                    <tr>
                                        <td>{{ $child->title }}</td>
                                        <td>{{ $child->template }}</td>
                                        <td>
                                            @if($child->is_active)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pages.show', $child->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> {{ __('View') }}
                                            </a>
                                            <a href="{{ route('admin.pages.edit', $child->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 