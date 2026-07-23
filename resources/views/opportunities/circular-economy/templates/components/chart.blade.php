{{-- templates/components/chart.blade.php --}}
@php
    // Get chart data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $chartType = $meta['chart_type'] ?? 'bar';
    $labels = $meta['labels'] ?? [];
    $datasets = $meta['datasets'] ?? [];
    $title = $meta['title'] ?? '';
    $description = $meta['description'] ?? '';
    $height = $meta['height'] ?? '300px';
    
    // Determine template style based on chart type
    $templateStyle = $content->template_identifier ?: $chartType;
    
    // Generate a unique ID for the chart
    $chartId = 'chart-' . md5(json_encode($meta) . time() . rand(1000, 9999));
    
    // Default colors
    $defaultColors = [
        'rgba(25, 135, 84, 0.7)',   // primary green
        'rgba(13, 110, 253, 0.7)',  // blue
        'rgba(220, 53, 69, 0.7)',   // red
        'rgba(255, 193, 7, 0.7)',   // yellow
        'rgba(111, 66, 193, 0.7)',  // purple
        'rgba(23, 162, 184, 0.7)',  // cyan
        'rgba(108, 117, 125, 0.7)'  // gray
    ];
@endphp

<div class="chart-component {{ $templateStyle }}-chart">
    @if($title)
        <h5 class="chart-title">{{ $title }}</h5>
    @endif
    
    <div class="chart-container" style="height: {{ $height }}; width: 100%;">
        <canvas id="{{ $chartId }}"></canvas>
    </div>
    
    @if($description)
        <div class="chart-description text-muted small mt-2">{{ $description }}</div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            // Load Chart.js if not already loaded
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js';
            script.onload = function() {
                initChart();
            };
            document.head.appendChild(script);
        } else {
            initChart();
        }
        
        function initChart() {
            const ctx = document.getElementById('{{ $chartId }}').getContext('2d');
            
            // Prepare datasets with colors
            const chartDatasets = [];
            @if(is_array($datasets))
                @foreach($datasets as $index => $dataset)
                    chartDatasets.push({
                        label: '{{ $dataset["label"] ?? "Dataset " . ($index + 1) }}',
                        data: {!! json_encode($dataset["data"] ?? []) !!},
                        backgroundColor: '{{ $dataset["color"] ?? $defaultColors[$index % count($defaultColors)] }}',
                        borderColor: '{{ $dataset["border_color"] ?? str_replace("0.7", "1", ($dataset["color"] ?? $defaultColors[$index % count($defaultColors)])) }}',
                        borderWidth: 1
                    });
                @endforeach
            @endif
            
            new Chart(ctx, {
                type: '{{ $templateStyle }}',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: chartDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

<style>
.chart-component {
    margin-bottom: 1.5rem;
}

.chart-title {
    margin-bottom: 1rem;
}

.chart-container {
    position: relative;
    margin: 0 auto;
}

.chart-description {
    margin-top: 0.5rem;
    text-align: center;
    font-style: italic;
}
</style> 