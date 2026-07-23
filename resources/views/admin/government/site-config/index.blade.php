@extends('layouts.admin')

@section('title', __('Site Configuration'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Site Configuration') }}</h4>
                    <div class="card-tools">
                        <!-- <a href="{{ route('admin.government.site-config.create', ['group' => $currentGroup]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('Add New Config') }}
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    <!-- Config Groups Tabs -->
                    <!-- <div class="mb-4 border-bottom">
                        <ul class="nav nav-tabs">
                            @foreach($configGroups as $group)
                                <li class="nav-item">
                                    <a href="{{ route('admin.government.site-config.index', ['group' => $group]) }}" 
                                       class="nav-link {{ $currentGroup == $group ? 'active' : '' }}">
                                        {{ ucfirst($group) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div> -->
                    
                    <!-- Shortcuts for special config groups -->
                    @if($currentGroup == 'general')
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.government.site-config.edit-contact') }}" class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-address-book fa-3x mb-3 text-primary"></i>
                                        <h5>{{ __('Contact Information') }}</h5>
                                        <p class="text-muted mb-0">{{ __('Manage site-wide contact details') }}</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.government.site-config.edit-social') }}" class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-share-alt fa-3x mb-3 text-primary"></i>
                                        <h5>{{ __('Social Media Links') }}</h5>
                                        <p class="text-muted mb-0">{{ __('Update social media accounts') }}</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.government.site-config.edit-leadership') }}" class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                                        <h5>{{ __('Leadership') }}</h5>
                                        <p class="text-muted mb-0">{{ __('Update leadership information') }}</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.government.site-config.edit-stats') }}" class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chart-bar fa-3x mb-3 text-primary"></i>
                                        <h5>{{ __('Statistics') }}</h5>
                                        <p class="text-muted mb-0">{{ __('Update homepage counters') }}</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin.government.site-config.edit-about') }}" class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-info-circle fa-3x mb-3 text-primary"></i>
                                        <h5>{{ __('About Information') }}</h5>
                                        <p class="text-muted mb-0">{{ __('Update mission, vision & core values') }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Configurations Table -->
                    <!-- <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Key') }}</th>
                                    <th>{{ __('Value') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Last Updated') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($configs as $config)
                                    <tr>
                                        <td>{{ $config->config_key }}</td>
                                        <td>
                                            @if($config->is_json)
                                                <span class="badge bg-info">{{ __('JSON Data') }}</span>
                                            @else
                                                <span>{{ Str::limit($config->config_value, 50) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $config->description }}</td>
                                        <td>
                                            @if($config->is_json)
                                                <span class="badge bg-success">JSON</span>
                                            @else
                                                <span class="badge bg-secondary">String</span>
                                            @endif
                                        </td>
                                        <td>{{ $config->updated_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.government.site-config.edit', $config->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.government.site-config.destroy', $config->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this configuration?') }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No configurations found in this group') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 