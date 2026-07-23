<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }} Newsletter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #198754;
            color: white;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
        .greeting {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .news-item {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .news-item:last-child {
            border-bottom: none;
        }
        .news-title {
            color: #198754;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .news-date {
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .news-excerpt {
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            background-color: #198754;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 12px;
        }
        .unsubscribe {
            color: #999;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name') }}" class="logo">
            <h1>{{ config('app.name') }} Newsletter</h1>
        </div>
        
        <div class="greeting">
            <p>Hello {{ $subscriber->name ?? 'Valued Subscriber' }},</p>
            <p>Here are the latest updates from Micheweni Waste Portal:</p>
        </div>
        
        @if($newsItems->count() > 0)
            @foreach($newsItems as $news)
                <div class="news-item">
                    <h2 class="news-title">{{ $news->title }}</h2>
                    <div class="news-date">{{ $news->published_at->format('F j, Y') }}</div>
                    <div class="news-excerpt">{{ $news->excerpt }}</div>
                    <a href="{{ route('opportunities.circular-economy.news.show', $news->slug) }}" class="btn">Read More</a>
                </div>
            @endforeach
        @else
            <p>There are no new updates at this time. Check back soon!</p>
        @endif
        
        <div style="margin: 30px 0; text-align: center;">
            <a href="{{ route('opportunities.circular-economy.waste.map') }}" class="btn">View Waste Map</a>
        </div>
        
        <div class="footer">
            <p>Thank you for subscribing to our newsletter!</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>
                <a href="{{ route('opportunities.circular-economy.newsletter.unsubscribe', ['email' => $subscriber->email]) }}" class="unsubscribe">
                    Unsubscribe from newsletters
                </a>
            </p>
        </div>
    </div>
</body>
</html> 