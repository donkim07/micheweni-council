@extends('layouts.admin')

@section('title', __('Statistics Settings'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Manage Statistics') }}</h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.government.site-config.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Configuration') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include('admin.partials.alerts')
                    
                    <form action="{{ route('admin.government.site-config.edit-stats') }}" method="POST" class="form" id="statsForm">
                        @csrf
                        
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('These statistics will be displayed on the homepage and other areas of the website. You can add, edit, or remove statistics as needed.') }}
                        </div>
                        
                        <div class="stats-container">
                            @php 
                                $statsArray = [];
                                // Convert associative array to indexed array for easier handling in JavaScript
                                if (is_array($stats)) {
                                    foreach($stats as $key => $value) {
                                        $statsArray[] = [
                                            'key' => $key,
                                            'value' => $value,
                                            'icon' => isset($statsIcons[$key]) ? $statsIcons[$key] : 'fa-chart-line'
                                        ];
                                    }
                                } else {
                                    // Initialize with default values if $stats is not an array
                                    $statsArray[] = [
                                        'key' => 'population',
                                        'value' => 95000,
                                        'icon' => 'fa-users'
                                    ];
                                }
                            @endphp
                            
                            @foreach($statsArray as $index => $stat)
                                <div class="stat-item card mb-3" data-index="{{ $index }}">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">{{ __('Statistic') }} #{{ $index + 1 }}</h5>
                                        @if(count($statsArray) > 1)
                                            <!-- <button type="button" class="btn btn-sm btn-danger remove-stat">
                                                <i class="fas fa-times"></i> {{ __('Remove') }}
                                            </button> -->
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Display Name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="stats[{{ $index }}][name]" class="form-control" 
                                                        value="{{ $stat['name'] ?? (isset($statsNames[$stat['key']]) ? $statsNames[$stat['key']] : ucwords(str_replace('_', ' ', $stat['key']))) }}" required>
                                                    <small class="text-muted">{{ __('The name displayed for this statistic') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Value') }} <span class="text-danger">*</span></label>
                                                    <input type="number" name="stats[{{ $index }}][value]" class="form-control" 
                                                        value="{{ $stat['value'] }}" required>
                                                    <small class="text-muted">{{ __('The numeric value for this statistic') }}</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('Icon') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas {{ $stat['icon'] }}"></i></span>
                                                        <input type="text" name="stats[{{ $index }}][icon]" class="form-control icon-input"
                                                            value="{{ $stat['icon'] }}" placeholder="fa-chart-line">
                                                        <button type="button" class="btn btn-outline-secondary icon-selector-btn">
                                                            <i class="fas fa-icons"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted">{{ __('FontAwesome icon class (e.g. fa-users, fa-building)') }}</small>
                                                </div>
                                            </div>
                                            <input type="hidden" name="stats[{{ $index }}][key]" value="{{ $stat['key'] }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mb-3">
                            <!-- <button type="button" class="btn btn-success" id="addStatBtn">
                                <i class="fas fa-plus-circle"></i> {{ __('Add Another Statistic') }}
                            </button> -->
                        </div>
                        
                        <hr>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Icon Selector Modal -->
<div class="modal fade" id="iconSelectorModal" tabindex="-1" aria-labelledby="iconSelectorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconSelectorModalLabel">{{ __('Select an Icon') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @php
                        $icons = [
                            'fa-users', 'fa-building', 'fa-school', 'fa-hospital', 
                            'fa-chart-line', 'fa-project-diagram', 'fa-concierge-bell', 
                            'fa-map-marked-alt', 'fa-money-bill-wave', 'fa-laptop-code',
                            'fa-balance-scale', 'fa-bullhorn', 'fa-search-dollar',
                            'fa-university', 'fa-graduation-cap', 'fa-heartbeat',
                            'fa-road', 'fa-leaf', 'fa-tint', 'fa-seedling',
                            'fa-umbrella-beach', 'fa-cog', 'fa-wrench', 'fa-tools'
                        ];
                    @endphp
                    
                    @foreach($icons as $icon)
                        <div class="col-3 col-md-2 mb-3">
                            <div class="icon-option p-3 text-center border rounded cursor-pointer" data-icon="{{ $icon }}" style="cursor: pointer;">
                                <i class="fas {{ $icon }} fa-2x"></i>
                                <div class="small mt-2">{{ $icon }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Stats page script loaded');
        
        // Add stat button functionality
        document.getElementById('addStatBtn').onclick = function() {
            console.log('Add stat button clicked');
            
            const statsContainer = document.querySelector('.stats-container');
            const statItems = document.querySelectorAll('.stat-item');
            const nextIndex = statItems.length;
            
            // Create new stat element
            const newStat = document.createElement('div');
            newStat.className = 'stat-item card mb-3';
            newStat.dataset.index = nextIndex;
            
            // Set HTML content
            newStat.innerHTML = `
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ __('Statistic') }} #${nextIndex + 1}</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-stat">
                        <i class="fas fa-times"></i> {{ __('Remove') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Display Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="stats[${nextIndex}][name]" class="form-control" required>
                                <small class="text-muted">{{ __('The name displayed for this statistic') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Value') }} <span class="text-danger">*</span></label>
                                <input type="number" name="stats[${nextIndex}][value]" class="form-control" value="0" required>
                                <small class="text-muted">{{ __('The numeric value for this statistic') }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Icon') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                    <input type="text" name="stats[${nextIndex}][icon]" class="form-control icon-input"
                                        value="fa-chart-line" placeholder="fa-chart-line">
                                    <button type="button" class="btn btn-outline-secondary icon-selector-btn">
                                        <i class="fas fa-icons"></i>
                                    </button>
                                </div>
                                <small class="text-muted">{{ __('FontAwesome icon class (e.g. fa-users, fa-building)') }}</small>
                            </div>
                        </div>
                        <input type="hidden" name="stats[${nextIndex}][key]" value="stat_${nextIndex}">
                    </div>
                </div>
            `;
            
            // Add to container
            statsContainer.appendChild(newStat);
            
            // Add event listener to the new remove button
            const removeBtn = newStat.querySelector('.remove-stat');
            removeBtn.onclick = function() {
                if (confirm('{{ __("Are you sure you want to remove this statistic?") }}')) {
                    this.closest('.stat-item').remove();
                    reindexStats();
                    updateRemoveButtons();
                }
            };
            
            // Add event listener to the new icon selector button
            const iconBtn = newStat.querySelector('.icon-selector-btn');
            iconBtn.onclick = function() {
                window.currentIconInput = this.previousElementSibling;
                const modal = new bootstrap.Modal(document.getElementById('iconSelectorModal'));
                modal.show();
            };
            
            // Update remove buttons visibility
            updateRemoveButtons();
        };
        
        // Add click handlers to existing remove buttons
        document.querySelectorAll('.remove-stat').forEach(function(btn) {
            btn.onclick = function() {
                if (confirm('{{ __("Are you sure you want to remove this statistic?") }}')) {
                    this.closest('.stat-item').remove();
                    reindexStats();
                    updateRemoveButtons();
                }
            };
        });
        
        // Add click handlers to existing icon selector buttons
        document.querySelectorAll('.icon-selector-btn').forEach(function(btn) {
            btn.onclick = function() {
                window.currentIconInput = this.previousElementSibling;
                const modal = new bootstrap.Modal(document.getElementById('iconSelectorModal'));
                modal.show();
            };
        });
        
        // Add click handlers to icon options in modal
        document.querySelectorAll('.icon-option').forEach(function(option) {
            option.onclick = function() {
                const icon = this.dataset.icon;
                if (window.currentIconInput) {
                    window.currentIconInput.value = icon;
                    const iconPreview = window.currentIconInput.closest('.input-group').querySelector('.input-group-text i');
                    if (iconPreview) {
                        iconPreview.className = 'fas ' + icon;
                    }
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('iconSelectorModal'));
                    if (modal) {
                        modal.hide();
                    }
                }
            };
        });
        
        // Function to reindex stats after removal
        function reindexStats() {
            const statItems = document.querySelectorAll('.stat-item');
            
            statItems.forEach(function(item, index) {
                // Update data-index
                item.dataset.index = index;
                
                // Update title
                const title = item.querySelector('.card-title');
                if (title) {
                    title.textContent = `{{ __('Statistic') }} #${index + 1}`;
                }
                
                // Update input names
                item.querySelectorAll('input[name^="stats["]').forEach(function(input) {
                    const name = input.name;
                    const newName = name.replace(/stats\[\d+\]/, `stats[${index}]`);
                    input.name = newName;
                });
            });
        }
        
        // Function to update remove buttons visibility
        function updateRemoveButtons() {
            const statItems = document.querySelectorAll('.stat-item');
            
            // Hide remove button if only one stat
            if (statItems.length <= 1) {
                statItems.forEach(function(item) {
                    const removeBtn = item.querySelector('.remove-stat');
                    if (removeBtn) {
                        removeBtn.style.display = 'none';
                    }
                });
            } else {
                // Show remove buttons if more than one stat
                statItems.forEach(function(item) {
                    const removeBtn = item.querySelector('.remove-stat');
                    if (removeBtn) {
                        removeBtn.style.display = 'block';
                    }
                });
            }
        }
        
        // Initialize
        updateRemoveButtons();
    });
</script>
@endpush
@endsection