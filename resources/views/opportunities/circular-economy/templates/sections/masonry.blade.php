{{-- templates/sections/masonry.blade.php --}}
{{-- Template for a masonry section layout --}}

<div id="section-{{ $section->identifier }}" class="content-section masonry-section {{ $section->css_class }}"
     style="background-color: {{ $section->background_color }}; 
            color: {{ $section->text_color }}; 
            padding: {{ $section->padding }};"
     data-section-type="masonry">
    
    <div class="container py-5">
        @if($section->title)
            <h2 class="section-title text-center mb-5 fw-bold">{{ $section->title }}</h2>
        @endif
        
        @php
            // Get masonry settings
            $gapSize = $section->gap_size ?? 'medium';
            
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
        
        <div class="masonry-grid {{ $spacingClass }}">
            @foreach($contents as $content)
                <div class="masonry-item animate-on-scroll" data-delay="{{ $loop->index * 100 }}">
                    <div class="masonry-content h-100">
                        @include('templates.components.' . ($content->template_identifier ?: $content->type), ['content' => $content])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .masonry-section {
        padding: 3rem 0;
    }
    
    .masonry-section .section-title {
        position: relative;
        padding-bottom: 15px;
    }
    
    .masonry-section .section-title:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: var(--primary-color, #198754);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .masonry-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-gap: 20px;
        grid-auto-flow: dense;
    }
    
    .masonry-grid.g-2 {
        grid-gap: 8px;
    }
    
    .masonry-grid.g-4 {
        grid-gap: 20px;
    }
    
    .masonry-grid.g-5 {
        grid-gap: 30px;
    }
    
    /* Create variation in item heights */
    .masonry-grid .masonry-item:nth-child(3n+1) {
        grid-row: span 1;
    }
    
    .masonry-grid .masonry-item:nth-child(3n+2) {
        grid-row: span 1;
    }
    
    .masonry-grid .masonry-item:nth-child(3n+3) {
        grid-row: span 1;
    }
    
    .masonry-grid .masonry-item:nth-child(6n+4) {
        grid-column: span 2;
    }
    
    .masonry-content {
        height: 100%;
        width: 100%;
    }
    
    .masonry-section .animate-on-scroll {
        opacity: 1;
        transform: translateY(20px);
        transition: opacity 2.9s ease, transform 1.9s ease;
    }
    
    .masonry-section .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }
    
    @media (max-width: 767px) {
        .masonry-grid {
            display: flex;
            flex-direction: column;
        }
        
        .masonry-grid .masonry-item {
            margin-bottom: 20px;
        }
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
        
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush 