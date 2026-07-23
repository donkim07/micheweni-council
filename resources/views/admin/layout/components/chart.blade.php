<!-- Chart Component -->

@php
    // Check if we're in preview mode
    $isPreview = Request::is('*preview*') || isset($request) && $request->has('preview_mode');
    
    // Extract values with defaults for preview
    $chartId = 'chart_' . ($content->id ?? uniqid());
    $chartType = $content->meta->chart_type ?? ($isPreview ? 'bar' : '');
    $chartTitle = $content->meta->title ?? ($isPreview ? 'Sample Chart' : '');
    
    // Process data and labels from string to array if needed
    $chartData = $content->meta->data ?? null;
    if (is_string($chartData) && !empty($chartData)) {
        $chartData = array_map('trim', explode(',', $chartData));
        // Convert to numeric values
        $chartData = array_map('floatval', $chartData);
    }
    
    $chartLabels = $content->meta->labels ?? null;
    if (is_string($chartLabels) && !empty($chartLabels)) {
        $chartLabels = array_map('trim', explode(',', $chartLabels));
    }
    
    $chartHeight = $content->meta->height ?? '400px';
    $datasetLabel = $content->meta->dataset_label ?? 'Data';
    $legendPosition = $content->meta->legend_position ?? 'top';
    $showGridLines = $content->meta->show_grid_lines ?? true;
    $advancedOptions = $content->meta->advanced_options ?? null;
    $template = $content->template ?? 'standard';
    
    // For preview, generate sample data
    if (($isPreview && empty($chartData)) || empty($chartLabels)) {
        if ($chartType == 'pie' || $chartType == 'doughnut' || $chartType == 'polarArea') {
            $chartLabels = ['Red', 'Blue', 'Yellow', 'Green', 'Purple'];
            $chartData = [12, 19, 3, 5, 2];
        } else {
            $chartLabels = ['January', 'February', 'March', 'April', 'May', 'June'];
            $chartData = [65, 59, 80, 81, 56, 55];
        }
    }
@endphp

<div class="chart-component {{ $template }} {{ $content->meta->css_class ?? '' }}">
    @if($chartTitle)
        <h4 class="chart-title">{{ $chartTitle }}</h4>
    @endif
    
    <div class="chart-container" style="position: relative; height: {{ $chartHeight }};">
        @if($chartData && $chartLabels)
            <canvas id="{{ $chartId }}"></canvas>
        @else
            <div class="alert alert-warning">
                {{ __('Chart data not configured. Please provide labels and data in the component settings.') }}
            </div>
        @endif
    </div>
</div>

@if($chartData && $chartLabels)
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (!document.getElementById('{{ $chartId }}')) return;
    
    const ctx = document.getElementById('{{ $chartId }}').getContext('2d');
    
    // Prepare datasets
    let datasets = [];
    @if(is_array($chartData) && isset($chartData[0]) && is_array($chartData[0]))
        // Multiple datasets
        @foreach($chartData as $index => $dataset)
            datasets.push({
                label: '{{ $content->meta->dataset_labels[$index] ?? "Dataset " . ($index + 1) }}',
                data: {{ json_encode($dataset) }},
                @if($chartType !== 'pie' && $chartType !== 'doughnut' && $chartType !== 'polarArea')
                backgroundColor: 'rgba({{ 55 + ($index * 40) }}, {{ 125 - ($index * 20) }}, {{ 200 - ($index * 30) }}, 0.2)',
                borderColor: 'rgba({{ 55 + ($index * 40) }}, {{ 125 - ($index * 20) }}, {{ 200 - ($index * 30) }}, 1)',
                @else
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                @endif
                borderWidth: 1
            });
        @endforeach
    @else
        // Single dataset
        datasets.push({
            label: '{{ $datasetLabel }}',
            data: {{ json_encode($chartData) }},
            @if($chartType !== 'pie' && $chartType !== 'doughnut' && $chartType !== 'polarArea')
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            @else
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            @endif
            borderWidth: 1
        });
    @endif
    
    // Get Chart.js if not already loaded
    if (typeof Chart === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = createChart;
        document.head.appendChild(script);
    } else {
        createChart();
    }
    
    function createChart() {
        // Parse advanced options if provided
        let advancedOpts = {};
        @if($advancedOptions)
            try {
                advancedOpts = JSON.parse('{{ $advancedOptions }}');
            } catch(e) {
                console.error('Invalid chart options JSON:', e);
            }
        @endif
        
        // Create chart with options
        new Chart(ctx, {
            type: '{{ $chartType }}',
            data: {
                labels: {{ json_encode($chartLabels) }},
                datasets: datasets
            },
            options: Object.assign({
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: {{ $legendPosition !== 'false' ? 'true' : 'false' }},
                        position: '{{ $legendPosition !== 'false' ? $legendPosition : 'top' }}'
                    },
                    title: {
                        display: {{ $chartTitle ? 'true' : 'false' }},
                        text: '{{ $chartTitle }}'
                    }
                },
                scales: {
                    @if($chartType !== 'pie' && $chartType !== 'doughnut' && $chartType !== 'polarArea')
                    x: {
                        grid: {
                            display: {{ $showGridLines ? 'true' : 'false' }}
                        }
                    },
                    y: {
                        grid: {
                            display: {{ $showGridLines ? 'true' : 'false' }}
                        },
                        beginAtZero: true
                    }
                    @endif
                }
            }, advancedOpts)
        });
    }
});
</script>
@endif 