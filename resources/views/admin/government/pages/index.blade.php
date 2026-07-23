@extends('layouts.admin')

@section('title', __('Government Pages'))

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Government Pages') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.government.dashboard') }}">{{ __('Government') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Pages') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('All Pages') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.government.pages.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> {{ __('Add New Page') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($pages) > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Slug') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Last Updated') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>{{ $page->title }}</td>
                                            <td>{{ $page->slug }}</td>
                                            <td>
                                                <span class="badge badge-{{ $page->status === 'published' ? 'success' : 'secondary' }}">
                                                    {{ $page->status }}
                                                </span>
                                            </td>
                                            <td>{{ $page->updated_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.government.pages.edit', $page->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.government.pages.show', $page->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.government.pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this page?') }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                {{ __('No government pages found. Click the "Add New Page" button to create one.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 