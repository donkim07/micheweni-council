{{-- templates/sections/columns.blade.php --}}
{{-- Template for a columns section layout --}}

<div id="section-{{ $section->identifier }}" class="content-section columns-section {{ $section->css_class }}"
     style="background-color: {{ $section->background_color }}; 
            color: {{ $section->text_color }}; 
            padding: {{ $section->padding }};"
     data-section-type="columns">
    
    <div class="container py-5">
        @if($section->title)
            <h2 class="section-title text-center mb-5 fw-bold">{{ $section->title }}</h2>
        @endif
        
        @php
            // Get columns settings
            $columns = $section->columns ?? 3;
            $gapSize = $section->gap_size ?? 'medium';
            
            // Set column classes based on number of columns
            $columnClass = match((int) $columns) {
                1 => 'col-12',
                2 => 'col-md-6',
                3 => 'col-md-4',
                4 => 'col-md-6 col-lg-3',
                default => 'col-md-4',
            };
            
            // Get spacing class
            $spacingClass = '';
            if ($gapSize === 'small') {
                $spacingClass = 'g-2';
            } elseif ($gapSize === 'medium') {
                $spacingClass = 'g-4';
            } elseif ($gapSize === 'large') {
                $spacingClass = 'g-5';
            }
        @endphp
        
        <div class="row {{ $spacingClass }} justify-content-center">
            @foreach($contents as $content)
                <div class="{{ $columnClass }} mb-4 animate-on-scroll" data-delay="{{ $loop->index * 100 }}">
                    <div class="column-content h-100">
                        @include('templates.components.' . ($content->template_identifier ?: $content->type), ['content' => $content])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .columns-section {
        padding: 3rem 0;
    }
    
    .columns-section .section-title {
        position: relative;
        padding-bottom: 15px;
    }
    
    .columns-section .section-title:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: var(--primary-color, #198754);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .columns-section .column-content {
        height: 100%;
        display: flex;
        flex-direction: column;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .columns-section .animate-on-scroll {
        opacity: 1;
        transform: translateY(20px);
        transition: opacity 2.9s ease, transform 1.9s ease;
    }
    
    .columns-section .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    .columns-section .content-card,
    .columns-section .text-component,
    .columns-section .image-component,
    .columns-section .form-standard-wrapper {
        height: 100%;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.delay || 0;
                    setTimeout(() => {
                        entry.target.classList.add('animated');
                    }, delay);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        document.querySelectorAll('.columns-section .animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush 