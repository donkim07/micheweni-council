{{-- templates/components/video.blade.php --}}
@php
    // Get video data from content
    $meta = is_string($content->meta) ? json_decode($content->meta, true) : [];
    if (empty($meta) && is_object($content->meta)) {
        $meta = (array) $content->meta;
    }
    
    // Extract properties with proper fallbacks
    $videoUrl = $meta['video_url'] ?? '';
    $videoType = $meta['video_type'] ?? 'youtube';
    $aspectRatio = $meta['aspect_ratio'] ?? '16by9';
    $autoplay = $meta['autoplay'] ?? false;
    $muted = $meta['muted'] ?? true;
    $loop = $meta['loop'] ?? false;
    $controls = $meta['controls'] ?? true;
    $caption = $meta['caption'] ?? '';
    
    // Calculate aspect ratio class
    $aspectRatioClass = 'ratio-' . $aspectRatio;
    
    // Extract video ID for embedded players
    $videoId = '';
    
    if ($videoType === 'youtube') {
        // Parse YouTube URL to get video ID
        preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $videoUrl, $matches);
        $videoId = isset($matches[1]) ? $matches[1] : '';
        
        // Build YouTube embed URL with parameters
        $params = [];
        if ($autoplay) $params[] = 'autoplay=1';
        if ($muted) $params[] = 'mute=1';
        if ($loop) $params[] = 'loop=1&playlist=' . $videoId;
        if (!$controls) $params[] = 'controls=0';
        
        $embeddedUrl = 'https://www.youtube.com/embed/' . $videoId;
        if (!empty($params)) {
            $embeddedUrl .= '?' . implode('&', $params);
        }
    } elseif ($videoType === 'vimeo') {
        // Parse Vimeo URL to get video ID
        preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches);
        $videoId = isset($matches[1]) ? $matches[1] : '';
        
        // Build Vimeo embed URL with parameters
        $params = [];
        if ($autoplay) $params[] = 'autoplay=1';
        if ($muted) $params[] = 'muted=1';
        if ($loop) $params[] = 'loop=1';
        if (!$controls) $params[] = 'controls=0';
        
        $embeddedUrl = 'https://player.vimeo.com/video/' . $videoId;
        if (!empty($params)) {
            $embeddedUrl .= '?' . implode('&', $params);
        }
    }
@endphp

<div class="video-component">
    @if($videoType === 'youtube' || $videoType === 'vimeo')
        @if($videoId)
            <div class="ratio {{ $aspectRatioClass }} rounded overflow-hidden shadow-sm">
                <iframe 
                    src="{{ $embeddedUrl }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                ></iframe>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ __('Invalid video URL. Please provide a valid YouTube or Vimeo URL.') }}
            </div>
        @endif
    @elseif($videoType === 'html5' && isset($meta['video_file']) && $meta['video_file'])
        <div class="ratio {{ $aspectRatioClass }} rounded overflow-hidden shadow-sm">
            <video 
                class="w-100 h-100" 
                {{ $controls ? 'controls' : '' }} 
                {{ $autoplay ? 'autoplay' : '' }} 
                {{ $muted ? 'muted' : '' }} 
                {{ $loop ? 'loop' : '' }}
            >
                <source src="{{ asset('images/' . $meta['video_file']) }}" type="video/mp4">
                {{ __('Your browser does not support HTML5 video.') }}
            </video>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            {{ __('Please provide a valid video source in the component settings.') }}
        </div>
    @endif
    
    @if($caption)
        <div class="video-caption text-muted small text-center mt-2">{{ $caption }}</div>
    @endif
</div>

<style>
.video-component {
    margin-bottom: 1rem;
}

.video-caption {
    font-style: italic;
    max-width: 90%;
    margin-left: auto;
    margin-right: auto;
}
</style> 