{{-- templates/sections/standard.blade.php --}}
{{-- Template for a standard (single column) section layout --}}

<div id="section-{{ $section->identifier }}" class="content-section standard-section {{ $section->css_class }}"
     style="background-color: {{ $section->background_color }}; 
            color: {{ $section->text_color }}; 
            padding: {{ $section->padding }};"
     data-section-type="standard">
    
    <div class="container py-5">
        @if($section->title)
            <h2 class="section-title text-center mb-5 fw-bold">{{ $section->title }}</h2>
        @endif
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @foreach($contents as $content)
                    <div class="standard-content mb-5 animate-on-scroll" data-delay="{{ $loop->index * 200 }}">
                        @include('templates.components.' . ($content->template_identifier ?: $content->type), ['content' => $content])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .standard-section {
        padding: 4rem 0;
    }
    
    .standard-section .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    
    .standard-section .section-title:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: var(--primary-color, #198754);
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .standard-section .standard-content:not(:last-child) {
        margin-bottom: 2rem;
    }
    
    .standard-section .animate-on-scroll {
        opacity: 1;
        transform: translateY(20px);
        transition: opacity 2.9s ease, transform 1.9s ease;
    }
    
    .standard-section .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
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
        
        document.querySelectorAll('.standard-section .animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endpush 