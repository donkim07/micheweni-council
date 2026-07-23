<!-- Video Component -->
@php
    $url = $content->meta->url ?? '';
    $title = $content->meta->title ?? '';
    $poster = $content->meta->poster ?? '';
    $autoplay = $content->meta->autoplay ?? false;
    $controls = $content->meta->controls ?? true;
    $loop = $content->meta->loop ?? false;
    $muted = $content->meta->muted ?? false;
    $template = $content->template ?? 'standard';
    $class = $content->meta->css_class ?? '';
    
    // Extract video ID from common video platforms
    $videoId = '';
    $videoType = 'custom';
    
    if (!empty($url)) {
        // YouTube
        if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
            $videoType = 'youtube';
        }
        // Vimeo
        elseif (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|)(\d+)(?:|\/\?)/', $url, $matches)) {
            $videoId = $matches[1];
            $videoType = 'vimeo';
        }
    }
@endphp

<div class="video-component {{ $class }} {{ $template }}-template">
    @if($title)
        <h4 class="video-title">{{ $title }}</h4>
    @endif
    
    <div class="video-container">
        @if($videoType == 'youtube' && $videoId)
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" 
                        src="https://www.youtube.com/embed/{{ $videoId }}?rel=0{{ $autoplay ? '&autoplay=1' : '' }}{{ $loop ? '&loop=1' : '' }}{{ $muted ? '&mute=1' : '' }}" 
                        allowfullscreen></iframe>
            </div>
        @elseif($videoType == 'vimeo' && $videoId)
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" 
                        src="https://player.vimeo.com/video/{{ $videoId }}{{ $autoplay ? '?autoplay=1' : '' }}{{ $loop ? ($autoplay ? '&' : '?') . 'loop=1' : '' }}{{ $muted ? ($autoplay || $loop ? '&' : '?') . 'muted=1' : '' }}" 
                        allowfullscreen></iframe>
            </div>
        @elseif($url)
            <video class="video-player w-100" 
                   {{ $poster ? 'poster=' . asset('storage/' . $poster) : '' }}
                   {{ $controls ? 'controls' : '' }}
                   {{ $autoplay ? 'autoplay' : '' }}
                   {{ $loop ? 'loop' : '' }}
                   {{ $muted ? 'muted' : '' }}>
                <source src="{{ $url }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <div class="alert alert-info">
                <i class="fas fa-video me-2"></i> No video URL provided
            </div>
        @endif
    </div>
</div> 