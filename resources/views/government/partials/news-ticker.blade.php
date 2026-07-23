<style>
.news-ticker {
    background-color: var(--primary);
    padding: 0;
    overflow: hidden;
    position: relative;
    height: 40px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.news-ticker-container {
    width: 100%;
    height: 100%;
    overflow: hidden;
    position: relative;
}

.news-ticker-label {
    background-color: var(--accent);
    color: var(--dark);
    font-weight: bold;
    padding: 10px 15px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    top: 0;
    z-index: 2;
    width: 120px;
}

.ticker-items-container {
    height: 100%;
    width: calc(100% - 140px);
    margin-left: 140px;
    position: relative;
    overflow: hidden;
}

@keyframes tickerScroll {
    0%, 5% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

.ticker-items-wrapper {
    display: flex;
    align-items: center;
    position: absolute;
    height: 100%;
    white-space: nowrap;
    animation: tickerScroll 15s linear infinite;
    /* Ensure the animation plays immediately */
    animation-play-state: running;
    /* left: 0; Start from the left edge of the container */
}

/* Pause animation when hovered */
.ticker-items-container:hover .ticker-items-wrapper {
    animation-play-state: paused;
}

.ticker-item {
    display: inline-flex;
    align-items: center;
    font-size: 14px;
    padding: 0 30px 0 15px;
    height: 100%;
    white-space: nowrap;
}

.ticker-item a {
    color: white;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
}

.ticker-item a:hover {
    opacity: 0.8;
}

.ticker-item-time {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
    padding: 2px 6px;
    margin-right: 10px;
    font-size: 12px;
}

.ticker-item.critical {
    background-color: var(--accent);
}

.ticker-item.critical a {
    color: var(--dark);
}

.ticker-item.critical .ticker-item-time {
    background-color: rgba(0, 0, 0, 0.1);
    color: var(--dark);
}

.ticker-item-critical-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    background-color: #ff4757;
    color: white;
    border-radius: 3px;
    padding: 0px 6px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
}
</style>

@if(isset($tickerNews) && $tickerNews->count() > 0)
<div class="news-ticker">
    <div class="news-ticker-container">
        <div class="news-ticker-label">
            <i class="fas fa-bullhorn me-2"></i> {{ __('News') }}
        </div>
        
        <div class="ticker-items-container">
            <div class="ticker-items-wrapper">
                @foreach($tickerNews as $item)
                    <div class="ticker-item {{ $item->is_critical ? 'critical' : '' }}">
                        <a href="{{ url('/government/news-new/' . $item->id) }}">
                            @if($item->is_critical)
                            <span class="ticker-item-critical-badge">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ __('Important') }}
                            </span>
                            @endif
                            
                            <span class="ticker-item-time">
                                {{ $item->published_at ? $item->published_at->format('d M') : now()->format('d M') }}
                            </span>
                            
                            <span class="ticker-item-title">{{ $item->title }}</span>
                        </a>
                    </div>
                @endforeach
                
                <!-- Duplicate items to make the scroll seamless -->
                @foreach($tickerNews as $item)
                    <div class="ticker-item {{ $item->is_critical ? 'critical' : '' }}">
                        <a href="{{ url('/government/news-new/' . $item->id) }}">
                            @if($item->is_critical)
                            <span class="ticker-item-critical-badge">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ __('Important') }}
                            </span>
                            @endif
                            
                            <span class="ticker-item-time">
                                {{ $item->published_at ? $item->published_at->format('d M') : now()->format('d M') }}
                            </span>
                            
                            <span class="ticker-item-title">{{ $item->title }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Adjust animation speed based on content length
    const tickerWrapper = document.querySelector('.ticker-items-wrapper');
    if (tickerWrapper) {
        const wrapperWidth = tickerWrapper.scrollWidth;
        const containerWidth = document.querySelector('.ticker-items-container').offsetWidth;
        
        // Calculate a reasonable animation duration based on content
        // The larger the content, the longer the duration
        const baseDuration = 35; // Base duration in seconds
        const calculatedDuration = Math.max(
            baseDuration, 
            Math.min(60, baseDuration * (wrapperWidth / containerWidth / 2))
        );
        
        tickerWrapper.style.animationDuration = calculatedDuration + 's';
    }
});
</script>
@endif 